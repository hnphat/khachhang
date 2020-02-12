<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 18/10/2019
 * Time: 3:17 PM
 */
if (!isset($_SESSION['per']) || ($_SESSION['per'] != 1 && $_SESSION['per'] != 4))
    echo "<script>window.open('index.php','_self');</script>";
$guest = new Apps_Control_Guest();
$service = new Apps_Control_Service();
$vote = new Apps_Control_Vote();
$param_find = date('01-01-2019');
$date = (isset($_SESSION['date_chosen'])) ? $_SESSION['date_chosen'] : date('d-m-Y');
if (isset($_POST['find'])) {
    $_SESSION['date_chosen'] = $_POST['date_'];
} else {
    $_SESSION['date_chosen'] = $date;
}
$query = [
    "select" => "*"
];
if (isset($_POST['find_num'])) {
    $num = (isset($_POST['number_car'])) ? $_POST['number_car'] : "";
    if ($_SESSION['id_user'] == 1 || $_SESSION['per'] == 4)
        $query = [
            "select" => "*",
            "where" => "guest_number_car like '%" . $num . "%' or guest_number_car like '" . $num . "%' or guest_number_car like '%" . $num . "'"
        ];
    else
        $query = [
            "select" => "*",
            "where" => "guest_user_create = '" . $_SESSION['id_user'] . "' and guest_number_car like '%" . $num . "%'"
        ];
}
$guest->setQuery($query);
$dataGuest = $guest->getResultFromSelectQuery($guest->queryData());
?>
<div class="clearfix">
    <form style="float:left;" action="index.php?mod=counter" method="post">
        <input type="date" name="date_" style="padding: 5px 10px;"
               value="<?php if (isset($_SESSION['date_chosen'])) echo date('Y-m-d', strtotime($_SESSION['date_chosen'])); else echo date('Y-m-d'); ?>"/>
        <input type="submit" name="find" value="Xem"
               style="padding: 10px 20px; border-radius: 5px; background-color: goldenrod; color: black; font-weight: bold;"/>
    </form>
    <form style="float:right;" action="index.php?mod=counter" method="post">
        <span style="font-weight: bold;">Biển số xe/số khung:</span> <input type="text" name="number_car"
                                                                            style="padding: 5px 10px;"
                                                                            required="required"/>
        <input type="submit" name="find_num" value="Tìm kiếm"
               style="padding: 10px 20px; border-radius: 5px; background-color: goldenrod; color: black; font-weight: bold;"/>
    </form>
</div>
<br/>
<div style="overflow: auto;">
    <table class="tb-user">
        <tr>
            <th>STT</th>
            <th>Tạo lệnh</th>
            <th>Khách hàng</th>
            <th>Điện thoại</th>
            <th>Loại xe</th>
            <th>Số xe/Số khung</th>
            <th>Loại dịch vụ</th>
            <th>Tư vấn viên</th>
            <th>Trạng thái</th>
            <th>Người tạo</th>
            <th>Tác vụ</th>
        </tr>
        <?php
        $temp = 1;
        for ($i = 0; $i < count($dataGuest); $i++) {
            $date_guest = strtotime($dataGuest[$i]['guest_date']);
            if (isset($_POST['find_num']))
                $date_find = strtotime($param_find);
            else
                $date_find = strtotime($_SESSION['date_chosen']);
            if ($date_guest >= $date_find) {
                $checkExist = [
                    "select" => "*",
                    "where" => "vote_guest = '" . $dataGuest[$i]['guest_id'] . "'"
                ];
                $vote->setQuery($checkExist);
                $flag = $vote->isExistRow($vote->queryData());
                $txt = ($flag) ? "<img style='width:40px;height:40px;' src='resource/image/true.png' alt='true' title='Đã đánh giá'/>" : "<img style='width:25px;height:25px;' src='resource/image/false.png' alt='false' title='Chưa đánh giá'/>";
                $chitiet = ($flag) ? "<a href='./index.php?mod=chitiet&id=" . $dataGuest[$i]['guest_id'] . "' class='btn-info'>Chi tiết</a>" : "";
                $query = [
                    "select" => "*",
                    "where" => "user_id = " . $dataGuest[$i]['guest_user_create'] . ""
                ];
                $user->setQuery($query);
                $name_user = $user->getOneRow($user->getResultFromSelectQuery($user->queryData()))['user_fullname'];
                $cmd = [
                    "select" => "*",
                    "where" => "service_id = '" . $dataGuest[$i]['guest_type'] . "'"
                ];
                $service->setQuery($cmd);
                $name = $service->getResultFromSelectQuery($service->queryData());
                $type = "<td class='kd'>" . $name[0]['service_name'] . "</td>";
                echo "<tr>
            <td>" . ($temp++) . "</td>
            <td>" . $dataGuest[$i]['guest_date'] . "</td>
            <td>" . $dataGuest[$i]['guest_name'] . "</td>
            <td>" . $dataGuest[$i]['guest_phone'] . "</td>
            <td>" . $dataGuest[$i]['guest_model'] . "</td>
            <td>" . $dataGuest[$i]['guest_number_car'] . "</td>
            $type
            <td>" . $dataGuest[$i]['guest_sale'] . "</td>
            <td>$txt</td>
            <td>$name_user</td>
            <td>$chitiet</td>
        </tr>";
            }
        }
        ?>
    </table>
    <script>
        document.getElementById("thongke").style.color = "white";
        document.getElementById("thongke").style.backgroundColor = "gray";
    </script>