<h4><?=$dlgNabCaption?> <?=$nabIDtmp?> </h4>
<h5>Отделение: <?=$otdName?></h5>
            <table>
                <tr>
                    <td><span>Наименование набора</span></td><td><input type="text" value="<?=$nab["nabName"]?>" id="nabDlgID"></td>
                </tr>
                <tr>
                    <td><span>Изображение</span></td><td><input type="file" id="fileNabToLoadID" /></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td><button id="editNabDlgCloseButtonID">Отмена</button></td><td><button id="editNabDlgSaveButtonID">Сохранить</button></td>
                    <td><?php   
                        if($delButton == 1){
                            echo "<button id=\"deleteNabDlgSaveButtonID\">Удалить</button>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
<input type="hidden" id="tmpNabID" value="<?=$nabIDtmp?>">
<input type="hidden" id="operType" value="<?=$operType?>">