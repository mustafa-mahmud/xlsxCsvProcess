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
                <div class="col-sm-12">
                    <form class="form-horizontal">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-8 bg-primary myMax mt-5 p-3">
                                    <h1 class="text-center p-3 pb-4"><span style="border-bottom: 2px solid black;padding-bottom: 5px;">Process Xlsx/Csv</span></h1>
                                    <div class="form-group col-sm-12">
                                        <div class="row">
                                            <label for="file" class="col-sm-2 col-form-label">Input File</label>
                                            <div class="col-sm-6 input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="fileCk" id="fileCk" placeholder="choose file"/>
                                                    <label class="custom-file-label">choose file</label>
                                                </div>
                                            </div>
                                            <label class="col-sm-4 col-form-label"><span class="errFile">eg: only .xlsx or csv file</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="js/xlsxCsvProcess.js"></script>
    </body>
</html>