<?php
defined("ADMIN") or die("<p style='text-align: center;'><img src='../resource/image/khoa.jpg' alt='lock'/></p>");
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 25/07/2019
 * Time: 8:12 PM
 */
$item = new Apps_Control_Item();
$subitem = new Apps_Control_Subitem();
// ------------- create menu
if (isset($_POST['create'])) {
    $name = (isset($_POST['name'])) ? $_POST['name'] : null;
    $link = ($_POST['link'] != "") ? $_POST['link'] : "#";
    $param = [
        "item_name" => $name,
        "item_link" => $link
    ];
    if ($item->checkParam($param)) {
        $item->setParam($param);
        if ($item->createData())
            Apps_Class_Log::writeLogSuccess("Create Item: Tạo item menu thành công menu.php");
        else Apps_Class_Log::writeLogFail("Create Item: Tạo item menu thất bại, kiểm tra lại thông số truyền vào menu.php");
    } else Apps_Class_Log::writeLogFail("Create Item: Tham số truyền vào không hợp lệ menu.php");
    Apps_Class_Log::moveTo("index.php?mod=menu");
}

// --------------- create submenu
if (isset($_POST['createSub'])) {
    $idmenu = (isset($_POST['id_menu'])) ? $_POST['id_menu'] : null;
    $name = (isset($_POST['subname'])) ? $_POST['subname'] : null;
    $link = (isset($_POST['sublink'])) ? $_POST['sublink'] : "#";
    $param = [
        "subitem_name" => $name,
        "subitem_link" => $link,
        "item_id" => $idmenu
    ];
    if ($subitem->checkParam($param)) {
        $subitem->setParam($param);
        if ($subitem->createData())
            Apps_Class_Log::writeLogSuccess("Create SubItem: Tạo subitem menu thành công menu.php");
        else Apps_Class_Log::writeLogFail("Create SubItem: Tạo subitem menu thất bại, kiểm tra lại thông số truyền vào menu.php");
    } else Apps_Class_Log::writeLogFail("Create Sub Item: Tham số truyền vào không hợp lệ menu.php");
    Apps_Class_Log::moveTo("index.php?mod=menu");
}

//-------------- update Menu
if (isset($_POST['updateMenu'])) {
    $idMenu = (isset($_POST['idMenu'])) ? $_POST['idMenu'] : null;
    $upname = (isset($_POST['upname'])) ? $_POST['upname'] : null;
    $uplink = (isset($_POST['uplink'])) ? $_POST['uplink'] : "#";
    $param = [
        "item_name" => $upname,
        "item_link" => $uplink
    ];
    $query = [
        "where" => "item_id = '" . $idMenu . "'"
    ];
    $item->setParam($param);
    $item->setQuery($query);
    if ($item->updateData()) Apps_Class_Log::writeLogSuccess("Update Item: Update item menu thành công menu.php");
    else Apps_Class_Log::writeLogFail("Update Item: Update item menu không thành công, kiểm tra lại thông số truyền menu.php");
    Apps_Class_Log::moveTo("index.php?mod=menu");
}

//-------------- update Sub Menu
if (isset($_POST['updateSubMenu'])) {
    $idMenu = (isset($_POST['idSubMenu'])) ? $_POST['idSubMenu'] : null;
    $upname = (isset($_POST['upsubname'])) ? $_POST['upsubname'] : null;
    $uplink = (isset($_POST['upsublink'])) ? $_POST['upsublink'] : "#";
    $param = [
        "subitem_name" => $upname,
        "subitem_link" => $uplink
    ];
    $query = [
        "where" => "subitem_id = '" . $idMenu . "'"
    ];
    $subitem->setParam($param);
    $subitem->setQuery($query);
    if ($subitem->updateData()) Apps_Class_Log::writeLogSuccess("Update SubItem: Update subitem menu thành công menu.php");
    else Apps_Class_Log::writeLogFail("Update SubItem: Update subitem menu không thành công, kiểm tra lại thông số truyền vào menu.php");
    Apps_Class_Log::moveTo("index.php?mod=menu");
}

