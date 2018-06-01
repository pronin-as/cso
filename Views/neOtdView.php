<select class="form__element" id="neOtdSelectorID">
<? foreach ( $snOtdTmp as $row){ ?>
    <option value="<?=$row['idOtd']?>"><?=$row['noOtd'] . " " . $row['nameOtd']?></option>
<? }?>
</select>