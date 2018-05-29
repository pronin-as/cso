function initToolDict(){
    $('#addPositionLinkID').bind('click', function () {toolCreate();});
    ttRef();
}

        function toolEdit(elem) {
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            $.post("tools.php", {func: "editDialog", toolToEditID: target.name.replace('editName', '')}, editDlgShow, "html");
        }
        
        function toolToShow(elem) {
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            var uslID = $(target).parents('.toolSelectClass').attr('id');
            $.post("tools.php", {func: "toolShow", toolToShowID: uslID.replace('selectName','')}, toolShow, "html");
        }

        
        function editDlgShow(data){
            $("#dlgId").html(data);
            $("#deleteToolDlgSaveButtonID").unbind("click");
            $("#deleteToolDlgSaveButtonID").bind("click", function () {
                alert("Удаляем");
                $.post("tools.php", {func: "deleteTool", toolID: $("#tmptoolID").val()}, function (data) {
                    alert(data);
                    ttRef();
                }, "html");
                $("#dlgId").html("");
                $("#dlgId").css("display","none");
            });
            $("#editToolDlgCloseButtonID").unbind("click");
            $("#editToolDlgCloseButtonID").bind("click", function () {
                $("#dlgId").html("");
                $("#dlgId").css("display","none");
            });
            $("#editToolDlgSaveButtonID").unbind("click");
            $("#editToolDlgSaveButtonID").bind("click", function () {
                if($("#operType").val() == "newTool"){
                    
                var $input = $("#fileToLoadID");
                var fd = new FormData;

                fd.append('fileToLoadID', $input.prop('files')[0]);
                fd.append('func','createNewTool');
                fd.append('instrName', $("#instrNameDlgID").val());
                fd.append('instrRemark', $("#instrRemarkDlgID").val());

                $.ajax({
                        url: 'tools.php',
                        data: fd,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {
                                if(data == "ok"){
                                    alert("Сохранено успешно.");
                                    ttRef();
                                    $("#dlgId").html("");
                                    $("#dlgId").css("display","none");
                                    
                               } else {
                                   alert("Сохранить неудалось." + data);
                               }
                            }
                        });

                   }
                if($("#operType").val() == "editTool"){
                    alert("editTool");
                    var $input = $("#fileToLoadID");
                    var fd = new FormData;

                    fd.append('fileToLoadID', $input.prop('files')[0]);
                    fd.append('func','editTool');
                    fd.append('instrName', $("#instrNameDlgID").val());
                    fd.append('instrRemark', $("#instrRemarkDlgID").val());
                    fd.append('toolID', $("#tmptoolID").val());

                    $.ajax({
                            url: 'tools.php',
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function (data) {
                                    if(data == "ok"){
                                        alert("Сохранено успешно.");
                                        ttRef();
                                        $("#dlgId").html("");
                                        $("#dlgId").css("display","none");

                                   } else {
                                       alert("Сохранить неудалось." + data);
                                   }
                                }
                            });                   
                   }
            });
            
            
            $("#dlgId").css("display","block");
        }
        
        function toolShow(data){
            $('#toolImgHolderID').html(data);
        }
        
        function ttRef() {
            $.post("tools.php", {func: "toolsTabRead"}, function (data) {               
                    $("#ttrID").html(data);
                    $('.toolEditClass').unbind('click');
                    $('.toolEditClass').bind('click', toolEdit);
                    $('.toolSelectClass').unbind('click');
                    $('.toolSelectClass').bind('click', toolToShow);
                }, "html");

        }

        function toolCreate(){
            $.post("tools.php", {func: "toolCreate"}, editDlgShow, "html");
        }