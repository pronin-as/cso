<?php
include "config.php";
include "db.php";

if(isset($_POST['func']) ) {
    switch ($_POST['func']) {
        case 'toolsTabRead':
            toolsTabRead();
        break;
        case 'editDialog':
            toolsEditDialog();
        break;
        case 'toolShow':
            toolsImgLoad();
        break;
        case 'toolCreate':
            toolCreateDlg();
        break;
        case 'createNewTool':
            toolCreate();
        break;
        case 'editTool':
            editTool();
        break;
        case 'toolDict':
            toolDict();
        break;
        case 'otdDictLoad':
            otdDictLoad();
        break;
        case 'otdTabRef':
            otdTabRef();
        break;
        case 'deleteTool':
            deleteDict();
        break;
        case 'editOtdDialog':
            editOtdDialog();
        break;
        case 'newOtdSave':
            newOtdSave();
        break;
        case 'editOtdSave':
            editOtdSave();
        break;
        case 'otdCreate':
            otdCreateDlg();
        break;
        case 'deleteOtd':
            deleteOtd();
        break;
        case 'naborEditor':
            naborEditor();
        break;
        case 'otdSelectorRef':
            otdSelectorRef();
        break;
        case 'nabToOtdChange':
            nabToOtdChange();
        break;
        case 'neNewNabDlg':
            neNewNabDlg();
        break;
        case 'neSaveNewNab':
            neSaveNewNab();
        break;
        case 'naborImgLoad':
            naborImgLoad();
        break;
        case 'neToolsRefresh':
            neToolsRefresh();
        break;
        case 'neToolsToNabRef':
            neToolsToNabRef();
        break;
        case 'addToolsToNab':
        addToolsToNab();
        break;
        case 'delToolsFromNab':
            delToolsFromNab();
        break;
        case 'editToolCopy':
            editToolCopy();
        break;
        case 'editNab':
            editNab();
        break;
        case 'neEditNab':
            neEditNab();
        break;
        case 'loadImgNabToStage':
            loadImgNabToStage();
        break;
        case 'smallImgView':
            smallImgView();
        break;
        
        
    }
}

function toolsTabRead (){
    include "config.php";
    $db = dbConnect();
    $toolsList = $db->query("SELECT * FROM instrum WHERE isDeleted = 0 ORDER BY instrName");
    include $viewFolder . "toolsTabReadView.php";
    $toolsList->free();
    $db->close();
}

function toolsEditDialog() {
    include "config.php";
    $dlgCaption = "Редактирование позиции";
    $toolIDtmp = $_POST['toolToEditID'];
    $db = dbConnect();
    $tools = $db->query("SELECT * FROM instrum WHERE instrID = " . $toolIDtmp);
    $tool = mysqli_fetch_assoc($tools);
    $operType = "editTool";
    $delButton = 1;
    include $viewFolder . "editToolDlgView.php";
    $tools->free();
    $db->close();
}

function toolsImgLoad() {
    include "config.php";
    $toolIDtmp = $_POST['toolToShowID'];
    $db = dbConnect();
    $tools = $db->query("SELECT * FROM instrum WHERE instrID = " . $toolIDtmp);
    $tool = mysqli_fetch_assoc($tools);
    include $viewFolder . "toolImgShowView.php";
    $tools->free();
    $db->close();
}

function toolCreateDlg(){
    include "config.php";
    $dlgCaption = "Создание";
    $tool = [
            "instrName" => "",
            "intrRemar" => ""
            ];
    $toolIDtmp = "";
    $operType = "newTool";
    $delButton = 0;
    include $viewFolder . "editToolDlgView.php";
}

