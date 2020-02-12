<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 24/10/2019
 * Time: 1:59 PM
 */
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
 $conn = new mysqli("localhost","root","","khachhang");
 //$conn = new mysqli("112.213.89.41","hyundaia","Admin@2018","hyundaia_khachhang");
 $sql = "select * from tbl_event";
 $result = $conn->query($sql);
 $count = $result->num_rows;
 if ($_SESSION['count'] != $count) {
 	$data = "SELECT * FROM tbl_event WHERE event_id = (SELECT max(event_id) FROM tbl_event)";
 	$result = $conn->query($data);
 	$row = $result->fetch_assoc();
 	echo "data: ".$row['event_set']."\n\n"; // Quan trọng phải có /n/n
 	flush();
 	$_SESSION['count'] = $count;
 }
?>