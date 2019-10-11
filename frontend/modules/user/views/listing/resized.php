<?php
$filename = Yii::$app->urlManager->createAbsoluteUrl('albums/images/listings/'.$imagename);
$percent = 0.5; // percentage of resize

// Content type
header('Content-type: image/jpeg');

// Get new dimensions
list($width, $height) = getimagesize($filename);
$new_width = $imgwidth;
$new_height = $imgheight;

// Resample
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    ob_start ();

    imagejpeg($image_p);
    imagedestroy($image_p);

    $data = ob_get_contents ();

    ob_end_clean ();

// Output
//imagejpeg($image_p, null, 100);
echo "<div class='margin_top20 margin_bottom20'><center><img src='data:image/jpeg;base64,".base64_encode ($data)."'></center></div>";

?>
