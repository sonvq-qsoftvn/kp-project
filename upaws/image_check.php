<?php
function getExtension($str) 
{
         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}

$valid_formats = array("jpg", "png", "gif", "mp3", "caf", "mov", "bmp", "jpeg", "aac" , "wav", "mp4", "3gp", "avi", "PNG", "JPG", "JPEG", "GIF", "BMP", "MP3", "CAF", "MOV", "AAC" , "WAV", "MP4", "3GP", "AVI",);

?>