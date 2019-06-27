<?php
// Config Vars

$sourcefolder = "./"           ; // Default: "./"
$zipfilename  = "myarchive.zip"; // Default: "myarchive.zip"
$timeout      = 5000           ; // Default: 5000

// instantate an iterator (before creating the zip archive, just
// in case the zip file is created inside the source folder)
// and traverse the directory to get the file list.
$dirlist = new RecursiveDirectoryIterator($sourcefolder);
$filelist = new RecursiveIteratorIterator($dirlist);

// set script timeout value
ini_set('max_execution_time', $timeout);

// instantate object
$zip = new ZipArchive();

// create and open the archive
if ($zip->open("$zipfilename", ZipArchive::CREATE) !== TRUE) {
    die ("Could not open archive");
}

// add each file in the file list to the archive
foreach ($filelist as $key=>$value) {
    $zip->addFile(realpath($key), $key) or die ("ERROR: Could not add file: $key");
}

// close the archive
$zip->close();
echo "Archive ". $zipfilename . " created successfully.";

// And provide download link ?>
<a href="http:<?php echo $zipfilename;?>" target="_blank">
Download <?php echo $zipfilename?></a> 