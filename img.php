<?php 

function resizeToMaxView(string $srcfile, string $dstfile, int $widht){
        //$srcFileHandler = fopen($srcfile, "r");
        $srcImg = imagecreatefromjpeg($srcfile);
        $srcImgX = imagesx($srcImg);
        $srcImgY = imagesy($srcImg);

        $k = $srcImgX / $widht;
        $dstX = $widht;
        $dstY = $srcImgY / $k;

        $dstImg = imagecreatetruecolor($dstX,$dstY);
        imagecopyresampled($dstImg,$srcImg,0,0,0,0,$dstX,$dstY,imagesx($srcImg),imagesy($srcImg));

        imagejpeg($dstImg, $dstfile, 75 );
        imagedestroy($srcImg);
        imagedestroy($dstImg);
}

?>