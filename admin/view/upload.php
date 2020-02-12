<?php
defined("ADMIN") or die("<p style='text-align: center;'><img src='../resource/image/khoa.jpg' alt='lock'/></p>");
?>
<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 11/07/2019
 * Time: 9:17 PM
 */
$upload = new Apps_Class_Upload();
$param = [
    "select" => "*"
];
if (isset($_POST['up'])) {
    if (isset($_FILES['file'])) {
        $upload->setFile($_FILES['file']);
        Apps_Class_Log::writeFlowLog("view/upload.php bắt đầu upload file");
        $upload->generateFolderAndFileName();
        $upload->upload();
        Apps_Class_Log::moveTo("index.php?mod=upload");
    }
}
$params = [
    "select" => "distinct upload_date",
    "other" => "ORDER BY upload_date DESC"
];
$upload->setQuery($param);
Apps_Class_Log::writeFlowLog("view/upload.php thực hiện truy vấn lấy dữ liệu tổng");
$data = $upload->getResultFromSelectQuery($upload->queryData());
$upload->setQuery($params);
Apps_Class_Log::writeFlowLog("view/upload.php thực hiện truy vấn lấy dữ liệu theo cột");
$_date = $upload->getResultOnlyAColumn("upload_date");
?>
<div class="container">
    <h1 class="text-danger">Upload</h1>
    <form action="index.php?mod=upload" method="post" enctype="multipart/form-data">
        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" id="customFile" name="file" required="required">
            <label class="custom-file-label" for="customFile">Chọn file cần upload</label>
        </div>
        <div>
            <button type="submit" name="up" class="btn btn-primary">Upload</button>
        </div>
    </form>
    <div class="container">
        <h5>List</h5>
        <?php
        foreach ($_date as $val) {
            echo "<h4>$val</h4>";
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['upload_date'] == $val) echo "<p>" . $data[$i]['upload_name'] . "&nbsp;&nbsp;&nbsp;&nbsp;<button data-toggle=\"modal\" data-target=\"#listImage\" onclick='showDetail(\"./resource/upload/" . $data[$i]['upload_src'] . "\")' class='btn btn-primary btn-sm'>Xem ảnh</button>&nbsp;&nbsp;&nbsp;<button onclick='delete" . $data[$i]['upload_id'] . "()' class='btn btn-danger btn-sm'>Xóa</button></p>";
            }
        }
        ?>
    </div>
</div>

</div>
<?php
echo "<script>";
for ($i = 0; $i < count($data); $i++) {
    echo "
        function delete" . $data[$i]['upload_id'] . "(){
            if (confirm('Bạn có chắc chắn muốn xóa')) {
                window.open('index.php?mod=upload&id=" . $data[$i]['upload_id'] . "','_self');
            } 
        }";
}
echo "function showDetail(src){
        document.getElementById('popImage').src = src;
}";
echo "</script>";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $url = "";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]['upload_id'] == $id) {
            $url = $data[$i]['upload_src'];
            break;
        }
    }
    $upload->deleteFile($url);
    Apps_Class_Log::moveTo("index.php?mod=upload");
}

?>

<div class="modal fade" id="listImage">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xem trước</h4>
            </div>
            <div class="modal-body">
                <img src="" alt="Show Picture" class="img-fluid" id="popImage"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>