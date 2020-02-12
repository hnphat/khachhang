<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 12/07/2019
 * Time: 9:07 PM
 */
if (isset($_GET['file'])) {
    $myfile = fopen($_GET['file'], "r") or die("Unable to open file!");
// Output one line until end-of-file
    $arr = [];
    while (!feof($myfile)) {
        array_unshift($arr, fgets($myfile) . "<br>");
    }
    fclose($myfile);
    $temp = 1;
    $arr2 = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($temp != 30)
            array_unshift($arr2, $arr[$i]);
        else break;
        $temp++;
    }

    foreach ($arr2 as $value) {
        echo $value;
    }
} elseif ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo "$entry\n";
        }
    }
    closedir($handle);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Watch Log</title>
</head>
<body>
</body>
</html>