function toolCreate(){
    /********************************* GD *********************************/
    include "img.php";
    include "config.php";

    $isError = FALSE;
    $sStatus = "";
    $db = dbConnect();
    $toolNameTmp = $_POST['instrName'];
    $toolRemarkTmp = $_POST['instrRemark'];
    if(empty($_FILES['fileToLoadID']['name'])){
        $timeStamp = new dateTime();
        $timeStampformated =  $timeStamp->format('d-m-Y');        
        $uploadfile = getcwd() . $imgDefault;
    
        $queryTmp = "INSERT INTO instrum (`instrName`, `intrRemar`, `picPath`, `eventDate`) VALUES ('" . $toolNameTmp . "', '" . $toolRemarkTmp . "' , '" . $imgDefault . "' , STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") )";

        if($db->query($queryTmp) === FALSE) {
            $isError = TRUE;
            $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
        } else {
            $sStatus = $sStatus . "Запись в БД: успешно. \n";
        }

    } else {
        $fileInfo = new SplFileInfo($_FILES['fileToLoadID']['name']);
        $fileExt = $fileInfo->getExtension();
        $timeStamp = new dateTime();
        $timeStampformated =  $timeStamp->format('d-m-Y');
        $newFileName = $timeStamp->format('Ymd_Hisv') . "." . $fileExt;
        $newTmpFileName = $timeStamp->format('Ymd_Hisv') . "_tmp." . $fileExt;
        $uploadfile = getcwd() . $uploaddir . $newFileName;
        $uploadtmpfile = getcwd() . $uploadtmpdir . $newTmpFileName;
    
        $queryTmp = "INSERT INTO instrum (`instrName`, `intrRemar`, `picPath`, `eventDate`) VALUES ('" . $toolNameTmp . "', '" . $toolRemarkTmp . "' , '" . $uploaddir . $newFileName . "' , STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") )";

        if($db->query($queryTmp) === FALSE) {
            $isError = TRUE;
            $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
        } else {
            $sStatus = $sStatus . "Запись в БД: успешно. \n";
        }
        if (move_uploaded_file($_FILES['fileToLoadID']['tmp_name'], $uploadtmpfile)) {
            $sStatus = $sStatus . "Загрузка файла: успешно. \n";
            $tmpImg = getcwd() . $uploaddir . "tmp1.jpg";
            resizeToMaxView($uploadtmpfile, $uploadfile, $imgWtools);
        } else {
            $sStatus = $sStatus . "Загрузка файла: Ошибка. \n";
            $isError = TRUE;
        }
    }

    $db->close();
    if($isError){
        echo($sStatus);
    } else {
        echo("ok");
    }
}

function editTool(){
    include "config.php";
    include "img.php";
    $isError = FALSE;
    $sStatus = "";
    $db = dbConnect();
    $toolNameTmp = $_POST['instrName'];
    $toolRemarkTmp = $_POST['instrRemark'];
    $toolIDtmp = $_POST['toolID'];
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');


    if(!empty($_FILES['fileToLoadID']['name'])){
                $fileInfo = new SplFileInfo($_FILES['fileToLoadID']['name']);
                $fileExt = $fileInfo->getExtension();
                $newTmpFileName = $timeStamp->format('Ymd_Hisv') . "_tmp." . $fileExt;
                $newFileName = $timeStamp->format('Ymd_Hisv') . "." . $fileExt;
                $uploadfile = getcwd() . $uploaddir . $newFileName;
                $uploadtmpfile = getcwd() . $uploadtmpdir . $newTmpFileName;
            
                $queryTmp = "UPDATE instrum SET instrName = '" . $toolNameTmp . "', intrRemar = '" . $toolRemarkTmp . "', picPath = '" . $uploaddir . $newFileName . "' , eventDate = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE instrID = ". $toolIDtmp;

            if($db->query($queryTmp) === FALSE) {
                $isError = TRUE;
                $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
            } else {
                $sStatus = $sStatus . "Запись в БД: успешно. \n";
            }
            if (move_uploaded_file($_FILES['fileToLoadID']['tmp_name'], $uploadtmpfile)) {
                $sStatus = $sStatus . "Загрузка файла: успешно. \n";
                $tmpImg = getcwd() . $uploaddir . "tmp1.jpg";
                resizeToMaxView($uploadtmpfile, $uploadfile, $imgWtools);
            } else {
                $sStatus = $sStatus . "Загрузка файла: Ошибка. \n";
                $isError = TRUE;
            }
            $db->close();
            if($isError){
                echo($sStatus);
            } else {
                echo("ok");
            }
    } else {
            $queryTmp = "UPDATE instrum SET instrName = '" . $toolNameTmp . "', intrRemar = '" . $toolRemarkTmp . "', eventDate = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE instrID = ". $toolIDtmp;

            if($db->query($queryTmp) === FALSE) {
                $isError = TRUE;
                $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
            } else {
                $sStatus = $sStatus . "Запись в БД: успешно. \n";
            }
            $db->close();
            if($isError){
                echo($sStatus);
            } else {
                echo("ok");
            }
    }

}

