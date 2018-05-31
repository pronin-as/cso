    <?php while ($row = $neToolsList->fetch_assoc()) { 
        $selectName = "selectName" . $row["instrID"];
        ?>
            <div> 
                <div id="<?=$selectName?>" class="neNabSelectClassR">
                    <p> <?=$row["instrName"] ?> </p>
                    <p> <?=$row["intrRemar"] ?> </p>
                </div>
                <div>
                    <img src="<?=$row["picPath"]?>" class="imgIconClass" />
                </div>
            </div>
    <?php    } ?>
