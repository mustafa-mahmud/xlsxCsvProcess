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
                //search user inputed column with all value available column
                if (array_search(strtoupper($_POST["splitFirstCol"]), $arrValues) !== FALSE) {
                    //remove empty key;
                    $arrSplitFilter = array_filter($_POST);
                    if (array_key_exists("splitSecondCol", $arrSplitFilter)) {
                        //key available
                        $splitSymbol = $arrSplitFilter["splitSecondCol"];
                        //if only character a-zA-z0-9
                        if (preg_match("/\w/", $splitSymbol) || strlen($splitSymbol) > 1) {
                            echo "eg: a-z or 0-9 not allowed, only -one symbol!symbolSplit";
                            return FALSE;
                        }
                        else{
                            //here availabe split 'one symbol'.........
                        }
                    }
                    else {
                        //here available split 'space'............
                    }
                }
                else {//empty column
                    $array_reduce = array_reduce($arrValues, function($v1, $v2) {
                        return $v1 . "-" . $v2;
                    });
                    echo "eg:" . " only" . ltrim($array_reduce, "-") . " column have value(split)";
                    return FALSE;
                }
            }
            if ($splitAdd === "add") {
                
            }
        }
        else {
            echo "eg: sorry someting went wrong !";
        }
    }
}