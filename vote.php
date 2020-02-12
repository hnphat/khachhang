<?php
$guest = new Apps_Control_Guest();
$event = new Apps_Control_Event();
$service = new Apps_Control_Service();
$picture = new Apps_Control_Picture();
$dataGuest = null;
$type_question = 0;
$number_question = 0;
$arrQuestion = [];
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
    echo "&nbsp;&nbsp;Loại dịch vụ: <span style=\"font-weight: bold;color:red;\">" . $name[0]['service_name'] . "</span></h4>";
    if ($dataGuest[0]['guest_type'] != 1 && $dataGuest[0]['guest_cost'] != 0)
    echo "<br/><h1 style='text-align: center;'>Số tiền thanh toán: <span style='font-size: 200%; color: brown;text-shadow: 0 0 10px yellow;'>".number_format($dataGuest[0]['guest_cost'])."</span></h1>";
}

?>
    <form id="checkForm" action="index.php?do=vote&id=<?php echo $id; ?>" method="post" style="display: none;">

    </form><br>
    <h4 class="sizez" style="text-align: center;"><i>Để chúng tôi hiểu hơn nhu cầu và kỳ vọng của Quý khách. <br/>Xin Quý khách vui
            lòng dành chút thời gian để trả lời bảng câu hỏi dưới đây</i></h4><br/>
<?php if ($dataGuest[0]['guest_type'] != 1) { ?>
    <h4 class="sizez">Quý khách là chủ sở hữu hay quản lý xe?</h4>
    <p class="sizez" style="margin:5px 0;"><input class='check_box_user' type="radio" name="v_c1" value="1" form='checkForm'> Chủ sở
        hữu &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='check_box_user' type="radio" name="v_c1"
                                                                   value="2" form='checkForm'/> Quản lý xe</p>
    <h4 class="sizez">Quý khách theo dõi chương trình khuyến mãi của Đại lý theo nguồn tin nào?</h4>
    <p class="sizez" style="margin:5px 0;"><input class='check_box_user' type="radio" name="v_c2" value="1" form='checkForm'> Facebook
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='check_box_user' type="radio" name="v_c2" value="2"
                                                               form='checkForm'/> Website &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                class='check_box_user' type="radio" name="v_c2" value="3" form='checkForm'/> Người thân giới thiệu</p>
    <h4 class="sizez">Quý khách mong muốn Đại lý giảm giá theo hình thức nào?</h4>
    <p class="sizez" style="margin:5px 0;"><input class='check_box_user' type="radio" name="v_c3" value="1" form='checkForm'> Hoa hồng
        10% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='check_box_user' type="radio" name="v_c3"
                                                                   value="2" form='checkForm'/> Quà tặng &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                class='check_box_user' type="radio" name="v_c3" value="3" form='checkForm'/> Giảm trực tiếp vào hóa đơn
    </p>
<!--    <h4 class="sizez">Quý khách mong muốn nhận được gì khi giới thiệu người thân sử dụng dịch vụ của Hyundai An Giang?</h4>-->
<!--    <p class="sizez" style="margin:5px 0;"><input class='check_box_user' type="radio" name="v_c4" value="1" form='checkForm'> Voucher-->
<!--        giảm giá &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='check_box_user' type="radio" name="v_c4"-->
<!--                                                                        value="2" form='checkForm'/> Quà tặng &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input-->
<!--                class='check_box_user' type="radio" name="v_c4" value="3" form='checkForm'/> Hoa hồng giới thiệu</p>-->
<!--    <h4 class="sizez">Quý khách muốn được giám sát quá trình sửa xe qua Camera phòng chờ không?</h4>-->
<!--    <p class="sizez" style="margin:5px 0;"><input class='check_box_user' type="radio" name="v_c5" value="1" form='checkForm'> Có-->
<!--        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='check_box_user' type="radio" name="v_c5" value="2"-->
<!--                                                               form='checkForm'/> Không</p>-->
    <h4 class="sizez">Các câu hỏi về trải nghiệm dịch vụ của Quý khách?</h4>
<?php } ?>
    <table class="tb-user">
        <tr class="sizez">
            <th>TT</th>
            <th>Câu hỏi</th>
            <th>1Đ</th>
            <th>2Đ</th>
            <th>3Đ</th>
            <th>4Đ</th>
            <th>5Đ</th>
            <th>6Đ</th>
            <th>7Đ</th>
            <th>8Đ</th>
            <th>9Đ</th>
            <th>10Đ</th>
        </tr>
        <?php
        $question = new Apps_Control_Question();
        $query = [
            "select" => "*",
            "where" => "question_type = '" . $type_question . "'",
            "other" => "order by question_id"
        ];
        $question->setQuery($query);
        $dataQuestion = $question->getResultFromSelectQuery($question->queryData());
        $number_question = count($dataQuestion);
        $i = 0;
        for ($i; $i < count($dataQuestion); $i++) {
            $arrQuestion[count($arrQuestion)] = $dataQuestion[$i]['question_id'];
            echo "<tr class='sizez'>";
            echo "<td>" . ($i + 1) . "</td>";
            echo "<td>" . $dataQuestion[$i]['question_content'] . "</td>";
            for ($j = 1; $j <= 10; $j++)
                echo "<td><input class='check_box_user' value='" . $j . "' type='radio' name='_c" . ($i + 1) . "' form='checkForm'/></td>";
            echo "</tr>";
        }
        if ($dataGuest[0]['guest_type'] == 1) {
            echo "<tr>
<td rowspan='2' class='sizez' style='vertical-align: top;'>" . (++$i) . "</td>
<td rowspan='2' class='sizez' style='vertical-align: top;'>Đánh giá chung về hoạt động lái thử xe</td>";
            for ($j = 1; $j <= 10; $j++)
                echo "<td><input class='check_box_user' value='" . $j . "' type='radio' name='_d' form='checkForm'/></td>";
            echo "</tr>";
            echo "<tr class='sizez'>
<td colspan='10' style='text-align: left;'><input class='check_box_user' type='radio' name='_d' value='11' form='checkForm'> Tôi không được mời lái thử xe
        <br/><input class='check_box_user' type='radio' name='_d' value='12'
                                                               form='checkForm'/> Tôi được mời nhưng từ chối tham dự</td>
</tr>";
        }
        echo "<input type='hidden' name='num_car' value='" . $dataGuest[0]['guest_number_car'] . "' form='checkForm'/><input type='hidden' name='date_car' value='" . $dataGuest[0]['guest_date'] . "' form='checkForm'/>";
        ?>
    </table>
