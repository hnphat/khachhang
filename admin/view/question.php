<?php
if (!isset($_SESSION['per']) || ($_SESSION['per'] != 1 && $_SESSION['per'] != 4))
    echo "<script>window.open('index.php','_self');</script>";
$question = new Apps_Control_Question();
$query = [
    "select" => "*",
    "other" => "order by question_type"
];
$question->setQuery($query);
$dataQuestion = $question->getResultFromSelectQuery($question->queryData());
$service = new Apps_Control_Service();
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
<a href="#" onclick="show()" class="btn-add">Thêm câu hỏi</a>
<br/><br/>
<div id="wrong">
    <h1 style="color: red; font-weight: bold;text-align:center;">Thêm câu hỏi không thành công</h1>
</div>
<div id="success">
    <h1 style="color: green; font-weight: bold;text-align:center;">Đã thêm</h1>
</div>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $param = [
        "question_id" => $question->setSafeValue($id)
    ];
    $question->setParam($param);
    if ($question->deleteWithId()) {
        echo "<script>window.open('index.php?mod=question','_self');</script>";
    } else {
        echo "<script>
    alert('Không thể xóa câu hỏi này - Đã có khách hàng đánh giá trong CSDL');
    window.open('index.php?mod=question','_self');
</script>";
    }
}
if (isset($_POST['update_cauhoi'])) {
    $id = (isset($_POST['id_question'])) ? $_POST['id_question'] : "";
    $content = (isset($_POST['c'])) ? $_POST['c'] : "";
    $type = (isset($_POST['l'])) ? $_POST['l'] : "";
    $param = [
        "question_content" => $question->setSafeValue($content),
        "question_type" => $question->setSafeValue($type),
        "question_user" => (isset($_SESSION['id_user'])) ? $_SESSION['id_user'] : ""
    ];
    $query = [
            "where" => "question_id = '".$id."'"
    ];
    $question->setParam($param);
    $question->setQuery($query);
    if ($question->updateData()){
        echo "<script>window.open('index.php?mod=question','_self');</script>";
    }
}
if (isset($_POST['add_cauhoi'])) {
    $id = (isset($_SESSION['id_user'])) ? $_SESSION['id_user'] : "";
    $content = (isset($_POST['cauhoi'])) ? $_POST['cauhoi'] : "";
    $type = (isset($_POST['per'])) ? $_POST['per'] : "";
    $param = [
        "question_content" => $question->setSafeValue($content),
        "question_type" => $question->setSafeValue($type),
        "question_user" => $id
    ];
    $question->setParam($param);
    if ($question->createData()) {
        echo "<script>window.open('index.php?mod=question','_self');</script>";
    } else {
        echo "<script>
                    document.getElementById('wrong').style.display = 'block';
                    </script>";
    }
}
?>
<form id="fuser" action="index.php?mod=question" method="post" autocomplete="off">
    <p style="text-align: right;"><span class="btn-del" onclick="hide()">X</span></p>
    <div>
        <label for="cauhoi">Nội dung câu hỏi: </label>
        <input type="text" id="cauhoi" name="cauhoi" autofocus="autofocus" required="required"/>
    </div>
    <div>
        <label for="loai">Loại câu hỏi: </label>
        <select name="per" id="per">
            <?php
            for ($i = 0; $i < count($dataService); $i++){
                echo "<option value='".$dataService[$i]['service_id']."'>".$dataService[$i]['service_name']."</option>";
            }
            ?>
        </select>
    </div>
    <input type="submit" name="add_cauhoi" value="Xác nhận"/>
</form>
<form class="tb" style="display:none;" action="index.php?mod=question" method="post" autocomplete="off">
    <p style="text-align: right;"><span class="btn-del" onclick="hideUpdate()">X</span></p>
    <div>
        <label for="cauhoi">Nội dung câu hỏi: </label>
        <input type="text" id="c" name="c" autofocus="autofocus" required="required"/>
    </div>
    <div>
        <label for="l">Loại câu hỏi: </label>
        <select name="l" id="l">
            <?php
            for ($i = 0; $i < count($dataService); $i++){
                echo "<option value='".$dataService[$i]['service_id']."'>".$dataService[$i]['service_name']."</option>";
            }
            ?>
        </select>
    </div>
    <input type="hidden" id="id_question" name="id_question"/>
    <input type="submit" name="update_cauhoi" value="Cập nhật"/>
</form>
<br/><br/>
<table class="tb-user">
    <tr>
        <th>STT</th>
        <th>Câu hỏi</th>
        <th>Loại câu</th>
        <th>Người tạo</th>
        <th>Hành động</th>
    </tr>
    <?php
    for ($i = 0; $i < count($dataQuestion); $i++) {
        $query = [
            "select" => "*",
            "where" => "user_id = " . $dataQuestion[$i]['question_user'] . ""
        ];
        $user->setQuery($query);
        $query = [
            "select" => "*",
            "where" => "service_id = '".$dataQuestion[$i]['question_type']."'"
        ];
        $service->setQuery($query);
        $dataOneRow = $service->getOneRow($service->getResultFromSelectQuery($service->queryData()));
        $txt = "<td class='kd'>".$dataOneRow['service_name']."</td>";
        $name_user = $user->getOneRow($user->getResultFromSelectQuery($user->queryData()))['user_fullname'];
        echo "<tr>
        <td>" . ($i + 1) . "</td>
        <td>" . $dataQuestion[$i]['question_content'] . "</td>
        $txt
        <td>" . $name_user . "</td>
        <td><a href='#' onclick='del" . $dataQuestion[$i]['question_id'] . "()' class=\"btn-del\">Xóa</a>&nbsp;&nbsp;<a href='#' onclick=\"edit('" . $dataQuestion[$i]['question_content'] . "','" . $dataQuestion[$i]['question_type'] . "','" . $dataQuestion[$i]['question_id'] . "')\" class=\"btn-edit\">Edit</a></td>
    </tr>";
    }
    ?>
</table>
<script>
    function edit(a, b, c) {
        hide();
        document.getElementById("c").value = a;
        document.getElementById("id_question").value = c;
        switch (b) {
        <?php
                for($i = 0; $i < count($dataService); $i++) {
                    echo "case '".$dataService[$i]['service_id']."' : {document.getElementById('l').selectedIndex = '$i';} break;";
                }
                echo "default: ''; break;";
            ?>
        }
        document.getElementsByClassName("tb")[0].style.display = "block";
    }
    <?php
    for ($i = 0; $i < count($dataQuestion); $i++) {
        echo "
        function del" . $dataQuestion[$i]['question_id'] . "(){
            if (confirm('Bạn có chắc muốn xóa?')) {
                window.open('index.php?mod=question&id=" . $dataQuestion[$i]['question_id'] . "','_self');   
            }
        }
";
    }
    ?>
    document.getElementById("quest").style.color = "white";
    document.getElementById("quest").style.backgroundColor = "gray";
</script>