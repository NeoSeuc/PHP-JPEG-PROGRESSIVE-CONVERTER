<?php

$basedir = "imgs";

scan_files($basedir);

function scan_files($path) {
    $dir = scandir($path);

    for( $i = 2; $i <count($dir); $i++) {
        $new_path = $path."/".$dir[$i];
        if (is_dir($new_path))
            scan_files($new_path);
        else {
            $mime = mime_content_type($new_path);
            if (preg_match("/image/", $mime)) {
                $im = imagecreatefromjpeg($new_path);
                imageinterlace($im, true);
                imagejpeg($im, $new_path);
                echo $new_path." change to progressive";
            } else continue;
        }
    }
}
