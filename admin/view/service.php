<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 22/10/2019
 * Time: 9:07 PM
 */
if (!isset($_SESSION['per']) || $_SESSION['per'] != 1)
    echo "<script>window.open('index.php','_self');</script>";
$service = new Apps_Control_Service();
$question = new Apps_Control_Question();
$guest = new Apps_Control_Guest();
$query = [
    "select" => "*"
];
$service->setQuery($query);
$dataService = $service->getResultFromSelectQuery($service->queryData());
?>
<script>
    function hideUpdate() {
        document.getElementsByClassName("tb")[0].style.display = "none";
    }

    function show() {
        document.getElementById("fuser").style.display = "block";
        hideUpdate();
    }

    function hide() {
        document.getElementById("fuser").style.display = "none";
    }
</script>
<br/>
<a href="#" onclick="show()" class="btn-add">Thêm dịch vụ</a>
<br/><br/>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == 1) {
        echo "<script>
    alert('Không thể xóa loại dịch vụ này - Mặc định dịch vụ này phải có trong CSDL!');
    window.open('index.php?mod=service','_self');
</script>";
    } else {
        $param = [
            "service_id" => $service->setSafeValue($id)
        ];
        $service->setParam($param);
        if ($service->deleteWithId()) {
            echo "<script>window.open('index.php?mod=service','_self');</script>";
        } else {
            echo "<script>
    alert('Không thể xóa loại dịch vụ này - Có quá nhiều dữ liệu liên kết đến dịch vụ này!');
    window.open('index.php?mod=service','_self');
</script>";
        }
    }
}
?>
<?php

//if (isset($_GET['id'])) {
//    $id = $_GET['id'];
//    if ($id == 1) {
//        echo "<script>
//    alert('Không thể xóa loại dịch vụ này - Mặc định dịch vụ này phải có trong CSDL!');
//    window.open('index.php?mod=service','_self');
//</script>";
//    } else {
//        $check = [
//            "select" => "*",
//            "where" => "question_type = '" . $id . "'"
//        ];
//        $question->setQuery($check);
//        $flag = $question->isExistRow($question->queryData());
//        if (!$flag) {
//            $check = [
//                "select" => "*",
//                "where" => "guest_type = '" . $id . "'"
//            ];
//            $guest->setQuery($check);
//            $flag = $guest->isExistRow($guest->queryData());
//            if (!$flag) {
//                $param = [
//                    "service_id" => $service->setSafeValue($id)
//                ];
//                $service->setParam($param);
//                if ($service->deleteWithId()) {
//                    echo "<script>window.open('index.php?mod=service','_self');</script>";
//                } else {
//                    echo "<script>
//    alert('Không thể xóa loại dịch vụ này - Có quá nhiều dữ liệu liên kết đến dịch vụ này!');
//    window.open('index.php?mod=service','_self');
//</script>";
//                }
//            } else {
//                echo "<script>
//    alert('Không thể xóa loại dịch vụ này - Vì có khách hàng đang liên kết với nó!');
//    window.open('index.php?mod=service','_self');
//</script>";
//            }
//        } else {
//            echo "<script>
//    alert('Không thể xóa loại dịch vụ này - Vì có câu hỏi đang liên kết với nó!');
//    window.open('index.php?mod=service','_self');
//</script>";
//        }
//    }
//}
if (isset($_POST['add'])) {
    $content = (isset($_POST['dichvu'])) ? $_POST['dichvu'] : "";
    $param = [
        "service_name" => $content
    ];
    $service->setParam($param);
    if ($service->createData()) {
        echo "<script>window.open('index.php?mod=service','_self');</script>";
    } else {
        echo "<script>alert('Đã có lỗi xảy ra, liên hệ IT để được xử lý!');window.open('index.php?mod=service','_self');</script>";
    }
}
if (isset($_POST['update'])) {
    $content = (isset($_POST['c'])) ? $_POST['c'] : "";
    $id = (isset($_POST['id_service'])) ? $_POST['id_service'] : "";
    $param = [
        "service_name" => $content
    ];
    $query = [
        "where" => "service_id = '" . $id . "'"
    ];
    $service->setParam($param);
    $service->setQuery($query);
    if ($service->updateData()) {
        echo "<script>window.open('index.php?mod=service','_self');</script>";
    } else {
        echo "<script>alert('Đã có lỗi xảy ra, liên hệ IT để được xử lý!');window.open('index.php?mod=service','_self');</script>";
    }
}
?>
<form id="fuser" action="index.php?mod=service" method="post" autocomplete="off">
    <p style="text-align: right;"><span class="btn-del" onclick="hide()">X</span></p>
    <div>
        <label for="dichvu">Nội dung dịch vụ: </label>
        <input type="text" id="dichvu" name="dichvu" autofocus="autofocus" required="required"/>
    </div>
    <input type="submit" name="add" value="Xác nhận"/>
</form>
<form class="tb" style="display:none;" action="index.php?mod=service" method="post" autocomplete="off">
    <p style="text-align: right;"><span class="btn-del" onclick="hideUpdate()">X</span></p>
    <div>
        <label for="dichvu">Nội dung dịch vụ: </label>
        <input type="text" id="c" name="c" autofocus="autofocus" required="required"/>
    </div>
    <input type="hidden" id="id_service" name="id_service"/>
    <input type="submit" name="update" value="Cập nhật"/>
</form>
<br/><br/>
<table class="tb-user">
    <tr>
        <th>STT</th>
        <th>Nội dung dịch vụ</th>
        <th>Hành động</th>
    </tr>
    <?php
    for ($i = 0; $i < count($dataService); $i++) {
        echo "<tr>
        <td>" . ($i + 1) . "</td>
        <td>" . $dataService[$i]['service_name'] . "</td>
        <td><a href='#' onclick='del" . $dataService[$i]['service_id'] . "()' class=\"btn-del\">Xóa</a>&nbsp;&nbsp;<a href='#' onclick=\"edit('" . $dataService[$i]['service_name'] . "','" . $dataService[$i]['service_id'] . "')\" class=\"btn-edit\">Edit</a></td>
    </tr>";
    }
    ?>
</table>
<script>
    function edit(a, b) {
        hide();
        document.getElementById("c").value = a;
        document.getElementById("id_service").value = b;
        document.getElementsByClassName("tb")[0].style.display = "block";
    }
    <?php
    for ($i = 0; $i < count($dataService); $i++) {
        echo "
        function del" . $dataService[$i]['service_id'] . "(){
            if (confirm('Bạn có chắc muốn xóa?')) {
                window.open('index.php?mod=service&id=" . $dataService[$i]['service_id'] . "','_self');   
            }
        }
";
    }
    ?>
    document.getElementById("service").style.color = "white";
    document.getElementById("service").style.backgroundColor = "gray";
</script>