function deleteDict(){
    $toolToDelID = $_POST['toolID'];
    $db = dbConnect();
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');
    $queryTmp = "UPDATE instrum SET isDeleted = 1, eventDate = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE instrID = " . $toolToDelID; 
    if($db->query($queryTmp) === FALSE){
        echo "Удалить не удалось: " . $db->error;
    } else {
        echo "Успешно удалено";
    }
    $db->close();
}

function toolDict() {
    include "config.php";
    include $viewFolder . "toolsDictView.php";
}

function otdTabRef() {
    include "config.php";
/*
    $db = dbConnect();
    $sOtdTmp = $db->query("SELECT * FROM sOtd WHERE isDeleted = 0 ");
    include("otdRefView.php");
    $sOtdTmp->free();
    $db->close();
*/
    $db = new dbContext();
    $sOtdTmp = $db->query("SELECT * FROM sOtd WHERE isDeleted = 0 ");

    include $viewFolder . "otdRefView.php";
}

function otdDictLoad(){
    include "config.php";
    include $viewFolder . "otdDictView.php";
}

function editOtdDialog(){
    include "config.php";
    $db = dbConnect();
    $dlgOtdCaption = "Редактирование отделения";
    $otdIDtmp = $_POST['otdToEditID'];
    $delButton = 1;
    $operType = "editOtd";
    $otdTmp = $db->query("SELECT * FROM sOtd WHERE idOtd = " . $otdIDtmp);
    $otd = mysqli_fetch_assoc($otdTmp);
    include $viewFolder . "otdEditDlgView.php";
    $otdTmp->free();
    $db->close();
}

function newOtdSave(){
    $db = dbConnect();
    $isError = FALSE;
    $sStatus = "";
    $tmpOtdName = $_POST['otdName'];
    $tmpNoOtd = $_POST['otdNo'];
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');
    $queryTmp = "INSERT INTO `sOtd`(`nameOtd`, `noOtd`, `isDeleted`, `eventDate`) VALUES ('" . $tmpOtdName . "','" . $tmpNoOtd . "', 0 , STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\"))";
    if($db->query($queryTmp) === FALSE) {
        $isError = TRUE;
        $sStatus = "Сохранить не удалось:" . $db->error;
    } else {
        $sStatus = "Сохранено успешно:";
    }

    if($isError){
        echo($sStatus);
    } else {
        echo("ok");
    }
    $db->close();
}
function editOtdSave() {
    $db = dbConnect();
    $isError = FALSE;
    $sStatus = "";
    $tmpOtdName = $_POST['otdName'];
    $tmpNoOtd = $_POST['otdNo'];
    $otdID = $_POST['otdID'];
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');
    $queryTmp = "UPDATE sOtd SET nameOtd = '" . $tmpOtdName . "', noOtd = '" . $tmpNoOtd . "', eventDate = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE idOtd = " . $otdID;
    if($db->query($queryTmp) === FALSE) {
        $isError = TRUE;
        $sStatus = "Сохранить не удалось:" . $db->error;
    } else {
        $sStatus = "ok";
    }
    if($isError){
        echo($sStatus);
    } else {
        echo("ok");
    }
    $db->close();
}

function otdCreateDlg(){
    include "config.php";
    $dlgOtdCaption = "Создание";
    $otd = [
            "noOtd" => "",
            "nameOtd" => ""
            ];
    $otdIDtmp = "";
    $operType = "newOtd";
    $delButton = 0;
    include $viewFolder . "otdEditDlgView.php";
}
function deleteOtd(){
    $otdToDelID = $_POST['otdID'];
    $db = dbConnect();
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');
    $queryTmp = "UPDATE sOtd SET isDeleted = 1, eventDate = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE idOtd = " . $otdToDelID; 
    if($db->query($queryTmp) === FALSE){
        echo "Удалить не удалось: " . $db->error;
    } else {
        echo "Успешно удалено";
    }
    $db->close();
}

function naborEditor(){
    include "config.php";
    include $viewFolder . "naborEditorView.php";
}

function otdSelectorRef(){
    include "config.php";
    $db = new dbContext();
    $snOtdTmp = $db->query("SELECT * FROM sOtd WHERE isDeleted = 0 ");
    include $viewFolder . "neOtdView.php";
}

