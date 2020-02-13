<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 18/10/2019
 * Time: 10:38 AM
 */
if (!isset($_SESSION['per']))
    echo "<script>window.open('index.php','_self');</script>";
$guest = new Apps_Control_Guest();
$vote = new Apps_Control_Vote();
$event = new Apps_Control_Event();
$picture = new Apps_Control_Picture();
$query = "";
$param_find = date('01-01-2019');
$date = (isset($_SESSION['date_chosen'])) ? $_SESSION['date_chosen'] : date('d-m-Y');
if (isset($_POST['find'])) {
    $_SESSION['date_chosen'] = $_POST['date_'];
} else {
    $_SESSION['date_chosen'] = $date;
}
if ($_SESSION['id_user'] == 1 || $_SESSION['per'] == 4)
    $query = [
        "select" => "*",
        "other" => "order by guest_id desc"
    ];
else {
    if ($_SESSION['per'] == 3)
        $query = [
            "select" => "*",
            // "where" => "guest_user_create = '" . $_SESSION['id_user'] . "'",
            "where" => "guest_type = '" . 1 . "'",
            "other" => "order by guest_id desc"
        ];
    else $query = [
        "select" => "*",
        // "where" => "guest_user_create = '" . $_SESSION['id_user'] . "'",
        "where" => "guest_type != '" . 1 . "'",
        "other" => "order by guest_id desc"
    ];
}
if (isset($_POST['find_num'])) {
    $num = (isset($_POST['number_car'])) ? $_POST['number_car'] : "";
    if ($_SESSION['id_user'] == 1 || $_SESSION['per'] == 4)
        $query = [
            "select" => "*",
            "where" => "guest_number_car like '%" . $num . "%' or guest_number_car like '" . $num . "%' or guest_number_car like '%" . $num . "'"
        ];
    else {
        if ($_SESSION['per'] == 3)
        $query = [
            "select" => "*",
            "where" => "guest_type = '" . 1 . "' and guest_number_car like '%" . $num . "%'"
        ];
        else $query = [
            "select" => "*",
            "where" => "guest_type != '" . 1 . "' and guest_number_car like '%" . $num . "%'"
        ];
    }
}
$guest->setQuery($query);
$dataGuest = $guest->getResultFromSelectQuery($guest->queryData());
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
        hideUpdate();
    }
</script>
<br/>
<a href="#" onclick="show()" class="btn-add">Thêm khách hàng</a>
<br/><br/>
<?php
if (isset($_GET['id'])) {
    $id_guest = $_GET['id'];
    $param = [
        "guest_id" => $guest->setSafeValue($id_guest)
    ];
    $guest->setParam($param);
    if ($guest->deleteWithId()) {
        echo "<script>window.open('index.php?mod=guest','_self');</script>";
    } else {
        echo "<script>
            if (confirm('Không thể xóa lúc này')) {
                window.open('index.php?mod=guest','_self');
            } else {
                window.open('index.php?mod=guest','_self');
            }
</script>";
    }
}

if (isset($_POST['update'])) {
    $name = (isset($_POST['a'])) ? $_POST['a'] : "";
    $phone = (isset($_POST['b'])) ? $_POST['b'] : "";
    $num = (isset($_POST['c'])) ? strtoupper($_POST['c']) : "";
    $car = (isset($_POST['d'])) ? $_POST['d'] : "";
    $nv = (isset($_POST['e'])) ? $_POST['e'] : "";
    $note = (isset($_POST['g'])) ? $_POST['g'] : "";
    $cus = (isset($_POST['f'])) ? $_POST['f'] : "";
    $day = Date('d-m-Y');
    $id_guest = (isset($_POST['id_guest'])) ? $_POST['id_guest'] : "";
    $param = [
        "guest_date" => $day,
        "guest_name" => $guest->setSafeValue($name),
        "guest_phone" => $guest->setSafeValue($phone),
        "guest_number_car" => $guest->setSafeValue($num),
        "guest_model" => $guest->setSafeValue($car),
        "guest_sale" => $guest->setSafeValue($nv),
        "guest_comment" => $guest->setSafeValue($note),
        "guest_type" => $guest->setSafeValue($cus)
    ];
    $query = [
        "where" => "guest_id = '" . $id_guest . "'"
    ];
    $guest->setParam($param);
    $guest->setQuery($query);
    if ($guest->updateData()) {
        echo "<script>window.open('index.php?mod=guest','_self');</script>";
    } else {
        echo "<script>
                if (confirm('Đã có lỗi xảy ra')){
                    window.open('index.php?mod=guest','_self');
                } else {
                    window.open('index.php?mod=guest','_self');
                }
        </script>";
    }
}

