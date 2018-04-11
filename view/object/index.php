<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta http-equiv="Cache-Control" content="no-cache"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!--[if lte IE 9]>
        <link href='/PATH/TO/FOLDER/css/animations-ie-fix.css' rel='stylesheet'>
        <![endif]-->
        <title>Xlsx Csv Process</title>
        <!-----CSS------>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/practise.css" />
        <link rel="stylesheet" href="web-fonts-with-css/css/fontawesome-all.min.css" />
        <!-----JS------>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form id="xlsxProcess" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-8 bg-primary myMax mt-5 p-3">
                                    <h1 class="text-center p-3 pb-4"><span style="border-bottom: 2px solid black;padding-bottom: 5px;">Process Xlsx</span></h1>
                                    <div class="form-group col-lg-12">
                                        <div class="row">
                                            <label for="file" class="col-lg-2 col-form-label">Upload File</label>
                                            <div class="col-lg-6 input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="fileCk" id="fileCk" placeholder="choose file"/>
                                                    <label class="custom-file-label">choose file</label>
                                                </div>
                                            </div>
                                            <label class="col-lg-4 col-form-label">
                                                <span class="errFile">eg: only .xlsx file allowed</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <div class="row">
                                            <label for="choose" class="col-lg-2 col-form-label">Select Plan</label>
                                            <div class="col-lg-6">
                                                <select name="plan" class="form-control">
                                                    <option value="null" selected="selected">select bellow</option>
                                                    <option value="split">split</option>
                                                    <option value="add">add</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-4 col-form-label">eg: select must any one</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 split">
                                        <div class="row">
                                            <label for="split" class="col-lg-2 col-form-label">Split</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="splitFirstCol" name="splitFirstCol" placeholder="A/B/D" />
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control" id="splitSecondCol" name="splitSecondCol" placeholder="space" />
                                            </div>
                                            <label class="col-lg-4 col-form-label">
                                                <span class="errSplitCol">eg: one column name where | </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 add">
                                        <div class="row">
                                            <label for="column" class="col-lg-2 col-form-label">Add</label>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control" id="addFirstCol" name="addFirstCol" placeholder="A/B/D" />
                                            </div>
                                            <div class="col-lg-2 text-center">
                                                <input type="text" class="form-control" id="addSecondCol" name="addSecondCol" placeholder="space">
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control" id="addThirdCol" name="addThirdCol" placeholder="A/B/D" />
                                            </div>
                                            <label class="col-lg-4 col-form-label">
                                                <span class="errAddCol">eg: one column name with | </span>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="errProcess text-center col-lg-10 mb-3">Sorry something wrong, check your data format</p>
                                    <h1 class="text-center col-lg-10">
                                        <button class="pl-5 pr-5 btn btn-dark btn-md save">Save</button>
                                        <button class="pl-5 pr-5 btn btn-danger btn-md download">Download</button>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--<p id="demo"></p>-->
            </div>
        </div>

        <script src="js/xlsxCsvProcess.js"></script>
    </body>
</html>
