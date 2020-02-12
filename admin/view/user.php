<?php
if (!isset($_SESSION['per']) || $_SESSION['per'] != 1)
    echo "<script>window.open('index.php','_self');</script>";
?>
    <br>
    <a href="#" class="btn-add" onclick="show()">Thêm mới</a>
    <br><br>
    <div id="wrong">
        <h1 style="color: red; font-weight: bold;text-align:center;">Mật khẩu không khớp</h1>
    </div>
    <div id="success">
        <h1 style="color: green; font-weight: bold;text-align:center;">Đã thêm</h1>
    </div>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $param = [
        "user_id" => $id
    ];
    $user->setParam($param);
    if ($user->deleteWithId()) {
        echo "<script>
                window.open('index.php?mod=user','_self');
                    </script>";
    } else {
        echo "<script>if(confirm('Không thể xóa lúc này, liên hệ IT để được xử lý!'))
            {
                window.openn('index.php?mod=user','_self');
            } else {
    window.openn('index.php?mod=user','_self');
            }
</script>";
    }
}
if (isset($_POST['add_user'])) {
    $acc = (isset($_POST['user'])) ? $_POST['user'] : "";
    $fullname = (isset($_POST['fullname'])) ? $_POST['fullname'] : "";
    $pass1 = (isset($_POST['pass1'])) ? $_POST['pass1'] : "";
    $pass2 = (isset($_POST['pass2'])) ? $_POST['pass2'] : "";
    $per = (isset($_POST['per'])) ? $_POST['per'] : "";
    if ($pass1 == $pass2) {
        $param = [
            "user_name" => $user->setSafeValue($acc),
            "user_fullname" => $user->setSafeValue($fullname),
            "user_password" => $user->setSafeValue(md5($pass1)),
            "user_permission" => $user->setSafeValue($per),
            "user_active" => 1
        ];
        $user->setParam($param);
        if ($user->createData()) {
            echo "<script>document.getElementById('success').style.display = 'block';</script>";
        } else {
            echo "<script>
                    document.getElementById('wrong').style.display = 'block';
                    document.getElementById('wrong').innerHTML = '<h2 style=\'color: red; font-weight: bold; text-align:center;\'>Không thể thêm người dùng</h2>';
                    </script>";
        }
    } else {
        echo "<script>document.getElementById('wrong').style.display = 'block';</script>";
    }
}
?>
    <form id="fuser" action="index.php?mod=user" method="post" autocomplete="off">
        <p style="text-align: right;"><span class="btn-del" onclick="hide()">X</span></p>
        <div>
            <label for="user">Tên đăng nhập: </label>
            <input type="text" id="user" name="user" autofocus="autofocus" required="required"/>
        </div>
        <div>
            <label for="fullname">Tên đầy đủ: </label>
            <input type="text" id="fullname" name="fullname" required="required"/>
        </div>
        <div>
            <label for="pass1">Mật khẩu: </label>
            <input type="password" id="pass1" name="pass1" required="required"/>
        </div>
        <div>
            <label for="pass2">Nhập lại mật khẩu: </label>
            <input type="password" id="pass2" name="pass2" required="required"/>
        </div>
        <div>
            <label for="per">Quyền: </label>
            <select name="per" id="per">
                <option value="1">Admin</option>
                <option value="2">Thu ngân Dịch vụ</option>
                <option value="3">Thu ngân Kinh doanh</option>
                <option value="4">CSKH</option>
                <option value="5">Sale</option>
                <option value="6">Kiểm tra cuối</option>
            </select>
        </div>
        <input type="submit" name="add_user" value="Xác nhận"/>
    </form>
    <br><br>
    <form class="tb" id="fpass" action="index.php?mod=user" method="post" style="display:none;">
        <p style="text-align: right;"><span class="btn-del" onclick="hideChange()">X</span></p><br>
        <input type="password" name="pass" id="pass" placeholder="Mật khẩu cần đổi" autofocus="autofocus"/>
        <input type="hidden" name="id_change" id="id_change"/>
        <input type="submit" name="change_pass" value="Cập nhật mật khẩu"/>
    </form>
    <br>
    <table class="tb-user">
        <caption align="bottom" style="padding: 10px;">Bảng User: Thông tin người sử dụng</caption>
        <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Tài khoản</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
        <?php
        $query = [
            "select" => "*"
        ];
        $user->setQuery($query);
        $dataUser = $user->getResultFromSelectQuery($user->queryData());
        for ($i = 0; $i < count($dataUser); $i++) {
            $permis = "";
            switch ($dataUser[$i]['user_permission']) {
                case 1:
                    $permis = "Admin";
                    break;
                case 2:
                    $permis = "Dịch vụ";
                    break;
                case 3:
                    $permis = "Kinh doanh";
                    break;
                case 4:
                    $permis = "CSKH";
                    break;
                case 5:
                    $permis = "Sale";
                    break;
                case 6:
                    $permis = "Kiểm tra cuối";
                    break;
                default:
                    $permis = "";
                    break;
            }
            echo "<tr>
        <td>" . ($i + 1) . "</td>
        <td>" . $dataUser[$i]['user_fullname'] . "</td>
        <td>" . $dataUser[$i]['user_name'] . "</td>
        <td>" . $permis . "</td>
        <td><a onclick='del" . $dataUser[$i]['user_id'] . "()' href='#' class='btn-del'>Xóa</a>&nbsp;<a href='#' class='btn-edit' onclick=\"edit('" . $dataUser[$i]['user_id'] . "')\">Đổi mật khẩu</a></td>
    </tr>";
        }
        ?>
    </table>
    <script>
        function show() {
            document.getElementById("fuser").style.display = "block";
            document.getElementById("fpass").style.display = "none";
        }

        function hide() {
            document.getElementById("fuser").style.display = "none";
        }

        function hideChange() {
            document.getElementById("fpass").style.display = "none";
        }

        function edit(id) {
            document.getElementById("fpass").style.display = "block";
            document.getElementById("id_change").value = id;
            document.getElementById("fuser").style.display = "none";
        }

        <?php
        for ($i = 0; $i < count($dataUser); $i++) {
            echo "function del" . $dataUser[$i]['user_id'] . "(){
                if (confirm('Bạn có chắc muốn xóa?')){
                   window.open('index.php?mod=user&id=" . $dataUser[$i]['user_id'] . "','_self');
                } 
           }";
        }
        ?>
        document.getElementById("quanly").style.color = "white";
        document.getElementById("quanly").style.backgroundColor = "gray";
    </script>
<?php
if (isset($_POST['change_pass'])) {
    $id = $_POST['id_change'];
    $pass = $_POST['pass'];
    $param = [
        "user_password" => md5($pass)
    ];
    $user->setParam($param);
    $query = [
        "where" => "user_id = '" . $id . "'"
    ];
    $user->setQuery($query);
    if ($user->updateData()) {
        echo "<script>
        if (confirm('Đã đổi mật khẩu')) {
            window.open('index.php?mod=user','_self');
        } else {window.open('index.php?mod=user','_self');}
</script>";
    } else echo "<script>
        if (confirm('Đổi mật khẩu không thành công')) {
            window.open('index.php?mod=user','_self');
        } else {window.open('index.php?mod=user','_self');}
</script>";
}
?>