function nabToOtdChange(){
    include "config.php";
    $otdTmp = $_POST['otdID'];
    $db = new dbContext();
    $snNabTmp = $db->query("SELECT * FROM nabDict where nabOtd = ". $otdTmp);
    if(empty($snNabTmp)){
            $snNabTmp = "isEmpty";
    }
    include $viewFolder . "neNabView.php";
}

function neNewNabDlg(){
    include "config.php";
    $otdID = $_POST['otdID'];
    $db = new dbContext();
    $otdTmp = $db->query("SELECT * FROM sOtd WHERE idOtd = " . $otdID);
    $dlgNabCaption = "Создание";
    $nab = [
            "nabName" => ""
            ];
    $nabIDtmp = "";
    $otdName = $otdTmp[0]['nameOtd'];
    $operType = "newNab";
    $delButton = 0;
    include $viewFolder . "nabEditDlg.php";
}

function neSaveNewNab(){
    include "config.php";
    $isError = FALSE;
    $sStatus = "";
    $db = dbConnect();
    $otdID = $_POST['otdID'];
    $nabName = $_POST['nabName'];
    $fileInfo = new SplFileInfo($_FILES['fileToLoadID']['name']);
    $fileExt = $fileInfo->getExtension();
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');
    $newFileName = $timeStamp->format('Ymd_Hisv') . "." . $fileExt;
    $uploadfile = getcwd() . $uploaddir . $newFileName;
    

    $queryTmp = "INSERT INTO nabDict (`nabOtd`, `nabName`, `nabImg`, `eventDate`) VALUES (" . $otdID . ", '" . $nabName . "' , '" . $uploaddir . $newFileName . "' , STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") )";

    if($db->query($queryTmp) === FALSE) {
        $isError = TRUE;
        $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
    } else {
        $sStatus = $sStatus . "Запись в БД: успешно. \n";
    }
    if (move_uploaded_file($_FILES['fileToLoadID']['tmp_name'], $uploadfile)) {
        $sStatus = $sStatus . "Загрузка файла: успешно. \n";;
    } else {
        $sStatus = $sStatus . "Загрузка файла: Ошибка. \n";
        $isError = TRUE;
    }
    $db->close();
    if($isError){
        echo($sStatus);
    } else {
        echo("ok");
    }
}

function naborImgLoad() {
    include "config.php";
    $nabIDtmp = $_POST['nabToShowID'];
    $db = dbConnect();
    $nabs = $db->query("SELECT * FROM nabDict WHERE nabID = " . $nabIDtmp);
    $nabor = mysqli_fetch_assoc($nabs);
    include $viewFolder . "neNaborImgShowView.php";
    $nabs->free();
    $db->close();
}

function neToolsRefresh(){
    include "config.php";
    $db = dbConnect();
    if(empty($_POST['searchStr'])){
        $queryTmp = "SELECT * FROM (
            SELECT * FROM cso.instrum LEFT JOIN toolToNab ON instrum.instrID = toolToNab.instrumID
            UNION
            SELECT * FROM cso.instrum RIGHT JOIN toolToNab ON instrum.instrID = toolToNab.instrumID
                        ) as freeTools WHERE isDeleted = 0 and ttnID is NULL";
        $neToolsList = $db->query($queryTmp);
    } else {
        $searchStr = $_POST['searchStr'];
        $queryTmp = "SELECT * FROM (
            SELECT * FROM cso.instrum LEFT JOIN toolToNab ON instrum.instrID = toolToNab.instrumID
            UNION
            SELECT * FROM cso.instrum RIGHT JOIN toolToNab ON instrum.instrID = toolToNab.instrumID
                        ) as freeTools WHERE isDeleted = 0 and ttnID is NULL and instrName LIKE '%" . $searchStr . "%'";
        $neToolsList = $db->query($queryTmp);
    }
    //$neToolsList = $db->query("SELECT * FROM instrum WHERE isDeleted = 0");
    include $viewFolder . "neToolsSelectorView.php";
    $neToolsList->free();
    $db->close();
}

