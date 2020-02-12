<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 19/10/2019
 * Time: 2:57 PM
 */
$guest = new Apps_Control_Guest();
$vote = new Apps_Control_Vote();
$question = new Apps_Control_Question();
$service = new Apps_Control_Service();
$picture = new Apps_Control_Picture();
$upload = new Apps_Class_Upload();
$id = 0;
$type_question = 0;
$number_question = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = [
        "select" => "*",
        "where" => "guest_id = '" . $id . "'"
    ];
    $guest->setQuery($query);
    $dataGuest = $guest->getResultFromSelectQuery($guest->queryData());
    $type_question = $dataGuest[0]['guest_type'];
    echo "<h4>Khách hàng: <span style=\"font-weight: bold;color:red;\">" . $dataGuest[0]['guest_name'] . "</span>&nbsp;&nbsp;Tạo lệnh: <span style=\"font-weight: bold;color:red;\">" . $dataGuest[0]['guest_date'] . "</span>&nbsp;&nbsp;Số xe/Số khung: <span style=\"font-weight: bold;color:red;\">" . $dataGuest[0]['guest_number_car'] . "</span>&nbsp;&nbsp;Loại xe: <span style=\"font-weight: bold;color:red;\">" . $dataGuest[0]['guest_model'] . "</span>";
    $cmd = [
        "select" => "*",
        "where" => "service_id = '" . $dataGuest[0]['guest_type'] . "'"
    ];
    $service->setQuery($cmd);
    $name = $service->getResultFromSelectQuery($service->queryData());
    echo "&nbsp;&nbsp;Loại dịch vụ: <span style=\"font-weight: bold;color:red;\">" . $name[0]['service_name'] . "</span></h4>
<h4>Ghi chú: <span style=\"font-weight: bold;color:red;\">" . $dataGuest[0]['guest_comment'] . "</span></h4>";
    if ($dataGuest[0]['guest_type'] != 1)
    echo "<br/><h1 style='text-align: center;'>Số tiền thanh toán: <span style='font-size: 200%; color: brown;text-shadow: 0 0 10px yellow;'>".number_format($dataGuest[0]['guest_cost'])."</span></h1>";
}
$queryVote = [
    "select" => "*",
    "where" => "vote_guest ='" . $id . "'"
];
$vote->setQuery($queryVote);
$dataVote = $vote->getResultFromSelectQuery($vote->queryData());
$number_question = count($dataVote);
?>
    <br>
