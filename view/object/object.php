<?php

include '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

if (isset($_POST["plan"]) && !empty($_POST["plan"])) {
    $arrUserCol = [];
    ($_POST["plan"] === "split") ? array_push($arrUserCol, $_POST["splitFirstCol"]) : array_push($arrUserCol, $_POST["addFirstCol"], $_POST["addThirdCol"]);
}

class MyReadFilter implements IReadFilter {

    public $userColRow = "";
    public $arrColRowSplit = [];
    public $arrColRowAdd = array("firstCol" => array(), "secondCol" => array());
    public $dataCol = [];

    public function __construct($data = "") {
        $this->userColRow = $data;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //all column which have data
        array_push($this->dataCol, $column);
        //split- only one column 
        if (count($this->userColRow) == 1) {
            if (strtoupper($this->userColRow[0]) === $column) {
                array_push($this->arrColRowSplit, $column . $row);
            }
        }
        //add - two columns
        else {
            if (strtoupper($this->userColRow[0]) === $column) {
                array_push($this->arrColRowAdd["firstCol"], $column . $row);
            }
            if (strtoupper($this->userColRow[1]) === $column) {
                array_push($this->arrColRowAdd["secondCol"], $column . $row);
            }
        }
        return TRUE;
    }

}

$reader = IOFactory::createReader("Xlsx");
$filter = new MyReadFilter($arrUserCol);

if (isset($_POST) && !empty($_POST)) {
    if (isset($_FILES) && !empty($_FILES)) {
        $name = $_FILES["fileCk"]["name"];
        $nameProcess = substr($name, strlen($name) - 4);
        if ($nameProcess === "xlsx") {
            //tem_name for load
            $tempName = $_FILES["fileCk"]["tmp_name"];
            //setReadFilter() method filter the data
            $reader->setReadFilter($filter);
            $spreadsheet = $reader->load($tempName);
            //sort the array key
            $splitAdd = ($_POST["plan"] === "split") ? "split" : "add";

            if ($splitAdd === "split") {
                //if usr put Column have data
                if (count($filter->arrColRowSplit) > 0) {
                    //store all split data for using
                    $arrAllDataSplit = array();
                    $len = count($filter->arrColRowSplit);
                    for ($i = 0; $i < $len; $i++) {
                        array_push($arrAllDataSplit, $spreadsheet->getActiveSheet()->getCell($filter->arrColRowSplit[$i])->getValue());
                    }
                    //remove empty key;
                    $arrSplitFilter = array_filter($_POST);
                    //if user put symbol
                    if (array_key_exists("splitSecondCol", $arrSplitFilter)) {
                        //key available
                        $splitSymbol = trim($arrSplitFilter["splitSecondCol"]);
                        //if only character a-zA-z0-9 or upto 1 
                        if (preg_match("/\w/", $splitSymbol) || strlen($splitSymbol) > 1) {
                            echo "eg: a-z or 0-9 not allowed, only -one symbol!symbolSplit";
                            return FALSE;
                        }
                        else {
                            //here available one symbol.........
                            $processSplit= array_map(function($value){
                                if(strchr($value, "|")!==FALSE){
                                    return explode("|", $value);
                                }
                            }, $arrAllDataSplit);
                            $endProcessSplit= array_values(array_filter($processSplit));
                            print_r($endProcessSplit);
                        }
                    }
                    //if user not put any symbol then take 'space' default
                    else {
                        //here available split 'space'............
                    }
                }
                else {//empty column
                    $array_unique = array_unique($filter->dataCol);
                    $array_reduce = array_reduce($array_unique, function($v1, $v2) {
                        return $v1 . "-" . $v2;
                    });
                    echo "only " . ltrim($array_reduce, "-") . " column have value!symbolSplit";
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