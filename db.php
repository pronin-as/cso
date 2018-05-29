<?php

class dbContext
{
    private $isErrori;
    private $sOtdCon;
    private $result;
    private $resultTmp;


    function sdbConnect ()
    {
        include "config.php";
        $dbc = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
        if($dbc->connect_errno) { echo "Не удалось подключиться к MySQL: (" . $mysqli->connct_errno .") " . $mysqli->connect_error; }
        return $dbc;
    }

    function query($query){
        
        $isErrori = FALSE;
        if(strlen(trim($query)) > 0){
            $sCon = self::sdbConnect();
            $resultTmp = $sCon->query($query);
            if($sCon->error){
                $isErrori = TRUE;
            } else {
               $result = $resultTmp->fetch_all(MYSQLI_ASSOC);
            }
        } else{
            $isErrori = TRUE;
        }

        $resultTmp->free();
        $sCon->close();

        if(!$isErrori){
            return $result;
        } else{
           return FALSE;
       }

    }
}



function dbConnect ()
{
    include "config.php";
    $dbc = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
    if($dbc->connect_errno) { echo "Не удалось подключиться к MySQL: (" . $mysqli->connct_errno .") " . $mysqli->connect_error; }
    return $dbc;
}

function selectAssoc ($database, $query)
{

    $tt = new sOtd();
    $row = $tt->select();

    $result = mysql_db_query($database, $query) or die ('Запрос не удался: ' . mysql_error());
    return $result;
}
?>