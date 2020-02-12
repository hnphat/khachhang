<?php
session_start();
define('ADMIN', 1);
include '../apps/autoload.php';
$user = new Apps_Control_User();
if (isset($_POST['submit'])) {
    if (isset($_POST['user']))
        $username = $_POST['user'];
    if (isset($_POST['password'])) {
        $pass = $_POST['password'];
    }
    $query = [
        "select" => "*",
        "where" => "user_name = '" . $username . "' and user_password = '" . md5($pass) . "'"
    ];
    $user->setQuery($query);
    $result = $user->queryData();
    if ($user->isExistRow($result)) {
        $dataUser = $user->getResultFromSelectQuery($result);
        $_SESSION['per'] = $user->getOneRow($dataUser)['user_permission'];
        $_SESSION['name'] = $user->getOneRow($dataUser)['user_fullname'];
        $_SESSION['id_user'] = $user->getOneRow($dataUser)['user_id'];
        echo "<script>
                window.open('index.php','_self');
              </script>";
    } else echo "<script>
                window.confirm('Sai tài khoản hoặc mật khẩu');
              </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administrator Control Panel</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <style>
        * {
            font-family: 'Roboto', sans-serif;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        body {
            background-image: url('resource/image/bg.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        #contain {
            min-height: 700px;
            background: url('resource/image/login_bg.jpg') no-repeat center center;
        }
        #main {
            max-width: 100%;
            height: 100%;
            margin: auto;
        }

        #main nav ul {
            list-style-type: none;
        }

        #main nav ul li {
            float: left;
        }

        #main nav ul li a {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
            background-color: lightgray;
            color: #003cb3;
        }

        #main nav ul li a:hover {
            color: white;
            background-color: gray;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        nav {
            padding: 10px 0;
        }

        .btn-add {
            padding: 10px 15px;
            background-color: lightgreen;
            color: black;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.5s;
        }
        .btn-add:hover {
            background-color: green;
            color: white;
        }
        .btn-edit {
            padding: 5px 10px;
            background-color: goldenrod;
            color: black;
            font-weight: bold;
            font-size: 10pt;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.5s;
        }
        .btn-edit:hover {
            background-color: gold;
            color: white;
        }
        .tb-user {
            width: 100%;
            border-collapse: collapse;
        }

        .tb-user, .tb-user th, .tb-user td {
            border: 1px solid lightgray;
            padding: 10px 5px;
            text-align: center;
        }
        .btn-del {
            text-decoration: none;
            color: white;
            background-color: tomato;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 10pt;
        }
        .dv {
            color: brown;
            font-size: 10pt;
            font-weight: bold;
        }
        .kd {
            color: blue;
            font-size: 10pt;
            font-weight: bold;
        }
        .btn-del:hover {
            opacity: 0.8;
        }
        .btn-lock {
            text-decoration: none;
            color: white;
            background-color: orange;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 10pt;
        }
        .btn-lock:hover {
            opacity: 0.8;
        }
        .btn-info {
            text-decoration: none;
            color: white;
            background-color: royalblue;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 10pt;
        }
        .btn-info:hover {
            opacity: 0.8;
        }
        #fuser {
            max-width: 500px;
            margin: auto;
            border: 1px solid lightgray;
            padding: 20px;
            box-shadow:  0 0 5px gray;
            display: none;
        }
        #fuser div {
            margin: 10px;
        }
        #fuser label {
            font-weight: bold;
        }
        #fuser input[type="text"],#fuser input[type="file"] , #fuser input[type="password"], #fuser select, #fuser input[type="submit"], #fuser input[type="number"] {
            padding: 5px;
            width: 100%;
            font-size: 120%;
            border-radius: 5px;
        }
        #fuser input:focus {
            background-color: antiquewhite;
        }
        #fuser input[type="submit"] {
            background-color: limegreen;
            color: black;
            font-weight: bold;
        }
        .tb {
            max-width: 500px;
            margin: auto;
            border: 1px solid lightgray;
            padding: 20px;
            box-shadow:  0 0 5px gray;
        }
        .tb div {
            margin: 10px;
        }
        .tb label {
            font-weight: bold;
        }
        .tb input[type="text"], .tb input[type="password"], .tb select, .tb input[type="submit"] {
            padding: 5px;
            width: 100%;
            font-size: 120%;
            border-radius: 5px;
        }
        .tb input:focus {
            background-color: antiquewhite;
        }
        .tb input[type="submit"] {
            background-color: limegreen;
            color: black;
            font-weight: bold;
        }
        input[type="radio"] {
            height: 15px;
            width: 15px;
        }
        #wrong, #success {
            display: none;
        }

    </style>