<?php if ($dataGuest[0]['guest_type'] != 1) { ?>
    <h4>Quý khách là chủ sở hữu hay quản lý xe?
        <span style="margin:5px 0;color:red;font-weight: bold;">
    <?php
    switch ($dataGuest[0]['vote_c1']) {
        case 1:
            echo "Chủ sở hữu";
            break;
        case 2:
            echo "Quản lý xe";
            break;
        default:
            echo "<span style='color:blue;'>Khách hàng không đánh giá</span>";
            break;
    }
    ?>
</span></h4>
    <h4>Quý khách theo dõi chương trình khuyến mãi của Đại lý theo nguồn tin nào?<span
                style="margin:5px 0;color:red;font-weight: bold;">
    <?php
    switch ($dataGuest[0]['vote_c2']) {
        case 1:
            echo "Facebook";
            break;
        case 2:
            echo "Website";
            break;
        case 3:
            echo "Người thân giới thiệu";
            break;
        default:
            echo "<span style='color:blue;'>Khách hàng không đánh giá</span>";
            break;
    }
    ?>
</span></h4>
    <h4>Quý khách mong muốn Đại lý giảm giá theo hình thức nào?<span
                style="margin:5px 0;color:red;font-weight: bold;">
    <?php
    switch ($dataGuest[0]['vote_c3']) {
        case 1:
            echo "Hoa hồng 10%";
            break;
        case 2:
            echo "Quà tặng";
            break;
        case 3:
            echo "Giảm trực tiếp vào hóa đơn";
            break;
        default:
            echo "<span style='color:blue;'>Khách hàng không đánh giá</span>";
            break;
    }
    ?>
</span></h4>
<!--    <h4>Quý khách mong muốn nhận được gì khi giới thiệu người thân sử dụng dịch vụ của Hyundai An Giang?<span-->
<!--                style="margin:5px 0;color:red;font-weight: bold;">-->
<!--    --><?php
//    switch ($dataGuest[0]['vote_c4']) {
//        case 1:
//            echo "Voucher giảm giá";
//            break;
//        case 2:
//            echo "Quà tặng";
//            break;
//        case 3:
//            echo "Hoa hồng giới thiệu";
//            break;
//        default:
//            echo "<span style='color:blue;'>Khách hàng không đánh giá</span>";
//            break;
//    }
//    ?>
<!--</span></h4>-->
<!--    <h4>Quý khách muốn được giám sát quá trình sửa xe qua Camera phòng chờ không?<span-->
<!--                style="margin:5px 0;color:red;font-weight: bold;">-->
<!--    --><?php
//    switch ($dataGuest[0]['vote_c5']) {
//        case 1:
//            echo "Có";
//            break;
//        case 2:
//            echo "Không";
//            break;
//        default:
//            echo "<span style='color:blue;'>Khách hàng không đánh giá</span>";
//            break;
//    }
//    ?>
<!--</span></h4>-->
    <h4>Các câu hỏi về trải nghiệm dịch vụ</h4>
<?php } ?>
    <table class="tb-user">
        <tr>
            <th>TT</th>
            <th>Câu hỏi</th>
            <th>Số điểm</th>
            <th>Loại câu hỏi</th>
        </tr>
        <?php
        $sum = 0;
        for ($i = 0; $i < count($dataVote); $i++) {
            $queryQuestion = [
                "select" => "*",
                "where" => "question_id = '" . $dataVote[$i]['vote_question'] . "' and question_type = '" . $type_question . "'"
            ];
            $question->setQuery($queryQuestion);
            $dataQuestion = $question->getOneRow($question->getResultFromSelectQuery($question->queryData()));
            $cmd = [
                "select" => "*",
                "where" => "service_id = '" . $dataGuest[0]['guest_type'] . "'"
            ];
            $service->setQuery($cmd);
            $name = $service->getResultFromSelectQuery($service->queryData());
            $type = "<td class='kd'>" . $name[0]['service_name'] . "</td>";
            echo "
         <tr>
         <td>" . ($i + 1) . "</td>
         <td>" . $dataQuestion['question_content'] . "</td>
         <td>" . (($dataVote[$i]['vote_point'] != 0) ? $dataVote[$i]['vote_point'] : '<span style=\'color:blue;font-weight: bold;\'>Khách hàng không đánh giá</span>') . "</td>
        $type
         </tr>";
            if ($dataVote[$i]['vote_point'] != 0)
                $sum += (int)($dataVote[$i]['vote_point']);
            else $number_question--;
        }
        if ($dataGuest[0]['guest_type'] == 1) {
            echo "<tr>
<td>" . (++$i) . "</td>
<td>Đánh giá chung về hoạt động lái thử xe</td>";
            if ($dataGuest[0]['vote_kinhdoanh'] == 0) {
                echo "<td><span style='color:blue;font-weight: bold;'>Khách hàng không đánh giá</span></td>";
            } else {
                if ($dataGuest[0]['vote_kinhdoanh'] <= 10) {
                    echo "<td>" . $dataGuest[0]['vote_kinhdoanh'] . "</td>";
                    $sum += $dataGuest[0]['vote_kinhdoanh'];
                    $number_question++;
                } else {
                    switch ($dataGuest[0]['vote_kinhdoanh']) {
                        case 11:
                            echo "<td><span style='color:red;font-weight: bold;'>Tôi không được mời lái thử xe</span></td>";
                            break;
                        case 12:
                            echo "<td><span style='color:blue;font-weight: bold;'>Tôi được mời nhưng từ chối tham dự</span></td>";
                            break;
                    }
                }
            }
            echo "<td class='kd'>Kinh doanh</td>
</tr>";
        }
        ?>
    </table>
    <br>
    <h4>Một số hình ảnh chất lượng xe</h4>
