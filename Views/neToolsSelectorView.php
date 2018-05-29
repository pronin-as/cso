<table id="toolNomenklTabID">
    <tr>
        <th>Наименование</th>
        <th>Примечание</th>
    </tr>
    <?php while ($row = $neToolsList->fetch_assoc()) { 
        $selectName = "selectName" . $row["instrID"];
        ?>
            <tr id="<?=$selectName?>" class="neNabSelectClassR"> 
                <td> <?=$row["instrName"] ?> </td>
                <td> <?=$row["intrRemar"] ?> </td>
                <td><img src="<?=$row["picPath"]?>" class="imgIconClass" /></td>
            </tr>
    <?php    } ?>
</table>