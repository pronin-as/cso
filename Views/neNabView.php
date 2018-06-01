<select class="form__element" id="neNabSelectorID">
<? if($snNabTmp == "isEmpty"){?>
    <option value="9999999">Нет наборов</option>
<?} else {
  foreach ( $snNabTmp as $row){ ?>
    <option value="<?=$row['nabID']?>"><?=$row['nabName']?></option>
<? }}?>
</select>