<?php
if ($dataGuest[0]['guest_have_image'] == 0) {
    echo "<p class='dv'>Hình ảnh chưa có</p>";
} else {
    if ($dataGuest[0]['guest_have_image'] == 1) {
        echo "<p class='kd'>Hình ảnh được bổ sung sau khi khách hàng đánh giá</p>";
        $query_image = [
            "select" => "*",
            "where" => "picture_guest = '" . $dataGuest[0]['guest_id'] . "'"
        ];
        $picture->setQuery($query_image);
        $dataImg = $picture->getResultFromSelectQuery($picture->queryData());
        echo "<p>";
        for ($i = 0; $i < count($dataImg); $i++) {
            echo "<a style='padding: 0 5px;' href='#' onclick=\"del('" . $dataImg[$i]['picture_id'] . "','" . $dataGuest[0]['guest_id'] . "')\"><img src='./resource/upload/" . $dataImg[$i]['picture_src'] . "' alt='Hình " . $dataGuest[0]['guest_name'] . "' style='max-width: 500px; height: auto;'></a>";
        }
        echo "</p>";
    } else {
        echo "<p class='kd'>Hình ảnh được bổ sung trước khi đánh giá</p><br/>";
        $query_image = [
            "select" => "*",
            "where" => "picture_guest = '" . $dataGuest[0]['guest_id'] . "'"
        ];
        $picture->setQuery($query_image);
        $dataImg = $picture->getResultFromSelectQuery($picture->queryData());
        echo "<p>";
        for ($i = 0; $i < count($dataImg); $i++) {
            echo "<a style='padding: 0 5px;' href='#' onclick=\"del('" . $dataImg[$i]['picture_id'] . "','" . $dataGuest[0]['guest_id'] . "')\"><img src='./resource/upload/" . $dataImg[$i]['picture_src'] . "' alt='Hình " . $dataGuest[0]['guest_name'] . "' style='max-width: 500px; height: auto;'></a>";
        }
        echo "</p>";
    }
}
?>
    <br/>
    <h4>Ý kiến đóng góp của khách hàng: </h4>
<?php
if ($dataGuest[0]['vote_comment'] != null) {
    echo "<span style='margin:5px 0;color:red;font-weight: bold;'>" . $dataGuest[0]['vote_comment'] . "</span>";
} else echo "<span style='margin:5px 0;color:red;font-weight: bold;color:blue;'>Không</span>";
?>
    <br>
    <h3 style="text-align: right;">Điểm trung bình: <span
                style="color:red;"><?php echo round($sum / $number_question, 2); ?> điểm</span></h3>
    <br>
    <h3 style="text-align: right;">Chữ ký khách hàng:</h3>
<?php
$txt = "http://khachhang.hyundaiangiang.com/sign/photos/" . $dataGuest[0]['guest_number_car'] ."-". $dataGuest[0]['guest_date'].".png";
//$txt = "http://localhost/khachhang/sign/photos/" . $dataGuest[0]['guest_number_car'] . "-" . $dataGuest[0]['guest_date'] . ".png";
echo "<p style='text-align:right;'><img src='$txt' alt='Chưa có chữ ký' style='width: 300px; height: auto;' /></p>";
?>
    <br>
    <script>
        function del(pic_id, guest_id) {
            if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
                window.open('index.php?mod=chitiet&id=' + guest_id + '&del=' + pic_id, '_self');
            }
        }
    </script>
<?php
if (isset($_GET['del']) && $_SESSION['per'] == 1) {
    $pic_id = $_GET['del'];
    $guest_id = $_GET['id'];
    $query = [
        "select" => "*",
        "where" => "picture_id = '" .$pic_id."'"
    ];
    $picture->setQuery($query);
    $url = $picture->getResultFromSelectQuery($picture->queryData())[0]['picture_src'];
    $param = [
        "picture_id" => $pic_id
    ];
    $picture->setParam($param);
    if ($picture->deleteWithId()) {
        $upload->deleteFile($url);
        echo "<script>window.open('index.php?mod=chitiet&id=" . $guest_id . "','_self');</script>";
    }
} else {
    if (isset($_GET['del'])) {
        $pic_id = $_GET['del'];
        $guest_id = $_GET['id'];
        echo "<script>alert('Bạn không có quyền xóa hình ảnh này, liên hệ IT để được xử lý');window.open('index.php?mod=chitiet&id=" . $guest_id . "','_self');</script>";
    }
}
?>