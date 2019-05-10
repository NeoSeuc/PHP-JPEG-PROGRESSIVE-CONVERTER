<?php
/**
 * run from shell
 */
$basedir = "uploads/uploads.bak"; // base dir with images

scan_files($basedir);

function scan_files($path)
{
    $dir = scandir($path);

    for ($i = 2; $i < count($dir); $i++) {
        $new_path = $path . "/" . $dir[$i];
        if (is_dir($new_path))
            scan_files($new_path);
        else {
            if (!file_exists($new_path)) {
                echo "\e[0;31m" . $new_path . " image not find \n";
                continue;
            }
            $mime = mime_content_type($new_path);
            if (isImage($mime)) {

                $im = imagecreatefromjpeg($new_path);

                if (!$im) {
                    echo "\e[1;31m" . $new_path . " can`t open the image, check permissions \n";
                    continue;
                }

                imageinterlace($im, true);

                imagejpeg($im, $new_path);

                echo "\e[0;32m" . $new_path . " change to progressive \n";

            } else continue;
        }
    }
}

function isImage($mime)
{
    $available_types = array("jpeg", "jpg");
    foreach ($available_types as $type) {
        if (strpos($mime, $type) !== false)
            return true;
    }
    return false;
}