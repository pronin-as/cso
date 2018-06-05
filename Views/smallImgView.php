<table>
<? 
    foreach($imgs as $img) {
        echo "<tr>"; ?>
        <td><img src="<?=$img['imgn']?>" alt="" widht="100"></td>
      <?  echo "</tr>";
    }
?>
</table>