<?php
$guest = new Apps_Control_Guest();
$service = new Apps_Control_Service();
$user = new Apps_Control_User();
$vote = new Apps_Control_Vote();
$date = (isset($_SESSION['date_chosen'])) ? $_SESSION['date_chosen'] : date('d-m-Y');
if (isset($_POST['find'])) {
    $_SESSION['date_chosen'] = $_POST['date_'];
} else {
    $_SESSION['date_chosen'] = $date;
}
$query = [
        "select" => "*"
];
$guest->setQuery($query);
$dataGuest = $guest->getResultFromSelectQuery($guest->queryData());
?>
<form action="index.php?mod=capturn" method="post">
    <span style="font-weight: bold;">Tìm từ:</span> <input type="date" name="date_" style="padding: 5px 10px;"
           value="<?php if (isset($_SESSION['date_chosen'])) echo date('Y-m-d', strtotime($_SESSION['date_chosen'])); else echo date('Y-m-d'); ?>"/>
    <input type="submit" name="find" value="Tìm"
           style="padding: 10px 20px; border-radius: 5px; background-color: goldenrod; color: black; font-weight: bold;"/>
</form>
<br/>
<div style="overflow: auto;">
    <table class="tb-user">
        <tr>
            <th>STT</th>
            <th>Tạo lệnh</th>
            <th>Khách hàng</th>
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
        for($i = 0; $i < count($dataGuest); $i++) {
            $date_guest = strtotime($dataGuest[$i]['guest_date']);
            $date_find = strtotime($_SESSION['date_chosen']);
            if ($date_guest >= $date_find){
                $checkExist = [
                    "select" => "*",
                    "where" => "vote_guest = '".$dataGuest[$i]['guest_id']."'"
                ];
                $vote->setQuery($checkExist);
                $flag = $vote->isExistRow($vote->queryData());
                $txt = ($flag) ? "<img style='width:40px;height:40px;' src='admin/resource/image/true.png' alt='true' title='Đã đánh giá'/>" : "<img style='width:25px;height:25px;' src='admin/resource/image/false.png' alt='false' title='Chưa đánh giá'/>";
                if ($flag){
                    $flag = "<a href='./sign/index.php?num_car=".$dataGuest[$i]['guest_number_car']."&date=".$dataGuest[$i]['guest_date']."' class='btn-edit'>Chữ ký</a>";
                } else {
                    $flag = "<a href='./index.php?do=vote&id=".$dataGuest[$i]['guest_id']."' class='btn-info'>Đánh giá</a>&nbsp;<a href='./sign/index.php?num_car=".$dataGuest[$i]['guest_number_car']."&date=".$dataGuest[$i]['guest_date']."' class='btn-edit'>Chữ ký</a>";
                }
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
            <td>".($temp++)."</td>
            <td>".$dataGuest[$i]['guest_date']."</td>
            <td>".$dataGuest[$i]['guest_name']."</td>
            <td>".$dataGuest[$i]['guest_model']."</td>
            <td>".$dataGuest[$i]['guest_number_car']."</td>
           $type
            <td>".$dataGuest[$i]['guest_sale']."</td>
            <td>$txt</td>
            <td>$name_user</td>
            <td>$flag</td>
        </tr>";
            }
        }
        ?>
    </table>
</div>