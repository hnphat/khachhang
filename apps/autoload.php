<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 05/07/2019
 * Time: 8:01 PM
 */
    spl_autoload_register(function($className){
       $etc = str_replace('_','/',strtolower($className));
       $path = str_replace('apps','',dirname(__dir__));
       include_once $path.'/'.$etc.'.php';
    });
?>