if (isset($_GET['vote'])) {
    $event_id = $_GET['vote'];
    $param = [
        "event_set" => $event_id
    ];
    $event->setParam($param);
    if ($event->createData()) {
        $query = [
            "select" => "*",
            "where" => "picture_guest = '" . $event_id . "'"
        ];
        $picture->setQuery($query);
        $existData = $picture->isExistRow($picture->queryData());
        if ($existData) {
            $param2 = [
                "guest_have_image" => 2
            ];
            $query2 = [
                "where" => "guest_id = '" . $event_id . "'"
            ];
            $guest->setParam($param2);
            $guest->setQuery($query2);
            if ($guest->updateData()) {
                echo "<script>window.open('index.php?mod=guest','_self');</script>";
            }
        } else {
            $param2 = [
                "guest_have_image" => 0
            ];
            $query2 = [
                "where" => "guest_id = '" . $event_id . "'"
            ];
            $guest->setParam($param2);
            $guest->setQuery($query2);
            if ($guest->updateData()) {
                echo "<script>window.open('index.php?mod=guest','_self');</script>";
            }
        }
    }
}

if (isset($_GET['vote_del'])) {
    if ($event->queryWithCmd("delete from " . $event->getTableName())) {
        echo "<script>window.open('index.php?mod=guest','_self');</script>";
    }
}

if (isset($_GET['cost_id']) && ($_SESSION['per'] == 1 || $_SESSION['per'] == 2)) {
    $cost_id = (isset($_GET['cost_id'])) ? $_GET['cost_id'] : 0;
    $cost = (isset($_GET['cost'])) ? $_GET['cost'] : 0;
    $param = [
        "guest_cost" => $guest->setSafeValue($cost)
    ];
    $query = [
        "where" => "guest_id = '" . $cost_id . "'"
    ];
    $guest->setParam($param);
    $guest->setQuery($query);
    if ($guest->updateData()) {
        echo "<script>window.open('index.php?mod=guest','_self');</script>";
    } else {
        echo "<script>
                if (confirm('Đã có lỗi xảy ra')){
                    window.open('index.php?mod=guest','_self');
                } else {
                    window.open('index.php?mod=guest','_self');
                }
        </script>";
    }
}


