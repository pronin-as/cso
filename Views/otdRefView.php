<table>
    <tr>
        <th>Номер</th>
        <th>Наименование</th>
        <th>Сервис</th>
    </tr>
    <? //while ($row = $sOtdTmp->fetch_assoc()) { ?>
    <? foreach ($sOtdTmp as $row) { 
        $editOtdName = "editOtdName" . $row["idOtd"];
    ?>
    <tr>
        <td><?=$row['noOtd'] ?></td>
        <td><?=$row['nameOtd'] ?></td>
        <td><img src="img/detail.png" name="<?=$editOtdName ?>" class="otdEditClass"></td>
    </tr>
    <? } ?>
</table>