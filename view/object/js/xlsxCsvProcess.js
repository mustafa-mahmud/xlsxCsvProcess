(function ($) {
    $(function () {
        $("select[name='plan']").on("change", function () {
            let selecVal = $(this).val();
            if (selecVal === "split") {
                $(".errProcess").fadeOut();
                $(".add").fadeOut();
                $(".split").fadeIn();
            } else if (selecVal === "add") {
                $(".errProcess").fadeOut();
                $(".split").fadeOut();
                $(".add").fadeIn();
            } else {
                $(".split").fadeOut();
                $(".add").fadeOut();
            }
        });
        $(".save").on("click", function (event) {
            event.preventDefault();
            let fileName = document.querySelector("#fileCk");
            if (fileName.files.length < 1) {//file is not choosen
                $(".errFile").text("eg: please choose .xlsx type file").css({"color": "red"});
            } else {//file choosen
                let fileNameProcess = fileName.files[0]["name"].slice(-4);
                if (fileNameProcess.toLowerCase() !== "xlsx") {//wrong file choosen
                    $(".errFile").text("eg: please choose .xlsx type file").css({"color": "red"});
                } else {//if .xlsx file is choosen
                    $(".errFile").text("eg: only .xlsx file allowed").css({"color": "black"});
                    var splitVisible = $(".split:visible");//if visible then length 1 or length 0
                    var addVisible = $(".add:visible");//if visible then length 1 or length 0
                    if (splitVisible.length > 0) {// .split visible
                        $(".errSelect").text("eg: select must any one plan").css({"color": "black"});
                        var splitFirstCol = $("#splitFirstCol").val();
                        if (splitFirstCol.length > 0) {
                            $(".errSplitCol").text("eg: one column name where | ").css({"color": "black"});
                            let patt = /^[a-zA-Z]{1,3}$/;
                            if (patt.test(splitFirstCol)) {// column is true a-zA-Z
                                allData();
                            } else {
                                $(".errSplitCol").text("eg: this is not column").css({"color": "red"});
                            }
                        } else {
                            $(".errSplitCol").text("eg: please any Column A-Z").css({"color": "red"});
                        }
                    } else if (addVisible.length > 0) {// .add visible
                        $(".errSelect").text("eg: select must any one plan").css({"color": "black"});
                        var addFirstCol = $("#addFirstCol").val();
                        var addThirdCol = $("#addThirdCol").val();
                        let patt = /^[a-zA-Z]{1,3}$/;
                        if (addFirstCol.length > 0 && addThirdCol.length > 0) {
                            $(".errAddCol").text("eg: one column name where | ").css({"color": "black"});
                            if (patt.test(addFirstCol) && patt.test(addThirdCol) && (addFirstCol != addThirdCol)) {
                                allData();
                            } else {
                                $(".errAddCol").text("eg: only column & not equil").css({"color": "red"});
                            }
                        } else {
                            $(".errAddCol").text("eg: please any Column A-Z").css({"color": "red"});
                        }
                    } else {
                        $(".errSelect").text("eg: please select any one plan").css({"color": "red"});
                    }
                }
            }
        });
        //ajax function......
        function allData() {
            var fromId = document.querySelector("#xlsxProcess");
            var formData = new FormData(fromId);
            $.ajax({
                type: "POST",
                url: "object.php",
                cache: false,
                async: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    $("input button").on("click", function (event) {
                        event.preventDefault();
                    });
                    $(".waiting").addClass("fas fa-spinner fa-pulse");
                    $(".save").addClass("cursorPrevent");
                },
                success: function (data) {
                    $(".waiting").removeClass("fas fa-spinner fa-pulse");
                    $(".save").removeClass("cursorPrevent");
                    let patt = /eg: sorry someting went wrong !/;
                    if (patt.test(data)) {
                        $(".errProcess").text(data).css({"color": "red"});
                        return false;
                    } else if (data.match(/split/g) !== null) {
                        $(".errSplitCol").text(data).css({"color": "red"});
                        return false;
                    } else if (data.includes("symbolSplit")) {
                        //replace 'symbolSplit' string and return less string
                        $(".errSplitCol").text(data.replace("symbolSplit","")).css({"color":"red"});
                        return false;
                    } else {
                        //success
                        $(".errProcess").fadeOut();
                        $(".errSplitCol").text("eg: one column name ").css({"color":"black"});
                        return true;
                    }
                    console.log(data);
                }
            }
            );
        }
    });
}(jQuery));


