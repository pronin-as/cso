<h4 class="popup__title">
    <?=$dlgOtdCaption?>
    <?=$otdIDtmp?>
</h4>

<form class="popup__form form form_litle">

    <div class="form__item">
        <label for="otdNumDlgID">Номер отделения</label>
        <input class="form__element" type="text" value="<?=$otd["noOtd"]?>" id="otdNumDlgID">
    </div>

    <div class="form__item">
        <label for="otdNameDlgID">Наименование</label>
        <input class="form__element" type="text" value="<?=$otd["nameOtd"]?>" id="otdNameDlgID">
    </div>

    <div class="form__item_btn">
        <button class="btn" id="editOtdDlgCloseButtonID">Отмена</button>
        <button class="btn" id="editOtdDlgSaveButtonID">Сохранить</button>

        <?php
        if($delButton == 1){
            echo "<button class=\"btn\" id=\"deleteOtdDlgSaveButtonID\">Удалить</button>";
        }
        ?>

    </div>

    <input type="hidden" id="tmpOtdID" value="<?=$otdIDtmp?>">
    <input type="hidden" id="operType" value="<?=$operType?>">

</form>

            
        