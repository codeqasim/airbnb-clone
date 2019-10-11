<?php
@$ftmp = $_FILES['images']['tmp_name'];
@$oname = $_FILES['images']['name'];
@$fname = $_FILES['images']['name'];
@$fsize = $_FILES['images']['size'];
@$ftype = $_FILES['images']['type'];
$userid = $_REQUEST['user_id'];
$type = $_REQUEST['type'];
$siteurl = $_REQUEST['sitename'];
$ext = strrchr($oname, '.');
if($type=="user")
{
$user_image_path = "albums/images/users/";
$imagename = productSlug($oname);
$newname = $userid.'_'.$imagename.$ext;
    $resultarray['name'] = $newname;
    $resultarray['image'] = $siteurl.'/albums/images/users/'.$newname;
}
else if($type=="listing")
{
$imagecount = $_REQUEST['imagecount'];
$user_image_path = "albums/images/listings/";
$newname = time().'_'.$userid.'_'.$imagecount.$ext;
    $resultarray['name'] = $newname;
    $resultarray['image'] = $siteurl.'/albums/images/listings/'.$newname;
}
$resultarr = json_encode($resultarray);
$result = move_uploaded_file($ftmp,$user_image_path.$newname);
if($result)
{
echo '{"status":"true","result":'.$resultarr.'}';
}
else
{
echo '{"status":"false","message":"Sorry, Something went to be wrong"}';
}
function productSlug($str) {
		$old = $str;
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '', $str);
		$str = preg_replace('/-+/', "", $str);
		$str = substr($str, 0, 10);
		if(!empty($str))
		return $str;
		else return trim($old);
	}
?>