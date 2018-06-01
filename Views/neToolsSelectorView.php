

<?php while ($row = $neToolsList->fetch_assoc()) {
        $selectName = "selectName" . $row["instrID"];
        ?>
            <div class="list__item">
                <div id="<?=$selectName?>" class="neNabSelectClassR list__tool">
                    <p><?=$row["instrName"] ?></p>
                    <p><?=$row["intrRemar"] ?></p>
                </div>
                <div class="list__img">
                    <img src="<?=$row["picPath"]?>" class="imgIconClass" />
                </div>
            </div>
    <?php    } ?>
