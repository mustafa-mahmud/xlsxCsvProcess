<?php

include '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class MyReadFilter implements IReadFilter {

    public $arr = [];

    public function readCell($column, $row, $worksheetName = '') {
        array_push($this->arr, $column);
        return TRUE;
    }

}

$reader = IOFactory::createReader("Xlsx");
$filter = new MyReadFilter();

if (isset($_POST) && !empty($_POST)) {
    if (isset($_FILES) && !empty($_FILES)) {
        $name = $_FILES["fileCk"]["name"];
        $nameProcess = substr($name, strlen($name) - 4);
        if ($nameProcess === "xlsx") {
            //tem_name for load
            $tempName = $_FILES["fileCk"]["tmp_name"];
            //setReadFilter() method filter the data
            $reader->setReadFilter($filter);
            $reader->load($tempName);
            //remove duplicate value from column 
            $arrUnique = array_unique($filter->arr);
            //sort the array key
            $arrValues = array_values($arrUnique);
            $splitAdd = ($_POST["plan"] === "split") ? "split" : "add";

            if ($splitAdd === "split") {
                if (array_search(strtoupper($_POST["splitFirstCol"]), $arrValues) !== FALSE) {
                    //remove empty key;
                    $arrSplitFilter = array_filter($_POST);
                    print_r($arrSplitFilter);
                }
                else{
                    echo "eg: ".$_POST["splitFirstCol"]. " - column no data(split)";
                    return FALSE;
                }
            }
            if ($splitAdd === "add") {
                
            }
        }
        else {
            echo "eg: please choose .xlsx file";
        }
    }
}