<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 31/07/2019
 * Time: 7:30 PM
 */
$firstLink = $unity->getTheFirstLink($do);
$secondLink = $unity->getTheSecondLink($do);
$typeData = $unity->getStringFromNumber($secondLink);
switch($typeData) {
    case "post": include "view/handle/tin-tuc.php"; break;
    default: echo "<div class='container'><h1 class='text-center text-danger'>Không tìm thấy trang bạn cần!</h1></div>";
}

?>