function neToolsToNabRef(){
    include "config.php";
    $nabID = $_POST['nabID'];
    $db = dbConnect();
    if(empty($_POST['searchStr'])){
        $neToolsToNabList = $db->query("SELECT * FROM instrToNabView WHERE nabID = ". $nabID . " and instrDeleted = 0");
    } else {
        $searchStr = $_POST['searchStr'];
        $tmpQuery = "SELECT * FROM instrToNabView WHERE nabID = ". $nabID . " and instrDeleted = 0 and instrName LIKE '%" . $searchStr . "%'";
        $neToolsToNabList = $db->query($tmpQuery);
    }
    include $viewFolder . "neToolsToNabView.php";
    $neToolsToNabList->free();
    $db->close();
}

function addToolsToNab(){
    include "config.php";
    $isError = FALSE;
    $nabID = $_POST['nabID'];
    if(!empty($_POST['toolsToAdd'])){
        $toolsArr = $_POST['toolsToAdd'];
        if($nabID == "9999999"){
            $message = "Необходимо выбрать набор!";
            $isError = TRUE;
        } else {
            $db = dbConnect();
            foreach($toolsArr as $val){            
                $tmpQuery = "INSERT INTO toolToNab (`instrumID`,`naborID`) VALUES (" . $val .", " . $nabID . ")";
                if($db->query($tmpQuery) === FALSE){
                    $isError = TRUE;
                    $message = "Запись в БД: ошибка. \n" . $db->error;
                }
            }

        }
    } else {
        $isError = TRUE;
        $message = "Необходимо выбрать инструменты!";
    }
    if($isError == TRUE){
        
    } else {
        $message = "Сохранено успешно!";
    }
    include $viewFolder . "neAddToolsToNabRez.php";
}

function delToolsFromNab(){
    include "config.php";
    $isError = FALSE;
    $nabID = $_POST['nabID'];
    if(!empty($_POST['toolsToDel'])){
        $toolsArr = $_POST['toolsToDel'];
        if($nabID == "9999999"){
            $message = "Необходимо выбрать набор!";
            $isError = TRUE;
        } else {
            $db = dbConnect();
            foreach($toolsArr as $val){            
                //$tmpQuery = "INSERT INTO toolToNab (`instrumID`,`naborID`) VALUES (" . $val .", " . $nabID . ")";
                $tmpQuery = "DELETE FROM toolToNab WHERE ttnID = " . $val;
                if($db->query($tmpQuery) === FALSE){
                    $isError = TRUE;
                    $message = "Удаление из БД: ошибка. \n" . $db->error;
                }
            }

        }
    } else {
        $isError = TRUE;
        $message = "Необходимо выбрать инструменты!";
    }
    if($isError == TRUE){
        
    } else {
        $message = "Удалено успешно!";
    }
    include $viewFolder . "neAddToolsToNabRez.php"; //remark
}

function editToolCopy(){
    include "config.php";
    $isError = FALSE;
    $message = "";
    $toolID = $_POST['toolID'];
    if(empty($_POST['CopyCount'])){
        $isError = TRUE;
        $message = "Неуказано количество копий!";
    } else {
        $CopyCount = $_POST['CopyCount'];
        $db = dbConnect();
        $toolToCopyTmp = $db->query("SELECT * FROM instrum WHERE instrID = " . $toolID);
        $toolToCopy = $toolToCopyTmp->fetch_assoc();
        if(empty($toolToCopy)){
            $isError = TRUE;
            $message = $message . " Нет инструмента для копирования!";
        } else { 
            $timeStamp = new dateTime();
            $timeStampformated =  $timeStamp->format('d-m-Y');
            for ($i = 1; $i <= $CopyCount; $i++){
                $tmpQuery = "INSERT INTO instrum (`instrName`,`intrRemar`,`picPath`,`isDeleted`,`eventDate`) VALUES ('" . $toolToCopy['instrName'] . "', '" . $toolToCopy['intrRemar'] . "', '" . $toolToCopy['picPath'] . "', 0 , STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\"))";
                if($db->query($tmpQuery) === FALSE){
                    $isError = TRUE;
                    $messgae = "Запись не удалось!" . $db->error;
                }
            }
        }
    }
    if(!$isError){
        $message = "Скопировано успешно!";    
    }
    
    include $viewFolder . "sts.php";
}

