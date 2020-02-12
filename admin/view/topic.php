<?php
defined("ADMIN") or die("<p style='text-align: center;'><img src='../resource/image/khoa.jpg' alt='lock'/></p>");
?>
<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 13/07/2019
 * Time: 8:57 PM
 */
$topic = new Apps_Control_Topic();
$upload = new Apps_Class_Upload();
$query = [
    "select" => "*",
    "other" => "order by topic_id desc"
];
$detail = "";
$topic->setQuery($query);
$data = $topic->getResultFromSelectQuery($topic->queryData());
//-------------------------
if (isset($_GET['show'])) {
    $id = $_GET['show'];
    $param = [
        "select" => "topic_content",
        "where" => "topic_id = '" . $id . "'"
    ];
    $topic->setQuery($param);
    $detail = $topic->getOneRow($topic->getResultOnlyAColumn("topic_content"));
}
?>
<div class="container">
    <h1 class="text-danger">Topic</h1>
    <a href="index.php?mod=add_topic">
        <button class="btn btn-success">Thêm bài viết</button>
    </a><br/><br/>
    <div class="table-responsive">
        <table class="table table-border">
            <tr>
                <th>No</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Lượt xem</th>
                <th>Hành động</th>
            </tr>
            <?php
            if (isset($data[0])) {
                for ($i = 0; $i < count($data); $i++) {
                    $active = "";
                    ($data[$i]['topic_active'] == 0) ? $active = "fa fa-lock size_button" : $active = "fa fa-unlock size_button";
                    echo "<tr>
                <td>" . ($i + 1) . "</td>
                <td><a href='./resource/upload/" . $data[$i]['topic_picture'] . "'><img style='max-width: 130px;' src='./resource/upload/" . $data[$i]['topic_picture'] . "' alt='" . $data[$i]['topic_title'] . "'
                         class='img-fluid'/></a></td>
                <td><div style=\"white-space: nowrap; max-width: 400px; overflow: hidden;text-overflow: ellipsis;\"><a href='index.php?mod=topic&show=" . $data[$i]['topic_id'] . "'>" . $data[$i]['topic_title'] . "</a></div></td>
                <td>Developing..</td>
                <td>
                    
                        <button onclick='delete" . $data[$i]['topic_id'] . "()' class='btn btn-danger btn-sm'>Xóa</button>
                    &nbsp;
                    <a href='index.php?mod=add_topic&id=" . $data[$i]['topic_id'] . "'>
                        <button class='btn btn-success btn-sm'>Sửa</button>
                    </a>&nbsp;
                    <a href='index.php?mod=topic&active=" . $data[$i]['topic_active'] . "&ids=" . $data[$i]['topic_id'] . "'>
                        <button class='btn btn-warning'><span class='" . $active . "'></span></button>
                    </a>&nbsp;
                </td>
            </tr>";
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- The Create Medal -->
<div class="modal_manual" id="info">
    <div class="modal_content_new container">
        <span onclick="cls()" class="btn btn-danger" id="flag"> Đóng </span>
        <p id="data_info"><?php echo $detail; ?></p>
        <span onclick="cls()" class="btn btn-danger"> Đóng </span>
    </div>
</div>
<!--- Create Medal End --->
<script>
    var modal_info = document.getElementById(info);
    var span = document.getElementsByClassName("close")[0];

    function show() {
        var modal_info = document.getElementById('info');
        modal_info.style.display = 'block';
    }

    function cls() {
        var modal_info = document.getElementById('info');
        modal_info.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal_info) {
            modal_info.style.display = 'none';
        }
    }
</script>
<?php
echo "<script>";
for ($i = 0; $i < count($data); $i++) {
    echo "
        function delete" . $data[$i]['topic_id'] . "(){
            if (confirm('Bạn có chắc chắn muốn xóa')) {
                window.open('index.php?mod=topic&id=" . $data[$i]['topic_id'] . "','_self');
            } 
        }";
}
echo "</script>";
if (isset($_GET['show'])) {
    echo "<script>show();</script>";
}
if (isset($_GET['id'])) {
    $query = [
        "select" => "*",
        "where" => "topic_id = '".$_GET['id']."'"
    ];
    $topic->setQuery($query);
    $src_image = $topic->getOneRow($topic->getResultFromSelectQuery($topic->queryData()))['topic_picture'];
    $param = [
        "topic_id" => $_GET['id']
    ];
    if ($topic->checkParam($param)) {
        $topic->setParam($param);
        if ($topic->deleteWithId()) {
            Apps_Class_Log::writeLogSuccess("Delete Topic: Thành công topic.php");
            Apps_Class_Log::writeFlowLog("Bắt đầu xóa file ảnh trong CSDL");
            $upload->deleteFile($src_image);
        } else Apps_Class_Log::writeLogFail("Delete Topic: Thất bại kiểm tra lại thông số topic.php");
    } else Apps_Class_Log::writeLogFail("Delete Topic: thất bại kiểm tra lại thông số truyền topic.php");
    Apps_Class_Log::moveTo("index.php?mod=topic");
}

if (isset($_GET['active']) && isset($_GET['ids'])) {
    $topic->changeBlock($_GET['active'], $_GET['ids']);
    Apps_Class_Log::moveTo("index.php?mod=topic");
}
?>

