<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 31/07/2019
 * Time: 7:30 PM
 */
defined("ALLOW") or die("<p style='text-align: center;'><img src='image/khoa.jpg' alt='lock'/></p>");
switch($do) {
    //case "trang-chu": include "body.php"; break;
    case "trang-chu": include "main.php"; break;
    case "vote": include "vote.php"; break;
    case "thank": include "thank.php"; break;
    default: include "router.php";
}

?>