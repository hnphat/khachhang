<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 06/07/2019
 * Time: 10:26 AM
 */

switch ($mode) {
    case "home":
        include "home.php";
        break;
    case "user":
        include "view/user.php";
        break;
    case "question":
        include "view/question.php";
        break;
    case "guest":
        include "view/guest.php";
        break;
    case "counter":
        include "view/counter.php";
        break;
    case "chitiet":
        include "view/chitiet.php";
        break;
    case "service":
        include "view/service.php";
        break;
    case "capturn":
        include "view/capturn.php";
        break;
    case "logout":
        {
            unset($_SESSION['per']);
            echo "<script>window.open('index.php','_self');</script>";
        }
        break;
    default: echo "<div class='container'><h1 class='text-center text-danger'>Page not found!</h1></div>";
}

?>