$param1 = [
    "select" => "*"
];
//----------- load data
$item->setQuery($param1);
$subitem->setQuery($param1);
$dataMenu = $item->getResultFromSelectQuery($item->queryData());
$dataSubMenu = $subitem->getResultFromSelectQuery($subitem->queryData());
?>
<div class="container">
    <h1 class="text-danger">Menu</h1>
    <a href="#">
        <button class="btn btn-success" data-toggle="modal" data-target="#createMedal">Thêm Menu</button>
    </a>
    <p>-----------------------------------------------------</p>
    <ul class="list-group">
        <?php
        if ($dataMenu != null)
        for ($i = 0; $i < count($dataMenu); $i++) {
            echo "<li class=\"list-group-item active bg-primary\"><a style='text-decoration: none; color: white;' href='" . $dataMenu[$i]['item_link'] . "'>" . $dataMenu[$i]['item_name'] . "</a> | <a onclick='deleteMenu" . $dataMenu[$i]['item_id'] . "()'><button class=\"btn btn-danger btn-sm\">Xóa</button></a>&nbsp;&nbsp;<a href=\"#\"><button class=\"btn btn-success btn-sm\" data-toggle=\"modal\" data-target=\"#updateMenu\" onclick=\"updateMenu('" . $dataMenu[$i]['item_id'] . "', '" . $dataMenu[$i]['item_name'] . "','" . $dataMenu[$i]['item_link'] . "')\">Sửa</button></a>&nbsp;&nbsp;<a href=\"#\"><button class=\"btn btn-warning btn-sm\" data-toggle=\"modal\" data-target=\"#createSubMedal\" onclick=\"getValue('" . $dataMenu[$i]['item_id'] . "')\">Thêm Submenu</button></a></li>";

            //----- load sub menu
            $param2 = [
                "select" => "*",
                "where" => "item_id = '" . $dataMenu[$i]['item_id'] . "'"
            ];
            $subitem->setQuery($param2);
            if ($subitem->isExistRow($subitem->queryData())) {
                $dataSub = $subitem->getResultFromSelectQuery($subitem->queryData());
                for ($j = 0; $j < count($dataSub); $j++) {
                    echo "<li class=\"list-group-item list-group-item-success\"><a style='text-decoration: none; color: black;' href='" . $dataSub[$j]['subitem_link'] . "'>" . $dataSub[$j]['subitem_name'] . "</a> | <a onclick='deleteSubMenu" . $dataSub[$j]['subitem_id'] . "()'><span style='color: red;' class=\"fa fa-close\"></span></a>&nbsp;&nbsp;<a data-toggle=\"modal\" data-target=\"#updateSubMenu\" onclick=\"updateSubMenu('" . $dataSub[$j]['subitem_id'] . "', '" . $dataSub[$j]['subitem_name'] . "','" . $dataSub[$j]['subitem_link'] . "')\"><span class=\"fa fa-edit\"></span></a></li>";
                }
            }
        }
        ?>
    </ul>
</div>

<!-- The Create Medal -->
<div class="modal fade" id="createMedal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-danger">Thêm Menu</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <form action="index.php?mod=menu" method="post">
                        <div class="form-group">
                            <label for="name">Tên menu: </label>
                            <input type="text" class="form-control" id="name" name="name" required="required"
                                   placeholder="Tên menu" autofocus="autofocus"/>
                        </div>
                        <div class="form-group">
                            <label for="link">Đường dẫn: </label>
                            <input type="text" class="form-control" id="link" name="link"
                                   placeholder="Đường dẫn"/>
                        </div>
                        <input type="submit" class="btn btn-primary" value=" OK " name="create"/>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- The Create Medal -->
<!-- The Update Menu Medal -->
<div class="modal fade" id="updateMenu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-danger">Update Menu</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <form action="index.php?mod=menu" method="post">
                        <input type="text" name="idMenu" id="idMenu" style="display: none;"/>
                        <div class="form-group">
                            <label for="name">Tên menu: </label>
                            <input type="text" class="form-control" id="upname" name="upname" required="required"
                                   placeholder="Tên menu" autofocus="autofocus"/>
                        </div>
                        <div class="form-group">
                            <label for="uplink">Đường dẫn: </label>
                            <input type="text" class="form-control" id="uplink" name="uplink"
                                   placeholder="Đường dẫn"/>
                        </div>
                        <input type="submit" class="btn btn-primary" value=" OK " name="updateMenu"/>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- The Update Menu Medal -->
