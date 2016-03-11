<?php

     session_start();

     $text = $_REQUEST['text'];
     
     $font=16;
     $width=100;
     $height=30;
     
     $image=imagecreate($width,$height);
     imagecolorallocate($image,240,239,204);
     $text_color=imagecolorallocate($image,250,0,0);
     $line_color=imagecolorallocate($image,13,13,01);
     for($x=0;$x<=25;$x++)
     {
          $x1=rand(1,100);
          $y1=rand(1,100);
          $x2=rand(1,100);
          $y2=rand(1,100);
          imageline($image,$x1,$y1,$x2,$y2,$line_color);
     }
     
     imagettftext($image,$font,0,10,24,$text_color,'arialbi.ttf',$text);
     imagejpeg($image);
?>