if (isset($_POST['add'])) {
    $name = (isset($_POST['_name'])) ? $_POST['_name'] : "";
    $phone = (isset($_POST['_phone'])) ? $_POST['_phone'] : "";
    $num = (isset($_POST['_num'])) ? strtoupper($_POST['_num']) : "";
    $car = (isset($_POST['_car'])) ? $_POST['_car'] : "";
    $nv = (isset($_POST['_nv'])) ? $_POST['_nv'] : "";
    $note = (isset($_POST['_note'])) ? $_POST['_note'] : "";
    $cus = (isset($_POST['_cus'])) ? $_POST['_cus'] : 0;
    $day = Date('d-m-Y');
    $id_user = (isset($_SESSION['id_user'])) ? $_SESSION['id_user'] : "";
    $param = [
        "guest_date" => $day,
        "guest_name" => $guest->setSafeValue($name),
        "guest_phone" => $guest->setSafeValue($phone),
        "guest_number_car" => $guest->setSafeValue($num),
        "guest_model" => $guest->setSafeValue($car),
        "guest_sale" => $guest->setSafeValue($nv),
        "guest_type" => $guest->setSafeValue($cus),
        "guest_comment" => $guest->setSafeValue($note),
        "guest_user_create" => $id_user
    ];
    $guest->setParam($param);
    if ($guest->createData()) {
        echo "<script>window.open('index.php?mod=guest','_self');</script>";
    } else {
        echo "<script>
        if (confirm('Đã có lỗi xảy ra')){
            window.open('index.php?mod=guest','_self');
        } else {
            window.open('index.php?mod=guest','_self');
        }
</script>";
    }
}
?>
<form id="fuser" action="index.php?mod=guest" method="post" autocomplete="off">
    <p style="text-align: right;"><span class="btn-del" onclick="hide()">X</span></p>
    <div>
        <label for="_name">Họ và tên: </label>
        <input type="text" id="_name" name="_name" autofocus="autofocus" required="required"
               placeholder="Vui lòng viết hoa chữ cái đầu - VD: Nguyễn Văn A"/>
    </div>
    <div>
        <label for="_phone">Điện thoại: </label>
        <input type="text" id="_phone" name="_phone" required="required" placeholder="Số điện thoại khách hàng"/>
    </div>
    <div>
        <label for="_num">Số xe/Số khung: </label>
        <input type="text" id="_num" name="_num" required="required"
               placeholder="Nhập đúng định dạng số xe - VD: 67L-12345"/>
    </div>
    <div>
        <label for="_car">Loại xe: </label>
        <input type="text" id="_car" name="_car" required="required"/>
    </div>
    <div>
        <label for="_nv">Tư vấn viên(Nếu có): </label>
        <input type="text" id="_nv" name="_nv"/>
    </div>
    <div>
        <label for="_cus">Loại dịch vụ: </label>
        <select name="_cus" id="_cus">
            <?php
            for ($i = 0; $i < count($dataService); $i++) {
                echo "<option value='" . $dataService[$i]['service_id'] . "'>" . $dataService[$i]['service_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="_note">Ghi chú(Nếu có): </label>
        <textarea name="_note" id="_note" style="width: 100%;resize: none;height:50px;font-size:120%;"></textarea>
    </div>
    <input type="submit" name="add" value="Xác nhận"/>
</form>
<form class="tb" action="index.php?mod=guest" method="post" autocomplete="off" style="display: none;">
    <p style="text-align: right;"><span class="btn-del" onclick="hideUpdate()">X</span></p>
    <div>
        <label for="a">Họ và tên: </label>
        <input type="text" id="a" name="a" autofocus="autofocus" required="required"/>
    </div>
    <div>
        <label for="b">Điện thoại: </label>
        <input type="text" id="b" name="b" required="required"/>
    </div>
    <div>
        <label for="c">Số xe: </label>
        <input type="text" id="c" name="c" required="required"/>
    </div>
    <div>
        <label for="d">Loại xe: </label>
        <input type="text" id="d" name="d" required="required"/>
    </div>
    <div>
        <label for="e">Tư vấn viên(Nếu có): </label>
        <input type="text" id="e" name="e"/>
    </div>
    <div>
        <label for="f">Loại dịch vụ: </label>
        <select name="f" id="f">
            <?php
            for ($i = 0; $i < count($dataService); $i++) {
                echo "<option value='" . $dataService[$i]['service_id'] . "'>" . $dataService[$i]['service_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="g">Ghi chú(Nếu có): </label>
        <textarea name="g" id="g" style="width: 100%;resize: none;height:50px;font-size:120%;"></textarea>
    </div>
    <input type="hidden" id="id_guest" name="id_guest"/>
    <input type="submit" id="update" name="update" value="Cập nhật"/>
</form>
<div class="clearfix">
    <form style="float:left;" action="index.php?mod=guest" method="post">
        <span style="font-weight: bold;">Lọc từ: </span><input type="date" name="date_" style="padding: 5px 10px;"
                                                               value="<?php if (isset($_SESSION['date_chosen'])) echo date('Y-m-d', strtotime($_SESSION['date_chosen'])); else echo date('Y-m-d'); ?>"/>
        <input type="submit" name="find" value="Xem"
               style="padding: 10px 20px; border-radius: 5px; background-color: goldenrod; color: black; font-weight: bold;"/>&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="fa fa-retweet" onclick="window.open('index.php?mod=guest&vote_del=true','_self')"
              style="cursor: pointer;font-size:22pt;color:blue;"></span>
    </form>
    <form style="float:right;" action="index.php?mod=guest" method="post">
        <span style="font-weight: bold;">Biển số xe/số khung:</span> <input type="text" name="number_car"
                                                                            style="padding: 5px 10px;"
                                                                            required="required"/>
        <input type="submit" name="find_num" value="Tìm kiếm"
               style="padding: 10px 20px; border-radius: 5px; background-color: goldenrod; color: black; font-weight: bold;"/>
    </form>
</div>
<br/>
<div style="overflow-x: auto;">
    <table class="tb-user">
        <tr>
            <th>STT</th>
            <th>Tạo lệnh</th>
            <th>Khách hàng</th>
            <th>Số điện thoại</th>
            <th>Số xe/Số khung</th>
            <th>Loại xe</th>
            <th>Tư vấn viên</th>
            <th>Loại dịch vụ</th>
            <th>Giá thanh toán</th>
            <th>Người tạo</th>
            <th>Hành động</th>
        </tr>
        <?php
        $temp = 1;
        for ($i = 0; $i < count($dataGuest); $i++) {
            $cost = "";
            $firstDay = strtotime($dataGuest[$i]['guest_date']);
            if (isset($_POST['find_num']))
                $secondDay = strtotime($param_find);
            else
                $secondDay = strtotime($_SESSION['date_chosen']);
            if ($firstDay >= $secondDay) {
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
                $txt = "<td class='kd'>" . $name[0]['service_name'] . "</td>";
                $checkExist = [
                    "select" => "*",
                    "where" => "vote_guest = '" . $dataGuest[$i]['guest_id'] . "'"
                ];
                $vote->setQuery($checkExist);
                $flag = $vote->isExistRow($vote->queryData());
                if ($dataGuest[$i]['guest_cost'] == 0)
                    if ($_SESSION['per'] == 1 || $_SESSION['per'] == 2)
                    $cost = "<td><a href='#' class='btn-del' onclick=\"editCost('".$dataGuest[$i]['guest_id']."')\">Cập nhật giá</a></td>";
                    else $cost = "<td style='color:crimson; font-weight: bold;'>Chưa có giá</td>";
                if ($dataGuest[$i]['guest_cost'] != 0){
                    if (!$flag && ($_SESSION['per'] == 1 || $_SESSION['per'] == 2))
                    $cost = "<td style='color:crimson; font-weight: bold;'><a style='text-decoration: none;color:crimson;' href='#' onclick=\"editCost('".$dataGuest[$i]['guest_id']."')\">" . number_format($dataGuest[$i]['guest_cost']) . "</a></td>";
                    else {
                        if ($_SESSION['per'] == 1)
                            $cost = "<td style='color:crimson; font-weight: bold;'><a style='text-decoration: none;color:crimson;' href='#' onclick=\"editCost('".$dataGuest[$i]['guest_id']."')\">" . number_format($dataGuest[$i]['guest_cost']) . "</a></td>";
                        else
                        $cost = "<td style='color:crimson; font-weight: bold;'>" . number_format($dataGuest[$i]['guest_cost']) . "</td>";
                    }
                }
                if ($dataGuest[$i]['guest_type'] == 1)
                    $cost = "<td></td>";
                echo " <tr>
            <td>" . ($temp++) . "</td>
            <td>" . $dataGuest[$i]['guest_date'] . "</td>
            <td>" . $dataGuest[$i]['guest_name'] . "</td>
            <td>" . $dataGuest[$i]['guest_phone'] . "</td>
            <td>" . $dataGuest[$i]['guest_number_car'] . "</td>
            <td>" . $dataGuest[$i]['guest_model'] . "</td>
            <td>" . $dataGuest[$i]['guest_sale'] . "</td>
            $txt $cost
            <td>" . $name_user . "</td>";
                if ($_SESSION['id_user'] == 1) {
                    echo "<td><a href='#' class='btn-del' onclick=\"del('" . $dataGuest[$i]['guest_id'] . "')\">Xóa</a>&nbsp;<a href='#' class='btn-edit' onclick=\"edit('" . $dataGuest[$i]['guest_name'] . "','" . $dataGuest[$i]['guest_number_car'] . "','" . $dataGuest[$i]['guest_model'] . "','" . $dataGuest[$i]['guest_sale'] . "','" . $dataGuest[$i]['guest_type'] . "','" . $dataGuest[$i]['guest_id'] . "','" . $dataGuest[$i]['guest_comment'] . "')\">Sửa</a>&nbsp;" . ((!$flag) ? "<a href='#' class='btn-info' onclick=\"vote('" . $dataGuest[$i]['guest_id'] . "')\">Đánh giá</a>" : "<a href='#' class='btn-del'>Đã đánh giá</a>") . "</td>
        </tr>";
                } else {
                    if (!$flag)
                        echo "<td><a href='#' class='btn-info' onclick=\"vote('" . $dataGuest[$i]['guest_id'] . "')\">Đánh giá</a></td>";
                    else echo "<td><a class='btn-del' href='#'>Đã đánh giá</a></td>";
                }
            }
        }
        ?>
    </table>
</div>
<script>
    document.getElementById("khachhang").style.color = "white";
    document.getElementById("khachhang").style.backgroundColor = "gray";

    function del(id_del) {
        if (confirm('Bạn có chắc muốn xóa')) {
            window.open('index.php?mod=guest&id=' + id_del, '_self');
        }
    }

    function edit(name, number, model, sale, type, id, note) {
        hide();
        document.getElementsByClassName("tb")[0].style.display = "block";
        document.getElementById("a").value = name;
        document.getElementById("c").value = number;
        document.getElementById("d").value = model;
        document.getElementById("e").value = sale;
        document.getElementById("g").value = note;
        document.getElementById("id_guest").value = id;
        switch (type) {
            // document.getElementById("f").selectedIndex = "0";
        <?php
            for ($i = 0; $i < count($dataService); $i++) {
                echo "case '" . $dataService[$i]['service_id'] . "' : {document.getElementById('f').selectedIndex = '" . $i . "';} break;";
            }
            echo "default: ''; break;";
            ?>
        }
    }

    function vote(event_set) {
        if (confirm('Xác nhận mở đánh giá cho khách hàng')) {
            window.open('index.php?mod=guest&vote=' + event_set, '_self');
        }
    }

    function editCost(id) {
        var result = prompt("Vui lòng nhập giá quyết toán: ");
        if (result != null) {
            window.open('index.php?mod=guest&cost_id=' + id + '&cost=' + result,'_self');
        }
    }
</script>