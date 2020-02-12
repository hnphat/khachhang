<?php
defined("ADMIN") or die("<p style='text-align: center;'><img src='../resource/image/khoa.jpg' alt='lock'/></p>");
?>
<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 13/07/2019
 * Time: 9:22 PM
 */
$topic = new Apps_Control_Topic();
$upload = new Apps_Class_Upload();
$unity = new Apps_Class_Unity();
$data = "";
if (isset($_GET['id'])) {
    $param = [
        "select" => "*",
        "where" => "topic_id = '" . $_GET['id'] . "'"
    ];
    $topic->setQuery($param);
    $data = $topic->getResultFromSelectQuery($topic->queryData());
    if ($data[0] != null) $data = $data[0];
    else $data = "";
}

if (isset($_POST['update']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $tieude = (isset($_POST['tieude'])) ? $_POST['tieude'] : "";
    $hinhanh = (isset($_FILES['hinhanh'])) ? $_FILES['hinhanh'] : null;
    $mota = (isset($_POST['mota'])) ? $_POST['mota'] : "";
    $noidung = (isset($_POST['noidung'])) ? $_POST['noidung'] : "";
    $check = (isset($_POST['check'])) ? $_POST['check'] : "";
    $check = ($check == "on") ? $check = 1 : $check = 0;
    $upload->setFile($hinhanh);
    $upload->generateFolderAndFileName();
    $src = $upload->getFileName();
    $param = [];
    $upload->upload();
    if ($hinhanh['error'] > 0) {
        $param = [
            "topic_title" => $tieude,
            "topic_desc" => $mota,
            "topic_showads" => $check,
            "topic_content" => $noidung,
            "topic_date" => date('d-m-Y'),
            "topic_src" => strtolower($unity->vn_to_str($tieude)),
            "topic_active" => 1
        ];
    } else {
        $param = [
            "topic_title" => $tieude,
            "topic_desc" => $mota,
            "topic_showads" => $check,
            "topic_content" => $noidung,
            "topic_date" => date('d-m-Y'),
            "topic_src" => strtolower($unity->vn_to_str($tieude)),
            "topic_picture" => $src,
            "topic_active" => 1
        ];
    }
    $query = [
        "where" => "topic_id = '" . $id . "'"
    ];
    $topic->setQuery($query);
    $topic->setParamWithCondition($param, "topic_content");
    if ($topic->updateData())
        Apps_Class_Log::writeLogSuccess("Update topic: Thành công add_topic.php");
    else
        Apps_Class_Log::writeLogFail("Update topic: Không thành công, kiểm tra lại thông số truyền add_topic.php");
    Apps_Class_Log::moveTo("index.php?mod=topic");
}

if (isset($_POST['Post'])) {
    $tieude = (isset($_POST['tieude'])) ? $_POST['tieude'] : "";
    $hinhanh = (isset($_FILES['hinhanh'])) ? $_FILES['hinhanh'] : null;
    $mota = (isset($_POST['mota'])) ? $_POST['mota'] : "";
    $noidung = (isset($_POST['noidung'])) ? $_POST['noidung'] : "";
    $check = (isset($_POST['check'])) ? $_POST['check'] : "";
    $check = ($check == "on") ? $check = 1 : $check = 0;
    $upload->setFile($hinhanh);
    if ($upload->checkFile()) {
        $upload->generateFolderAndFileName();
        $src = $upload->getFileName();
        $upload->upload();
        $param = [
            "topic_title" => $tieude,
            "topic_desc" => $mota,
            "topic_showads" => $check,
            "topic_content" => $noidung,
            "topic_date" => date('d-m-Y'),
            "topic_src" => strtolower($unity->vn_to_str($tieude)),
            "topic_picture" => $src,
            "topic_active" => 1
        ];
        $topic->setParamWithCondition($param, "topic_content");
        if ($topic->createData())
            Apps_Class_Log::writeLogSuccess("Create topic: Đã tạo topic add_topic.php");
        else
            Apps_Class_Log::writeLogFail("Create topic: Tạo topic không thành công, kiểm tra lại thông số truyền add_topic.php");
    } else {
        Apps_Class_Log::writeLogFail("Check file ảnh: kiểm tra thông tin file ảnh add_topic.php");
    }
    Apps_Class_Log::moveTo("index.php?mod=topic");
}
?>
<div class="container">
    <h1 class="text-danger">Thêm bài viết</h1>
    <form action="index.php?mod=add_topic<?php if ($data != "") echo "&id=" . $data['topic_id']; ?>" method="post"
          enctype="multipart/form-data">
        <div class="form-group">
            <label for="tieude" class="font-weight-bold">Tiêu đề bài viết:</label>
            <input class="form-control" type="text" id="tieude" name="tieude" required="required"
                   placeholder="Nhập tiêu đề bài viết" autofocus="autofocus"
                   value="<?php if ($data != "") echo $data['topic_title']; ?>"/>
        </div>
        <div class="form-group">
            <label for="hinhanh" class="font-weight-bold">Hình ảnh đại diện: </label>
            <input type="file" name="hinhanh" id="hinhanh" <?php if ($data != "") {
            } else echo "required=\"required\""; ?>/>
        </div>
        <div class="form-group">
            <label for="mota" class="font-weight-bold">Nội dung mở đầu:</label>
            <textarea class="form-control" name="mota" id="mota" cols="30" rows="3" required="required"
                      placeholder="Nhập mở đầu tóm tắt ngắn gọn không quá 200 từ"><?php if ($data != "") echo $data['topic_desc']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="noidung" class="font-weight-bold">Nội dung bài viết:</label>
            <textarea class="form-control" name="noidung"
                      id="noidung"><?php if ($data != "") echo $data['topic_content']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="check" class="font-weight-bold">Kích hoạt thu thập dữ liệu:</label>
            <input class="w3-check" id="check" name="check"
                   type="checkbox" <?php if ($data != "" && $data['topic_showads'] == 1) echo "checked='checked'"; ?>/>
        </div>
        <div class="form-group">
            <?php if ($data != "") echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"update\" value=\"Cập nhật\"/>"; else echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"Post\" value=\"Post\"/>"; ?>
        </div>
    </form>
</div>