function editNab(){
    include "config.php";
    $nabID = $_POST['nabID'];
    $db = dbConnect();
    $tmpNab = $db->query("SELECT * FROM nabDict WHERE nabID = ". $nabID); 
    $nab = $tmpNab->fetch_assoc();
    $tmpOtd = $db->query("SELECT * FROM sOtd WHERE idOtd = " . $nab['nabOtd']);
    $tmpOtdAssoc = $tmpOtd->fetch_assoc();
    $otdName = $tmpOtdAssoc['nameOtd'];
    $nabIDtmp = $nabID;
    $operType = "editNab";
    $delButton = 1;
    $dlgNabCaption = "Редактирование набора.";
    include $viewFolder . "nabEditDlg.php";
}

function neEditNab(){
    include "config.php";
    $isError = FALSE;
    $sStatus = "";
    $db = dbConnect();
    $otdID = $_POST['otdID'];
    $nabName = $_POST['nabName'];
    $nabID = $_POST['nabID'];
    $timeStamp = new dateTime();
    $timeStampformated =  $timeStamp->format('d-m-Y');

    if(!empty($_FILES['fileToLoadID']['name'])){
        $fileInfo = new SplFileInfo($_FILES['fileToLoadID']['name']);
        $fileExt = $fileInfo->getExtension();
        $newFileName = $timeStamp->format('Ymd_Hisv') . "." . $fileExt;
        $uploadfile = getcwd() . $uploaddir . $newFileName;
        
        $queryTmp = "UPDATE nabDict SET nabName = '" . $nabName . "', nabImg = '" . $uploaddir . $newFileName . "', eventDate = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE nabID = " . $nabID;

        if($db->query($queryTmp) === FALSE) {
            $isError = TRUE;
            $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
        } else {
            $sStatus = $sStatus . "Запись в БД: успешно. \n";
        }
        if (move_uploaded_file($_FILES['fileToLoadID']['tmp_name'], $uploadfile)) {
            $sStatus = $sStatus . "Загрузка файла: успешно. \n";;
        } else {
            $sStatus = $sStatus . "Загрузка файла: Ошибка. \n";
            $isError = TRUE;
        }
    } else {
        $queryTmp = "UPDATE nabDict SET nabName = '" . $nabName . "', eventDate  = STR_TO_DATE( '" . $timeStampformated . "', \"%d-%m-%Y\") WHERE nabID = " . $nabID;
        if($db->query($queryTmp) === FALSE) {
            $isError = TRUE;
            $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
        } else {
            $sStatus = $sStatus . "Запись в БД: успешно. \n";
        }
    }
    $db->close();
    if($isError){
        echo($sStatus);
    } else {
        echo("ok");
    }
}

function loadImgNabToStage(){
    include "config.php";
    $isError = FALSE;
    $sStatus = "";
    $nabID = $_POST['nabID'];
    if(empty($_FILES['fileToLoadID']['name'])){
    } else {
        $timeStamp = new dateTime();
        $timeStampformated =  $timeStamp->format('d-m-Y');
        $fileInfo = new SplFileInfo($_FILES['fileToLoadID']['name']);
        $fileExt = $fileInfo->getExtension();
        $newFileName = $timeStamp->format('Ymd_Hisv') . "." . $fileExt;
        $uploadfile = getcwd() . $uploaddir . $newFileName;

        $db = dbConnect();
        $tmpQuery = "INSERT INTO `cso`.`imgToNab` (`naborID`, `imgn`, `preor`) VALUES (" . $nabID . ", '" . $uploaddir . $newFileName . "', 1)";
        if($db->query($tmpQuery) === FALSE) {
            $isError = TRUE;
            $sStatus = $sStatus . "Запись в БД: ошибка. \n" . $db->error;
        } else {
            $sStatus = $sStatus . "Запись в БД: успешно. \n";
        }
        if (move_uploaded_file($_FILES['fileToLoadID']['tmp_name'], $uploadfile)) {
            $sStatus = $sStatus . "Загрузка файла: успешно. \n";;
        } else {
            $sStatus = $sStatus . "Загрузка файла: Ошибка. \n";
            $isError = TRUE;
        }


        if($isError){
            echo($sStatus);
        } else {
            echo("ok");
        }
    }
}

function smallImgView(){
    include "config.php";
    $nabID = $_POST['nabID'];
    $db= dbConnect();
    $tmpImgs = $db->query("SELECT * FROM imgToNab WHERE naborId = " . $nabID);
    $imgs = $tmpImgs->fetch_all(MYSQLI_ASSOC);
    include $viewFolder . "smallImgView.php";
}
?>