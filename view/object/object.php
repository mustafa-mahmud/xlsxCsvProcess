<?php

include '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
//this $spreadsheet2 will be worked for creating new worksheet
$spreadsheet2 = new Spreadsheet();

if (isset($_POST) && !empty($_POST)) {
    if (isset($_FILES) && !empty($_FILES)) {
        $name = $_FILES["fileCk"]["name"];
        $nameProcess = substr($name, strlen($name) - 4);
        if ($nameProcess === "xlsx") {
            //tem_name for load
            $tempName = $_FILES["fileCk"]["tmp_name"];
            //setReadFilter() method for filter the data
            $reader->setReadFilter($filter);
            //this $spreadsheet will be worked for reading user input worksheet value
            $spreadsheet = $reader->load($tempName);
            //sort the array key
            $splitAdd = ($_POST["plan"] === "split") ? "split" : "add";
            //start split plan
            if ($splitAdd === "split") {
                //if usr put Column have data
//                print_r($filter->arrColRowSplit);
//                die();
                if (count($filter->arrColRowSplit) > 0) {
                    //store all split data for using
                    $arrAllDataSplit = array();
                    //count total row of split 
                    $len = count($filter->arrColRowSplit);
                    for ($i = 0; $i < $len; $i++) {
                        //get the value for new worksheet 
                        array_push($arrAllDataSplit, trim($spreadsheet->getActiveSheet()->getCell($filter->arrColRowSplit[$i])->getValue()));
                    }
                    //remove empty key;
                    $arrSplitFilter = array_filter($_POST);
                    $symbol = (array_key_exists("splitSecondCol", $arrSplitFilter)) ? $arrSplitFilter["splitSecondCol"] : " ";
                    //if user put symbol
                    $GLOBALS["splitSymbol"] = "";
                    if ($symbol !== " ") {
                        //key available
                        $GLOBALS["splitSymbol"] = trim($symbol);
                        //if only character a-zA-z0-9 or upto 1 
                        if (preg_match("/\w/", $GLOBALS["splitSymbol"]) || strlen($GLOBALS["splitSymbol"]) > 1) {
                            echo "eg: a-z or 0-9 not allowed, only -one symbol!symbolSplit";
                            return FALSE;
                        }
                    }
                    //here available one symbol, $GLOBALS["splitSymbol"]=user symbol
                    //we checking that is symbol in $value?
                    $processSplit = array_map(function($value) {
                        if (strlen($GLOBALS["splitSymbol"]) > 0) {
                            if (strchr($value, $GLOBALS["splitSymbol"]) !== FALSE) {
                                return explode($GLOBALS["splitSymbol"], trim($value));
                            }
                        }
                        if (strlen($GLOBALS["splitSymbol"]) === 0) {
                            if (preg_match("/^[^~!@#$%^&*|]+$/", $value)) {
                                $substr_count = substr_count($value, " ");
                                if ($substr_count > 1) {
                                    $value = preg_replace("/\s+/", " ", $value);
                                }
                                return explode(" ", trim($value));
                            }
                        }
                    }, $arrAllDataSplit);
                    $endProcessSplit = array_values(array_filter($processSplit));
                    //if symbol matched and data have
                    if (count($endProcessSplit) > 0) {
//                                print_r($endProcessSplit);
                        $spreadsheet2->createSheet();
                        $j = 0;
                        for ($i = 0; $i < count($endProcessSplit); $i++) {
                            $j++;
                            $spreadsheet2->setActiveSheetIndex(0)->setCellValue("A" . $j, trim($endProcessSplit[$i][0]));
                            $spreadsheet2->setActiveSheetIndex(1)->setCellValue("A" . $j, trim($endProcessSplit[$i][1]));
                        }
                        $writer = IOFactory::createWriter($spreadsheet2, "Xlsx");
                        $writer->save("xlsx/split.xlsx");
                    }
                    //if symbol did not match and data nill
                    else {
                        echo strtoupper($arrUserCol[0]) . " column have not that symbol" . $GLOBALS["splitSymbol"] . "symbolSplit";
                    }
                }
                else {//empty column
                    $array_unique = array_unique($filter->dataCol);
                    $array_reduce = array_reduce($array_unique, function($v1, $v2) {
                        return $v1 . "-" . $v2;
                    });
                    echo "column " . strtoupper($_POST["splitFirstCol"]) . " no data,only " . ltrim($array_reduce, "-") . " column have data!splitCol";
                }
            }
            //start add plan
            if ($splitAdd === "add") {
                $firstCol = $filter->arrColRowAdd["firstCol"];
                $secondCol = $_POST["addSecondCol"];
                $thirdCol = $filter->arrColRowAdd["secondCol"];

                $array_unique = array_unique($filter->dataCol);
                $array_reduce = array_reduce($array_unique, function($v1, $v2) {
                    return $v1 . "-" . $v2;
                });

                if (count($firstCol) < 1) {
                    echo "column- " . strtoupper($_POST["addFirstCol"]) . " have no data,only " . ltrim($array_reduce, "-") . " data!addCol1";
                    return FALSE;
                }
                if (count($thirdCol) < 1) {
                    echo "column- " . strtoupper($_POST["addThirdCol"]) . " have no data,only " . ltrim($array_reduce, "-") . " data!addCol2";
                    return FALSE;
                }
                if (strlen($secondCol) > 0) {
                    if (strlen($secondCol) > 1 || preg_match("/\w/", $secondCol)) {
                        echo "symbol must 1 and no characters !addSymbol";
                        return FALSE;
                    }
                }
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
                $symbolValue = (strlen($secondCol) > 0) ? " " . $secondCol . " " : "  ";
                //store all data for add
                $mergeTwoCol = array();
                for ($k = 0; $k < $highestRow; $k++) {
                    $processRowValueFirst="";
                    $processRowValueSecond="";
                    //collect first column value
                    if (!empty($filter->arrColRowAdd["firstCol"][$k])) {
                        $processRowValueFirst = $spreadsheet->getActiveSheet()->getCell($filter->arrColRowAdd["firstCol"][$k])->getValue();
                    }
                    //collect second column value
                    if (!empty($filter->arrColRowAdd["secondCol"][$k])) {
                        $processRowValueSecond = $spreadsheet->getActiveSheet()->getCell($filter->arrColRowAdd["secondCol"][$k])->getValue();
                    }
                    array_push($mergeTwoCol, $processRowValueFirst . $symbolValue . $processRowValueSecond);
                }
                $y = 0;
                for ($x = 0; $x < count($mergeTwoCol); $x++) {
                    $y++;
                    //$spredsheet for read data, and $spreadsheet2 for create new sheet
                    $spreadsheet2->getActiveSheet()->setCellValue("A" . $y, $mergeTwoCol[$x]);
                }
                $writer = IOFactory::createWriter($spreadsheet2, "Xlsx");
                $writer->save("xlsx/add.xlsx");
            }
        }
        else {
            echo "eg: sorry someting went wrong !";
        }
    }
}