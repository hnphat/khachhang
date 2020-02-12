<?php
session_start();
define("ALLOW", 1);
include 'apps/autoload.php';
//----------------- Dữ liệu tin tức -----------------------------
?>
<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <title>Ý kiến khách hàng</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="shortcut icon" href="admin/resource/image/hyundai-fav.png"/>
    <meta name="author" content="HNP Solutions"/>
    <meta name="description" content="Khảo sát ý kiến khách hàng"/>
    <meta name="revisit-after" content="1 days"/>
    <meta name="robots" content="INDEX, FOLLOW"/>
    <?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo "<link rel=\"canonical\" href=\"$actual_link\"/>";
    ?>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        #main {
            max-width: 1024px;
            height: auto;
            margin: auto;
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
        .btn-info {
            text-decoration: none;
            color: white;
            background-color: royalblue;
            border-radius: 5px;
            padding: 10px 10px;
            font-size: 10pt;
        }
        .btn-info:hover {
            opacity: 0.8;
        }
        .btn-edit {
            padding: 10px 10px;
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
        .check_box_user {
            height: 18px;
            width: 18px;
        }
        .btn-send {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            font-size: 120%;
            font-width: bold;
            border-radius: 0 0 5px 5px;
            border: none;
        }
        body {
            background-image: url('admin/resource/image/bg.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        .sizez {
            font-size: 150%;
        }
    </style>
    <script>
        if (typeof(EventSource) !== "undefined"){
            var source = new EventSource("event_handle.php");
            source.onmessage = function(event){
                window.open('index.php?do=vote&id=' + event.data,'_self');
            }
        }
    </script>
</head>
<body>
<div id="main">
    <h3 style="margin: 10px;"><a style="text-decoration: none;" href="./">Trang chủ</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="text-decoration: none;" href="./admin"> Quản lý</a></h3>
    <div>
        <?php
        (isset($_GET['do'])) ? $do = $_GET['do'] : $do = 'trang-chu';
        include 'do.php';
        ?>
    </div>
</div>
</body>
</html>
