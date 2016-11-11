<?php
include ("DBTool.php");

$DB = new Database();
$result = $DB->Query("select * from Questions");
$row = $result->fetch_array();
print_r($row);