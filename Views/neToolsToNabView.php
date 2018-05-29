<!--
<table>
    <tr>
        <th>Наименование</th>
        <th>Примечание</th>
    </tr>
    <?php
/*
    while ($row = $neToolsToNabList->fetch_assoc()) {
        $selectName = "selectNameNab" . $row["ttnID"];
        ?>
            <tr id="<?=$selectName?>" class="neToolInNabSelectClassL"> 
                <td> <?=$row["instrName"] ?> </td>
                <td> <?=$row["intrRemar"] ?> </td>
            </tr>
    <?php    }
 */
    ?>
</table>
-->


<div>
    <?php
        while ($row = $neToolsToNabList->fetch_assoc()) {
            $selectName = "selectNameNab" . $row["ttnID"];
            ?>
                <div id="<?=$selectName?>" class="neToolInNabSelectClassL list__item">
                    <p class="list__tool"> <?=$row["instrName"] ?> </p>
                    <p class="list__desc"> <?=$row["intrRemar"] ?> </p>
                </div>
        <?php    } ?>
</div>