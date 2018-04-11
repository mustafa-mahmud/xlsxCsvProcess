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
            var splitVisible = $(".split:visible");//if visible then length 1 or length 0
            var addVisible = $(".add:visible");//if visible then length 1 or length 0
            if (splitVisible.length > 0) {// .split visible
                $(".errProcess").fadeOut();
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
                $(".errProcess").fadeOut();
                var addFirstCol = $("#addFirstCol").val();
                var addThirdCol = $("#addThirdCol").val();
                let patt = /^[a-zA-Z]{1,3}$/;
                if(addFirstCol.length>0 && addThirdCol.length>0){
                     $(".errAddCol").text("eg: one column name where | ").css({"color": "black"});
                     if(patt.test(addFirstCol) && patt.test(addThirdCol) && (addFirstCol!=addThirdCol)){
                         allData();
                     }
                     else{
                         $(".errAddCol").text("eg: only column & not equil").css({"color": "red"});
                     }
                }
                else{
                    $(".errAddCol").text("eg: please any Column A-Z").css({"color": "red"});
                }
            } else {
                $(".errProcess").fadeIn().text("Please select any one plan").css({"color": "red"});
            }
        });
        //ajax function......
        function allData(){
            var fromId=document.querySelector("#xlsxProcess");
            var formData=new FormData(fromId);
            $.ajax({
                type:"POST",
                url:"object.php",
                cache: false,
                async: false,
                contentType: false,
                processData: false,
                data:formData,
                beforeSend:function(){},
                success:function(data){
                    let patt=/eg: please choose .xlsx file/;
                    let patt2=/(column no data\(split\))$/;
                    if(patt.test(data)){
                        console.log("A");
                        $(".errFile").text(data).css({"color":"red"});
                        return false;
                    }
                    else if(patt2.test(data)){
                        console.log("B");
                        $(".errSplitCol").text(data).css({"color":"red"});
                        return false;
                    }
                    else{
                        //success
                        console.log("C");
                        $(".errSplitCol").text("eg: one column name where | ").css({"color":"black"});
                        $(".errFile").text("eg: only .xlsx file allowed").css({"color":"black"});
                        return true;
                    }
                    console.log(data);
                }
            });
        }
    });
}(jQuery));


