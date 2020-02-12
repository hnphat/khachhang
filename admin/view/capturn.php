<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 24/10/2019
 * Time: 3:07 PM
 */
$upload = new Apps_Class_Upload();
$vote = new Apps_Control_Vote();
$picture = new Apps_Control_Picture();
$date = (isset($_SESSION['date_chosen'])) ? $_SESSION['date_chosen'] : date('d-m-Y');
if (isset($_POST['find'])) {
    $_SESSION['date_chosen'] = $_POST['date_'];
} else {
    $_SESSION['date_chosen'] = $date;
}
$guest = new Apps_Control_Guest();
$service = new Apps_Control_Service();
if ($_SESSION['per'] != 5)
    $query = [
        "select" => "*",
        "where" => "guest_type != 1"
    ]; else $query = [
    "select" => "*",
    "where" => "guest_type = 1"
];
$guest->setQuery($query);
$dataGuest = $guest->getResultFromSelectQuery($guest->queryData());
?>
<p><span class='fa fa-camera' style='font-size: 12pt;color:red;'> Chưa gửi ảnh</span></p>
<p><span class='fa fa-camera' style='font-size: 12pt;color:blue;'> Đã gửi ảnh</span></p>
<br>
<form action="index.php?mod=capturn" method="post">
    <span style="font-weight: bold;">Tìm từ:</span> <input type="date" name="date_" style="padding: 5px 10px;"
                                                           value="<?php if (isset($_SESSION['date_chosen'])) echo date('Y-m-d', strtotime($_SESSION['date_chosen'])); else echo date('Y-m-d'); ?>"/>
    <input type="submit" name="find" value="Tìm"
           style="padding: 10px 20px; border-radius: 5px; background-color: goldenrod; color: black; font-weight: bold;"/>
</form><br>
<script>
    function show(_id) {
        document.getElementById("fuser").style.display = "block";
        document.getElementById("g_id").value = _id;
    }

    function hide() {
        document.getElementById("fuser").style.display = "none";
    }
</script>
<form id="fuser" style="max-width: 350px;" action="index.php?mod=capturn" method="post" autocomplete="off"
      enctype="multipart/form-data">
    <p style="text-align: right;"><span class="btn-del" onclick="hide()">X</span></p>
    <div>
        <label for="hinhanh"> Chọn file ảnh: </label>
        <input type="file" id="file" name="file" required="required"/>
    </div>
    <input type="hidden" id="g_id" name="g_id"/>
    <input type="submit" name="add" value="Xác nhận"/>
</form><br>
<div style="overflow-x: auto;">
    <table class="tb-user">
        <tr>
            <th>STT</th>
            <th>Khách hàng</th>
            <th>Số xe/Số khung</th>
            <th>Dịch vụ</th>
            <th>Ghi chú</th>
            <th>Tác vụ</th>
        </tr>
        <?php
        $temp = 1;
        for ($i = 0; $i < count($dataGuest); $i++) {
            $date_guest = strtotime($dataGuest[$i]['guest_date']);
            $date_find = strtotime($_SESSION['date_chosen']);
            $query = [
                "select" => "*",
                "where" => "picture_guest = '" . $dataGuest[$i]['guest_id'] . "'"
            ];
            $picture->setQuery($query);
            $result = $picture->queryData();
            $exist_picture = $picture->isExistRow($result);
            $count = 0;
            if ($exist_picture)
                $count = count($picture->getResultFromSelectQuery($result));
            $color = ($exist_picture == true) ? "color:blue;" : "color:red;";
            if ($date_guest >= $date_find) {
                $cmd = [
                    "select" => "*",
                    "where" => "service_id = '" . $dataGuest[$i]['guest_type'] . "'"
                ];
                $service->setQuery($cmd);
                $name = $service->getResultFromSelectQuery($service->queryData());
                $type = "<td class='kd'>" . $name[0]['service_name'] . "</td>";
                echo "<tr>
            <td>" . ($temp++) . "</td>
            <td>" . $dataGuest[$i]['guest_name'] . "</td>
            <td>" . $dataGuest[$i]['guest_number_car'] . "</td>
           $type
            <td>" . $dataGuest[$i]['guest_comment'] . "</td>
           <td><span onclick=\"show('" . $dataGuest[$i]['guest_id'] . "');\" class=\"fa fa-camera\" style=\"font-size: 18pt;cursor: pointer;$color\"></span>&nbsp;<span style='font-weight: bold;'>$count</span></td>
        </tr>";
            }
        }
        ?>
    </table>
</div>
<?php
if (isset($_POST['add'])) {
    $guest_id = (isset($_POST['g_id']) ? $_POST['g_id'] : 0);
    $_file = (isset($_FILES['file']) ? $_FILES['file'] : null);
    $upload->setFile($_file);
    $upload->generateFolderAndFileName();
    $url = $upload->getFileName();
    $upload->upload();
    $param = [
        "picture_guest" => $guest_id,
        "picture_src" => $url
    ];
    $query = [
        "select" => "*",
        "where" => "vote_guest = '".$guest_id."'"
    ];
    $vote->setQuery($query);
    $flag = $vote->isExistRow($vote->queryData());
    if ($flag) {
        $param2 = [
                "guest_have_image" => 1
        ];
        $query2 = [
                "where" => "guest_id = '".$guest_id."'"
        ];
        $guest->setQuery($query2);
        $guest->setParam($param2);
        $guest->updateData();
    }
    $picture->setParam($param);
    if ($picture->createData()) {
        echo "<script>alert('Đã tải ảnh lên');window.open('index.php?mod=capturn','_self');</script>";
    } else {
        echo "<script>alert('Đã có lỗi xảy ra, liên hệ IT để được xử lý');window.open('index.php?mod=capturn','_self');</script>";
    }
}
?>
