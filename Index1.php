<!DOCTYPE html>
<html lang="ru">
<html>
    <head>
        <?php include "config.php";?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script src=<?=$sitePath?>"/Scripts/jquery-1.7.1.min.js"></script>
        <script src=<?=$sitePath?>"/tools.js"></script>
        <script src=<?=$sitePath?>"/otdDict.js"></script>
        <link href=<?=$sitePath?>"/css/site.css" rel="stylesheet" />
    </head>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#otdButtonID').bind('click', function () {otdDict();});
            $('#naborButtonID').bind('click', function () {naborMgr();});
            $('#toolsButtonID').bind('click', function () {toolDict();});
            ttRef();
        });
        
        function otdDict(){
            $.post("tools.php", {func: "otdDictLoad"}, function (data){
                $("#mainContainerHolderID").html(data);
                initOtdDict();
            }, "html");
        }
        
        function naborMgr(){
            $.post("tools.php", {func: "naborEditor"}, function (data) {
                $("#mainContainerHolderID").html(data);
                nabEditorInit();
                nabOtdRefresh();
            }, "html");
        }
        
        function toolDict(){
            $.post("tools.php", {func: "toolDict"}, function (data) {
                $("#mainContainerHolderID").html(data);
                initToolDict();
            }, "html");
        }
    </script>

    <body class="page">

        <header class="header">
            <div class="header__logo"><img src="css/img/logo.png"></div>
            <h1 class="header__title">Централизованное стерилизационное отделение</h1>
            <nav class="header__menu">
                <ul class="menu">
                    <li><a class="menu__item" href="#" id="otdButtonID">Отделения</a></li>
                    <li><a class="menu__item" href="#" id="naborButtonID">Наборы</a></li>
                    <li><a class="menu__item" href="#" id="toolsButtonID">Номенклатура</a></li>
                </ul>
            </nav>

        </header>

        <main id="mainContainerHolderID"></main>

    </body>
</html>