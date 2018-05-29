<h3 class="popup__title">
    <?=$dlgCaption?>
    <?=$toolIDtmp?>
</h3>

<form class="popup__form form form_litle">

    <div class="form__item">
        <label for="instrNameDlgID">Наименование</label>
        <input class="form__element" type="text" value="<?=$tool["instrName"]?>" id="instrNameDlgID">
    </div>

    <div class="form__item">
        <label for="instrRemarkDlgID">Примечание</label>
        <input class="form__element" type="text" value="<?=$tool["intrRemar"]?>" id="instrRemarkDlgID">
    </div>

    <div class="form__item">
        <label for="fileToLoadID">Изображение</label>
        <input type="file" id="fileToLoadID">
    </div>

    <div class="form__item_btn">
        <button class="btn"  id="editToolDlgCloseButtonID">Отмена</button>
        <button class="btn"  id="editToolDlgSaveButtonID">Сохранить</button>

        <?php
        if($delButton == 1){
            echo "<button class=\"btn\"  id=\"deleteToolDlgSaveButtonID\">Удалить</button>";
        }
        ?>
    </div>

    <input class="btn" type="hidden" id="tmptoolID" value="<?=$toolIDtmp?>">
    <input class="btn" type="hidden" id="operType" value="<?=$operType?>">
</form>
