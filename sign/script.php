<?php 
	$data = $_POST['photo'];
	$name = $_POST['name'];
	$date_car = $_POST['date_car'];
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);
    file_put_contents("./photos/".$name.'-'.$date_car.'.png', $data);
    die;
?>