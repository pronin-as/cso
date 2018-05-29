function initOtdDict (){
    $('#addOtdLinkID').bind('click', function () {
        $.post("tools.php", {func: "otdCreate"}, editOtdDlgShow, "html");
    });
    otdDictTabRef();
}

function otdDictLoad() {
    $.post("tools.php", {func: "otdDictLoad"}, function (data){
        $("#mainContainerHolderID").html(data);
        otdDictTabRef();
    }, "html");
}

function otdDictTabRef() {
    $.post("tools.php", {func: "otdTabRef"}, function (data) {
        $("#otdTabHolderID").html(data);
        $(".otdEditClass").unbind('click');
        $(".otdEditClass").bind('click', otdEdit);
    }, "html");
}

function otdEdit(elem) {
    var elem = elem || event;
    var target = elem.target || elem.srcElement;
    $.post("tools.php", {func: "editOtdDialog", otdToEditID: target.name.replace('editOtdName', '')}, editOtdDlgShow, "html");
}

function editOtdDlgShow(data){
    $("#dlgId").html(data);
    $("#deleteOtdDlgSaveButtonID").unbind("click");
    $("#deleteOtdDlgSaveButtonID").bind("click", function () {
        alert("Удаляем");
        $.post("tools.php", {func: "deleteOtd", otdID: $("#tmpOtdID").val()}, function (data) {
            alert(data);
            otdDictTabRef();
        }, "html");
        $("#dlgId").html("");
        $("#dlgId").css("display","none");
    });
    $("#editOtdDlgCloseButtonID").unbind("click");
    $("#editOtdDlgCloseButtonID").bind("click", function () {
        $("#dlgId").html("");
        $("#dlgId").css("display","none");
    });
    $("#editOtdDlgSaveButtonID").unbind("click");
    $("#editOtdDlgSaveButtonID").bind("click", function () {
        if($("#operType").val() == "newOtd"){
        $.post("tools.php", {func: "newOtdSave", otdName: $("#otdNameDlgID").val(), otdNo: $("#otdNumDlgID").val()}, function (data) {
                        if(data == "ok"){
                            alert("Сохранено успешно.");
                            otdDictTabRef();
                            $("#dlgId").html("");
                            $("#dlgId").css("display","none");
                            
                       } else {
                           alert("Сохранить неудалось." + data);
                       }
                    }, "html");
    };

           
        if($("#operType").val() == "editOtd"){
            alert("editOtd");           
            $.post("tools.php", {func: "editOtdSave", otdName: $("#otdNameDlgID").val(), otdNo: $("#otdNumDlgID").val(), otdID: $("#tmpOtdID").val()}, function (data) {
                if(data == "ok"){
                    alert("Сохранено успешно.");
                    otdDictTabRef();
                    $("#dlgId").html("");
                    $("#dlgId").css("display","none");
                    
               } else {
                   alert("Сохранить неудалось." + data);
               }
            }, "html");

        };
    });
    
    $("#dlgId").css("display","block");
}