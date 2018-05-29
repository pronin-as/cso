<select class="form__element form_big__select" id="neOtdSelectorID">
<? foreach ( $snOtdTmp as $row){ ?>
    <option value="<?=$row['idOtd']?>"><?=$row['noOtd'] . " " . $row['nameOtd']?></option>
<? }?>
</select>