<?php
header('Content-type: image/jpeg');
//print_r($_GET);die;
$imagename = $_GET['src'];
$imgwidth = $_GET['w'];
$imgheight = $_GET['h'];
$filename = $imagename;
$percent = 0.5; // percentage of resize
// Content type

$size = $imgwidth;
if(isset($_GET['h']) && $imgwidth < $imgheight){
	$size = $imgheight;
}

//Ratio Calcualtion
list($originalWidth, $originalHeight) = getimagesize($filename);
$ratio = $originalWidth / $originalHeight;

if($originalWidth > $imgwidth && $originalHeight > $imgheight){
	$targetWidth = $targetHeight = min($size, max($originalWidth, $originalHeight));
	
	if ($ratio < 1) {
		$targetWidth = $targetHeight * $ratio;
	} else {
		$targetHeight = $targetWidth / $ratio;
	}
	
	$srcWidth = $originalWidth;
	$srcHeight = $originalHeight;
	$srcX = $srcY = 0;
	
	$targetWidth = $targetHeight = min($originalWidth, $originalHeight, $size);
	
	if ($ratio < 1) {
		$srcX = 0;
		$srcY = ($originalHeight / 2) - ($originalWidth / 2);
		$srcWidth = $srcHeight = $originalWidth;
	} else {
		$srcY = 0;
		$srcX = ($originalWidth / 2) - ($originalHeight / 2);
		$srcWidth = $srcHeight = $originalHeight;
	}
	
	$image_p = imagecreatetruecolor($targetWidth, $targetHeight);
	$info = getimagesize($filename);
    $mime = $info['mime'];
	if($mime=="image/jpeg" || $mime=="image/jpg")
	{
		$image = imagecreatefromjpeg($filename);
	}
	else if($mime=="image/png" )
	{
		$image = imagecreatefrompng($filename);
	}
	else
	{
		$image = imagecreatefromgif($filename);
	}
	imagealphablending($image_p, false);
    $color = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
    imagefill($image_p, 0, 0, $color);
    imagesavealpha($image_p, true);
	imagecopyresampled($image_p, $image, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $srcWidth, $srcHeight);
}else{
	$info = getimagesize($filename);
    $mime = $info['mime'];
    if($mime=="image/jpeg" || $mime=="image/jpg")
    {	
		$image_p = imagecreatefromjpeg($filename);
	}
	else if($mime=="image/png" )
	{
		$image_p = imagecreatefrompng($filename);
	}
	else
	{
		$image_p = imagecreatefromgif($filename);
	}
}

/*
// Get new dimensions
list($width, $height) = getimagesize($filename);

$new_width = $imgwidth;
$new_height = $imgheight;

// Resample
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
*/
    ob_start ();

    imagejpeg($image_p);
    imagedestroy($image_p);

    $data = ob_get_contents ();

    ob_end_clean ();

// Output
//imagejpeg($image_p, null, 100);
echo $data;
//return base64_encode($data);
//return "<img src='data:image/jpeg;base64,".base64_encode ($data)."'>";

?>
//<?php
//function getImageXY( $image, $imgDimsMax=140 ) {
//    $image = 'http://localhost/airpg/albums/images/listings/1460719787_4_0.jpg';
//    $top = 0;
//    $left = 0;
//
//    $aspectRatio= 1;    // deafult aspect ratio...keep the image as is.
//
//    // set the default dimensions.
//    $imgWidth   = $imgDimsMax;
//    $imgHeight  = $imgDimsMax;
//
//    list( $width, $height, $type, $attr ) = getimagesize( $image );
//
//    if( $width == $height ) {
//        // if the image is less than ( $imgDimsMax x $imgDimsMax ), use it as is..
//        if( $width < $imgDimsMax ) {
//            $imgWidth   = $width;
//            $imgHeight  = $height;
//            $top = $imgDimsMax - $imgWidth;
//            $left = $imgDimsMax - $imgWidth;
//        }
//    } else {
//        if( $width > $height ) {
//            // set $imgWidth to $imgDimsMax and resize $imgHeight proportionately
//            $aspectRatio    = $imgWidth / $width;
//            $imgHeight      = floor ( $height * $aspectRatio );
//            $top = ( $imgDimsMax - $imgHeight ) / 2;
//        } else if( $width < $height ) {
//            // set $imgHeight to $imgDimsMax and resize $imgWidth proportionately
//            $aspectRatio    = $imgHeight / $height;
//            $imgWidth       = floor ( $width * $aspectRatio );
//            $left = ( $imgDimsMax - $imgWidth ) / 2;
//        }
//    }
//
//    return '<img src="' . $image . '" width="' . $imgWidth . '" height="' . $imgHeight . '" style="position:relative;display:inline;top:'.$top.'px;left:'.$left.'px;" />';
//}
//$imgresize = getImageXY('http://localhost/airpg/albums/images/listings/1460719787_4_0.jpg',140);
//echo $imgresize;
//?>