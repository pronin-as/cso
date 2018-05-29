<script>
    function nabEditorInit(){
        ToolsRefresh();
        
        $("#delFromNabToolID").unbind('click');
        $("#delFromNabToolID").bind('click', function (){
            var tt = $(".selectedRowL");
            var arr = [];
            tt.each(function (i, elem){
                var dd = $(this).attr('id');
                console.log(dd);
                arr[i] = dd.replace('selectNameNab','');
             });
            console.log(arr);
            $.post("tools.php", {func: "delToolsFromNab", 'toolsToDel[]': arr, nabID: $("#neNabSelectorID").val()}, function (data){ 
            alert(data); 
            toolsToNabRef();
            ToolsRefresh();
            }, "html")

        });
        
        $("#addToNabButtonID").unbind('click');
        $("#addToNabButtonID").bind('click', function (){
            var tt = $(".selectedRowR");
            var arr = [];
            tt.each(function (i, elem){
                var dd = $(this).attr('id');
                console.log(dd);
                arr[i] = dd.replace('selectName','');
             });
            console.log(arr);
            $.post("tools.php", {func: "addToolsToNab", 'toolsToAdd[]': arr, nabID: $("#neNabSelectorID").val()}, function (data){ 
                alert(data); 
                toolsToNabRef();
                ToolsRefresh();
                }, "html")
            
        });
        
        $("#addNabButtonID").bind('click', function () {
            $.post("tools.php", {func: "neNewNabDlg", otdID: $("#neOtdSelectorID").val()}, function (data){
                $("#dlgId").html(data);
                
                $("#editNabDlgCloseButtonID").unbind('click');
                $("#editNabDlgCloseButtonID").bind('click', function () {
                    $("#dlgId").html("");
                    $("#dlgId").css("display", "none");
                });
               
                $("#editNabDlgSaveButtonID").unbind('click');
                $("#editNabDlgSaveButtonID").bind('click', function (){
                    
                    if($("#operType").val() == "newNab"){
                    
                var $input = $("#fileNabToLoadID");
                var fd = new FormData;

                fd.append('fileToLoadID', $input.prop('files')[0]);
                fd.append('func','neSaveNewNab');
                fd.append('otdID', $("#neOtdSelectorID").val());
                fd.append('nabName', $("#nabDlgID").val());

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
                if($("#operType").val() == "editNab"){
                    alert("editTool");
                    var $input = $("#fileToLoadID");
                    var fd = new FormData;

                fd.append('fileToLoadID', $input.prop('files')[0]);
                fd.append('func','neEditNab');
                fd.append('otdID', $("#neOtdSelectorID").val());
                fd.append('nabName', $("#nabDlgID").val());

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
                    
                    nabOtdRefresh;
            });
            
            
            $("#dlgId").css("display","block");
                    
                    
                }, "html");
                
                $("#dlgId").css("display", "block");
            });
    }
    
    function nabToolRefresh(){
        $.post("tools.php", {func: "nabToolRefresh"}, function (data){
            
        }, "html");
    }
    
/********** Список номенклатуры инструментов для страницы наборов **********/
     function ToolsRefresh(){  
        $.post("tools.php", {func: "neToolsRefresh"}, function (data){
            $("#toolsSelectorID").html(data);
            $(".neNabSelectClassR").unbind('click');
            $(".neNabSelectClassR").bind('click', nabRightClickS);
            $(".selectedRowR").unbind('click');
            $(".selectedRowR").bind('click', nabRightClickD);
            $(".imgIconClass").unbind('click');
            $(".imgIconClass").bind('click', toolIconShow);

        }, "html");
    }
    
    function toolIconShow(elem){
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            var uslID = $(target).attr('src');
            console.log(uslID);
            var ht = '<div><img src="' + uslID + '" /></div>';
            $("#dlgId").html(ht);
            $("#dlgId").css("display", "block");
            $("#dlgId").unbind('click');
            $("#dlgId").bind('click', function () {
                $("#dlgId").html("");
                $("#dlgId").css("display", "none");
                $("#dlgId").unbind('click');
            });
        
    }
    
     function nabRightClickS(elem) {
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            var uslID = $(target).parents('.neNabSelectClassR').attr('id');
            //var dd = uslID.replace('selectName','');
            $(target).parents('.neNabSelectClassR').removeClass( "neNabSelectClassR" ).addClass( "selectedRowR" );
            initRTab();
/*            $.post("tools.php", {func: "toolShow", toolToShowID: uslID.replace('selectName','')}, function (data){
                $("#toolImgHolderID").html(data);
            });             */
     }

     function nabRightClickD(elem) {
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            var uslID = $(target).parents('.selectedRowR').attr('id');
            //var dd = uslID.replace('selectName','');
            $(target).parents('.selectedRowR').removeClass( "selectedRowR" ).addClass( "neNabSelectClassR" );
            initRTab();
/*            $.post("tools.php", {func: "toolShow", toolToShowID: uslID.replace('selectName','')}, function (data){
                $("#toolImgHolderID").html(data);
            });             */
     }
    
    function initRTab(){
            $(".neNabSelectClassR").unbind('click');
            $(".neNabSelectClassR").bind('click', nabRightClickS);
            $(".selectedRowR").unbind('click');
            $(".selectedRowR").bind('click', nabRightClickD);
    }

    
/********** Обновить состав набора выбранный в селекте левая таблица **********/
    function toolsToNabRef(){
        //alert("toolsToNabRef");
        $.post("tools.php", {func: "neToolsToNabRef", nabID: $("#neNabSelectorID").val()}, function (data){
            $("#toolInNaborHolderID").html(data);
            $(".neToolInNabSelectClassL").unbind('click');
            $(".neToolInNabSelectClassL").bind('click', nabLeftClickS);
            $(".selectedRowL").unbind('click');
            $(".selectedRowL").bind('click', nabLeftClickD);
        }, "html");
    }
    
         function nabLeftClickS(elem) {
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            var uslID = $(target).parents('.neToolInNabSelectClassL').attr('id');
            //var dd = uslID.replace('selectName','');
            $(target).parents('.neToolInNabSelectClassL').removeClass( "neToolInNabSelectClassL" ).addClass( "selectedRowL" );
            initLTab();
     }

     function nabLeftClickD(elem) {
            var elem = elem || event;
            var target = elem.target || elem.srcElement;
            var uslID = $(target).parents('.selectedRowL').attr('id');
            //var dd = uslID.replace('selectNameNab','');
            $(target).parents('.selectedRowL').removeClass( "selectedRowL" ).addClass( "neToolInNabSelectClassL" );
            initLTab();
     }
    
    function initLTab(){
            $(".neToolInNabSelectClassL").unbind('click');
            $(".neToolInNabSelectClassL").bind('click', nabLeftClickS);
            $(".selectedRowL").unbind('click');
            $(".selectedRowL").bind('click', nabLeftClickD);
    }
/********************************************************************************/    
    
    function nabOtdRefresh(){
        $.post("tools.php", {func: "otdSelectorRef"}, function (data){
            $("#otdSelectorHolderID").html(data);
            $("#neOtdSelectorID").bind('change', nabToOtdRefresh );   
                nabToOtdRefresh();
        }, "html");

    }
    
    function nabToOtdRefresh(){
                $.post("tools.php", {func: "nabToOtdChange", otdID: $("#neOtdSelectorID").val()}, function(data){
                    $("#nabToOtdSelectorHolderID").html(data);
                    $("#neNabSelectorID").bind('change');
                    $("#neNabSelectorID").bind('change', function (){
                        nabImgShow();
                        toolsToNabRef();
                    });
                nabImgShow();
                toolsToNabRef();
                }, "html");
    }
    
    
    
    function nabImgShow(){
        $.post("tools.php", {func: "naborImgLoad", nabToShowID: $("#neNabSelectorID").val()}, function (data){
            $("#naborImgHolderID").html(data);
        }, "html");
    }
    
</script>

        <h1 class="page__title">Создание набора</h1>

        <section class="page__content content" id="mainContainerID">

            <form class="content__item form form_big" id="topContainerID">
                <div class="form__item">
                    <label>Отделение</label>
                    <div class="form_big__wrapper" id="otdSelectorHolderID"></div>
                </div>

                <div class="form__item">
                    <label>Набор</label>
                    <div class="form_big__wrapper" id="nabToOtdSelectorHolderID"></div>

                    <button class="btn">Редактировать</button>
                    <button class="btn" id="addNabButtonID">Создать набор</button>
                </div>

            </form>

            <div class="content__item row" id="bottomContainerID">

                <div class="list__chosen" id="toolInNaborHolderID">
                    <!--
                    <h2>Состав набора</h2>
                    <table>
                        <tr><td>Ножницы</td><td><img src="img/detail.png"></td></tr>
                        <tr><td>Долото</td><td><img src="img/detail.png"></td></tr>
                    </table>
                    -->
                </div>

                <div class="list__button" id="buttonHolderID">
                    <button class="arrow arrow_left v_free_space" id="addToNabButtonID">Добавить</button><br>
                    <button class="arrow arrow_right" id="delFromNabToolID">Удалить</button>
                </div>

                <div class="list__all" id="toolsSelectorID">
                    <h2>Общий список инструментов</h2>
                </div>

                <div class="list__img-nabor photo" id="imagesContainerHolderID">
                    <div class="photo__all" id="naborImgHolderID"></div>
                    <div class="photo__item" id="toolImgHolderID"></div>
                </div>
            </div>
        </section>
    <div id="dlgId" class="popup"></div>