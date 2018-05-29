<table>
    <?php 
    /*    while ($row = $toolsList->fetch_assoc()) {
            printf ("<tr> <td> %s </td><td>(%s)</td></tr>", $row["instrName"], $row["intrRemar"]);
        } */
    ?>
    <tr>
        <th>Наименование</th>
        <th>Примечание</th>
        <th>Сервис</th>
    </tr>
    <?php while ($row = $toolsList->fetch_assoc()) { 
        $editName = "editName" . $row["instrID"];
        $selectName = "selectName" . $row["instrID"];
        ?>
            <tr id="<?=$selectName?>" class="toolSelectClass"> 
                <td> <?=$row["instrName"] ?> </td>
                <td> <?=$row["intrRemar"] ?> </td>
                <td><img src="img/detail.png" name="<?=$editName?>" class="toolEditClass"></td>
            </tr>
    <?php    } ?>
</table>
