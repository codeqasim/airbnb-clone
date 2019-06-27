<?php
include_once('databaseValues.php');
$conn = @mysql_pconnect($hostName,$dbUserName,$dbPassword) or die("Database Connection Failed<br>". mysql_error());

mysql_select_db($databaseName, $conn) or die('DB not selected');

mysql_query("ALTER TABLE `fc_admin_settings` ADD `home_logo_image` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `logo_image`;
") or die(mysql_error());

echo "1";
mysql_close();

 ?>