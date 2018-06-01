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
                <div class="list__item">

                    <div id="<?=$selectName?>"  class="neToolInNabSelectClassL list__tool">
                        <p> <?=$row["instrName"] ?> </p>
                        <p class="list__desc"> <?=$row["intrRemar"] ?> </p>
                    </div>

                    <div class="list__img">
                        <img src="<?=$row["picPath"]?>" class="imgIconClass" />
                    </div>

                </div>
        <?php    } ?>
</div>