<?php
if ($dataGuest[0]['guest_have_image'] == 2) {
    echo " <h4 class='sizez' style='margin: 5px 0;'>Một số hình ảnh xe của Quý khách:</h4>";
    $query = [
        "select" => "*",
        "where" => "picture_guest = '" . $dataGuest[0]['guest_id'] . "'"
    ];
    $picture->setQuery($query);
    $dataPic = $picture->getResultFromSelectQuery($picture->queryData());
    echo "<p class='sizez'>";
    for ($i = 0; $i < count($dataPic); $i++) {
        echo "<img src='./admin/resource/upload/" . $dataPic[$i]['picture_src'] . "' alt='Hình " . $dataGuest[0]['guest_name'] . "' style='max-width: 500px; height: auto;'>";
    }
    echo "</p>";
}
?>
    <h4 class="sizez" style="margin: 5px 0;">Ý kiến chia sẻ thêm của Quý khách?</h4>
    <textarea name="comment" id="comment" style="width: 100%;height: 100px; resize: none;font-size:14pt;"
              form='checkForm'></textarea>
    <div><input class="btn-send" type="submit" name="submit" value="Gửi đánh giá" form="checkForm"/></div><br/>
<?php
if (isset($_POST['submit'])) {
    $num_car = $_POST['num_car'];
    $date_car = $_POST['date_car'];
    $vote = new Apps_Control_Vote();
    $arr = [];
    $other = [
        "vote_c1" => (isset($_POST['v_c1'])) ? $_POST['v_c1'] : 0,
        "vote_c2" => (isset($_POST['v_c2'])) ? $_POST['v_c2'] : 0,
        "vote_c3" => (isset($_POST['v_c3'])) ? $_POST['v_c3'] : 0,
        "vote_c4" => (isset($_POST['v_c4'])) ? $_POST['v_c4'] : 0,
        "vote_c5" => (isset($_POST['v_c5'])) ? $_POST['v_c5'] : 0,
        "vote_comment" => (isset($_POST['comment'])) ? $_POST['comment'] : "None",
        "vote_kinhdoanh" => (isset($_POST['_d'])) ? $_POST['_d'] : 0
    ];
    $query = [
        "where" => "guest_id = '" . $id . "'"
    ];
    for ($i = 1; $i <= $number_question; $i++) {
        $arr[count($arr)] = (isset($_POST['_c' . $i])) ? $_POST['_c' . $i] : 0;
    }
    if ($vote->writeVote($arrQuestion, $arr, $id, $type_question)) {
        $guest->setParam($other);
        $guest->setQuery($query);
        if ($guest->updateData()) {
            echo "<script>window.open('./sign/index.php?num_car=" . $num_car . "&date=" . $date_car . "','_self');</script>";
        } else {
            echo "<script>
        if(confirm('Đã lưu vào bảng dữ liệu vote, chưa lưu được vào bảng guest, liên hệ IT để được xử lý!')){
            window.open('index.php','_self');
        } else {
            window.open('index.php','_self');
        }
</script>";
        }
    } else {
        if ($event->queryWithCmd("delete from " . $event->getTableName())) {
        }
    }

}
?>