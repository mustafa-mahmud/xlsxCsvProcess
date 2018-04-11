<?php

include '../../vendor/autoload.php';

use xlsxCsv\model\wordProcessClass;
use xlsxCsv\model\MyReadFilter;

$object = new wordProcessClass();
$filter = new MyReadFilter();

if (isset($_POST) && !empty($_POST)) {
    if (isset($_FILES) && !empty($_FILES)) {
        $name = $_FILES["fileCk"]["name"];
        $nameProcess = substr($name, strlen($name) - 4);
        if ($nameProcess === "xlsx") {
            $object->readData($_FILES);
            $filter->readCell($_POST);


            // file ok; send data to class;
        }
        else {
            echo "eg: please choose .xlsx file";
        }
    }
}

