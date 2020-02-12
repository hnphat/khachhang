<?php
defined("ADMIN") or die("<p style='text-align: center;'><img src='resource/image/khoa.jpg' alt='lock'/></p>");
//get host by name
if (file_exists("log.txt"))
unlink("log.txt");
if (file_exists("../log.txt"))
unlink("../log.txt");
?>
<?php
if($_SESSION['per'] < 5)
    echo "<img src=\"resource/image/customer.jpg\" alt=\"customer\" style=\"width: 100%; height: auto;\">
"; else echo "<script>window.open('index.php?mod=capturn','_self');</script>";
?>