<!-- The Create Sub Medal -->
<div class="modal fade" id="createSubMedal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-danger">Thêm Submenu</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <form action="index.php?mod=menu" method="post">
                        <input type="text" class="form-control" id="id_menu" name="id_menu" placeholder="id menu"
                               style="display: none;">
                        <div class="form-group">
                            <label for="subname">Tên submenu: </label>
                            <input type="text" class="form-control" id="subname" name="subname" required="required"
                                   placeholder="Tên menu" autofocus="autofocus"/>
                        </div>
                        <div class="form-group">
                            <label for="sublink">Đường dẫn submenu: </label>
                            <input type="text" class="form-control" id="sublink" name="sublink"
                                   placeholder="Đường dẫn"/>
                        </div>
                        <input type="submit" class="btn btn-primary" value=" OK " name="createSub"/>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- The Create Sub Medal -->
<!-- The Update Sub Medal -->
<div class="modal fade" id="updateSubMenu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-danger">Update Submenu</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <form action="index.php?mod=menu" method="post">
                        <input type="text" class="form-control" id="idSubMenu" name="idSubMenu"
                               style="display: none;">
                        <div class="form-group">
                            <label for="upsubname">Tên submenu: </label>
                            <input type="text" class="form-control" id="upsubname" name="upsubname" required="required"
                                   placeholder="Tên menu" autofocus="autofocus"/>
                        </div>
                        <div class="form-group">
                            <label for="upsublink">Đường dẫn submenu: </label>
                            <input type="text" class="form-control" id="upsublink" name="upsublink"
                                   placeholder="Đường dẫn"/>
                        </div>
                        <input type="submit" class="btn btn-primary" value=" OK " name="updateSubMenu"/>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- The Update Sub Medal -->
<?php
//--------------- set script to delete
echo "<script>";
if ($dataSubMenu != null)
    for ($i = 0; $i < count($dataSubMenu); $i++) {
        echo "
        function deleteSubMenu" . $dataSubMenu[$i]['subitem_id'] . "(){
            if (confirm('Bạn có chắc chắn muốn xóa')) {
                window.open('index.php?mod=menu&subId=" . $dataSubMenu[$i]['subitem_id'] . "','_self');
            } 
        }";
    }
if ($dataMenu != null)
    for ($i = 0; $i < count($dataMenu); $i++) {
        echo "
        function deleteMenu" . $dataMenu[$i]['item_id'] . "(){
            if (confirm('Bạn có chắc chắn muốn xóa')) {
                window.open('index.php?mod=menu&id=" . $dataMenu[$i]['item_id'] . "','_self');
            } 
        }";
    }
echo "</script>";

//--------------- get subid to delete subitem in databse
if (isset($_GET['subId'])) {
    $param = [
        "subitem_id" => $_GET['subId']
    ];
    if ($subitem->checkParam($param)) {
        $subitem->setParam($param);
        if ($subitem->deleteWithId())
            Apps_Class_Log::writeLogSuccess("Delete SubItem: Delete subitem menu thành công menu.php");
        else Apps_Class_Log::writeLogFail("Delete SubItem: Delete subitem menu không thành công menu.php");
    } else Apps_Class_Log::writeLogFail("Delete SubItem: kiểm tra lại tham số truyền menu.php");
    Apps_Class_Log::moveTo("index.php?mod=menu");
}

//--------------- get id to delete item in databse
if (isset($_GET['id'])) {
    $param = [
        "item_id" => $_GET['id']
    ];
    if ($item->checkParam($param)) {
        $item->setParam($param);
        if ($item->deleteWithId())
            Apps_Class_Log::writeLogSuccess("Delete Item: Delete item menu thành công menu.php");
        else Apps_Class_Log::writeLogFail("Delete Item: Delete item menu không thành công menu.php");
    } else Apps_Class_Log::writeLogFail("Delete Item: kiểm tra lại tham số truyền menu.php");
    Apps_Class_Log::moveTo("index.php?mod=menu");
}

?>

<script>
    function getValue(idmenu) {
        document.getElementById("id_menu").value = idmenu;
    }

    function updateMenu(id, name, link) {
        document.getElementById("idMenu").value = id;
        document.getElementById("upname").value = name;
        document.getElementById("uplink").value = link;
    }

    function updateSubMenu(id, name, link) {
        document.getElementById("idSubMenu").value = id;
        document.getElementById("upsubname").value = name;
        document.getElementById("upsublink").value = link;
    }
</script>