</head>
<body>
<div id="main">
    <?php
    if (isset($_SESSION['per'])) {
    ?>
        <p style="color: red;margin:10px;"><a href="index.php?mod=logout">Đăng xuất</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="../" target="_blank">Trang đánh giá</a>
        </p>
    <h2>Xin chào: <?php echo $_SESSION['name'];?></h2>

    <nav class="clearfix">
        <ul>
            <?php
                switch ($_SESSION['per']){
                    case 1: {
                        echo "<li><a href=\"index.php?mod=home\">Trang chủ</a></li>
            <li><a id='quanly' href=\"index.php?mod=user\">Tài khoản</a></li>
            <li><a id='service' href=\"index.php?mod=service\">Dịch vụ</a></li>            
            <li><a id='quest' href=\"index.php?mod=question\">Câu hỏi</a></li>
            <li><a id='khachhang' href=\"index.php?mod=guest\">Khách hàng</a></li>
            <li><a id='thongke' href=\"index.php?mod=counter\">Thống kê</a></li>";
                    } break;
                    case 2:
                        case 3:{
                        echo "<li><a href=\"index.php?mod=home\">Trang chủ</a></li>
            <li><a id='khachhang' href=\"index.php?mod=guest\">Khách hàng</a></li>";
                    } break;
                    case 4: {
                        echo "<li><a href=\"index.php?mod=home\">Trang chủ</a></li>
            <li><a id='cauhoi' href=\"index.php?mod=question\">Câu hỏi</a></li>
            <li><a id='khachhang' href=\"index.php?mod=guest\">Khách hàng</a></li>
            <li><a id='thongke' href=\"index.php?mod=counter\">Thống kê</a></li>";
                    } break;
                     default: ""; break;
                }
            ?>
        </ul>
    </nav>
    <div>
        <?php
        (isset($_GET['mod'])) ? $mode = $_GET['mod'] : $mode = 'home';
        include '../apps/mod.php';
        ?>
    </div>
        <?php
    } else {
        ?>
        <div id="contain">
            <h4 style="padding:20px;"><a href="../" style="color: white; text-decoration: none;">>> Trang đánh giá</a></h4>
            <br>
            <br>
            <h1 style="color: white; text-align: center;">ĐĂNG NHẬP HỆ THỐNG</h1><br/>
            <div style="width: 400px;margin: auto;">
                <form action="index.php" method="post" autocomplete="off">
                    <div style="margin: 5px;">
                        <input type="text" style="width: 100%;padding: 5px; font-size: 120%;" id="user" name="user" required="required" autofocus="autofocus" placeholder="Tài khoản"/>
                    </div>
                    <div style="margin: 5px;">
                        <input type="password" id="pwd" name="password" style="width: 100%;padding: 5px;font-size: 120%;" required="required" placeholder="Mật khẩu"/>
                    </div>
                    <input type="submit" style="width:100%;padding: 10px;background-color: yellowgreen;border: none;font-weight: bold;border-radius: 5px;" name="submit" value="Đăng nhập"/>
                </form>
            </div>
        </div>&nbsp;
        <?php
    }
    ?>
</div>
</body>
</html>


