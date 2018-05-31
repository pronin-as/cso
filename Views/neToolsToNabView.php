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
                <div>
                    <div id="<?=$selectName?>" class="neToolInNabSelectClassL list__item">
                        <p class="list__tool"> <?=$row["instrName"] ?> </p>
                        <p class="list__desc"> <?=$row["intrRemar"] ?> </p>
                    </div>
                    <div class="list__desc"> <img src="<?=$row["picPath"]?>" class="imgIconClass" /> </div>
                </div>
        <?php    } ?>
</div>