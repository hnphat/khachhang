<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 17/09/2019
 * Time: 3:50 PM
 */
defined("ADMIN") or die("<p style='text-align: center;'><img src='../resource/image/khoa.jpg' alt='lock'/></p>");
$slide = new Apps_Control_Slide();
$topic = new Apps_Control_Topic();
$query_topic = [
    "select" => "*"
];
$topic->setQuery($query_topic);
$dataTopic = $topic->getResultFromSelectQuery($topic->queryData());
$query_slide = [
    "select" => "*",
    "other" => "order by slide_pos"
];
$slide->setQuery($query_slide);
$dataSlide = $slide->getResultFromSelectQuery($slide->queryData());
$upload = new Apps_Class_Upload();
if (isset($_POST['postSlide'])) {
    $slide_name = (isset($_POST['_title'])) ? $_POST['_title'] : "";
    $slide_link = (isset($_POST['_link'])) ? $_POST['_link'] : "";
    if (isset($_FILES['_slide']))
        $upload->setFile($_FILES['_slide']);
    $query_getLastId = [
        "select" => "*",
        "other" => "order by slide_id desc limit 0,1"
    ];
    $slide->setQuery($query_getLastId);
    $getId = $slide->getOneRow($slide->getResultOnlyAColumn("slide_id"));
    if ($getId == null) $getId = 1;
    $upload->generateFolderAndFileName();
    $upload->upload();
    $cmd_slide = [
        "slide_name" => $slide_name,
        "slide_image" => $upload->getFileName(),
        "slide_link" => $slide_link,
        "slide_pos" => $getId
    ];
    Apps_Class_Log::writeFlowLog("slide.php truyền tham số lưu vào cơ sỡ dữ liệu table slide");
    $slide->setParam($cmd_slide);
    if ($slide->createData())
        Apps_Class_Log::writeLogSuccess("slide.php lưu slide vào cơ sở dữ liệu thành công line 11");
    else Apps_Class_Log::writeLogFail("slide.php lưu slide vào cơ sở dữ liệu thất bại line 11");
    Apps_Class_Log::moveTo("index.php?mod=slide");
}

if (isset($_POST['updateOrder'])){
    $listOrder = [];
    $total = count($dataSlide);
    for ($i = 0; $i < $total; $i++){
        $data1 = $_POST['idslide'.$i];
        $data2 = $_POST['value'.$i];
        $listOrder[$data1] = $data2;
    }
    $slide->changeOrder($listOrder);
    Apps_Class_Log::moveTo("index.php?mod=slide");
}

if (isset($_GET['id'])) {
    $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
    $query_slide = [
        "select" => "*",
        "where" => "slide_id = '" . $id . "'"
    ];
    $slide->setQuery($query_slide);
    $src_image = $slide->getOneRow($slide->getResultFromSelectQuery($slide->queryData()))['slide_image'];
    $cmd_del = [
        "slide_id" => $id
    ];
    $slide->setParam($cmd_del);
    if ($slide->deleteWithId()) {
        Apps_Class_Log::writeLogSuccess("slide xóa slide thành công line 41");
        Apps_Class_Log::writeFlowLog("Bắt đầu xóa file ảnh trong CSDL");
        $upload->deleteFile($src_image);
    } else Apps_Class_Log::writeLogFail("slide xóa slide thất bại, kiểm tra lại tham số truyền vào line 41");
    Apps_Class_Log::moveTo("index.php?mod=slide");
}
?>
<div class="container">
    <button id="addSlide" class="btn btn-success">Thêm Slide</button>
    <button id="updateOrder" class="btn btn-warning" data-toggle="modal" data-target="#order">Điều chỉnh thứ tự</button>
    <div class="modal fade" id="order">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form action="index.php?mod=slide" method="post">
                        <table>
                            <tr class="text-center">
                                <th class="p-3">Slide</th>
                                <th class="p-3">Thứ tự <span class="badge badge-dark" data-toggle="tooltip" title="Thứ tự sẽ được ưu tiên từ thấp đến cao">?</span></th>
                            </tr>
                            <?php
                                for($i = 0; $i < count($dataSlide); $i++){
                                    echo "<tr class=\"text-center p2\">
                                <td class=\"p-3\"><img src=\"./resource/upload/".$dataSlide[$i]['slide_image']."\" alt=\"".$dataSlide[$i]['slide_image']."\" style=\"max-width: 500px;\"></td>
                                <td><input type='text' name='idslide".$i."' value='".$dataSlide[$i]['slide_id']."' style='display:none;'/><input type=\"text\" name=\"value".$i."\" value=\"".$dataSlide[$i]['slide_pos']."\" class=\"form-control text-center\"/></td>
                            </tr>";
                                }
                            ?>
                        </table>
                        <input type="submit" name="updateOrder" value="Cập nhật thứ tự" class="btn btn-info mx-auto d-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form id="formSlide" action="index.php?mod=slide" method="post" enctype="multipart/form-data"
          style="max-width: 600px;margin:auto;display:none;" autocomplete="off">
        <div class="form-group">
            <label class="font-weight-bold" for="_slide">Slide ảnh:</label>
            <input class="form-control" type="file" id="_slide" name="_slide" required="required"/>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="_title">Tiêu đề Slide:</label>
            <input class="form-control" type="text" id="_title" name="_title" required="required"
                   placeholder="Nhập tiêu đề slide"/>
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="_link">Liên kết bài viết:</label>
            <select class="form-control" name="_link" id="_link" required="required">
                <?php
                for ($i = 0; $i < count($dataTopic); $i++) {
                    echo "<option value='" . $dataTopic[$i]['topic_id'] . "'>" . $dataTopic[$i]['topic_title'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="postSlide" class="btn btn-success" value="Thêm"/>
            <input type="reset" class="btn btn-warning" value="Xóa"/>
        </div>
    </form>
    <div class="m-2">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Slide</th>
                    <th>Tên Slide</th>
                    <th>Tác vụ</th>
                </tr>
                <?php
                if (isset($dataSlide))
                    for ($i = 0; $i < count($dataSlide); $i++) {
                        echo "<tr>
                <td>" . ($i + 1) . "</td>
                <td><a href='#'><img src=\"./resource/upload/" . $dataSlide[$i]['slide_image'] . "\" alt=\"" . $dataSlide[$i]['slide_name'] . "\" style=\"width:400px;\"></a></td>
                <td>" . $dataSlide[$i]['slide_name'] . "</td>
                <td>
                    <button onclick='deleteSlide(" . $dataSlide[$i]['slide_id'] . ")' class=\"btn btn-danger btn-sm\">Xóa</button>
                </td>
            </tr>";
                    }
                ?>
            </table>
        </div>
    </div>
    <script>
        function deleteSlide(id) {
            if (confirm("Bạn có chắc chắn muốn xóa")) {
                window.open("index.php?mod=slide&id=" + id, "_self");
            }
        }

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $("#addSlide").click(function () {
                $("#formSlide").css("display", "block");
            });
        });
    </script>
</div>


