<?php

include ("db_connect.php");

$tag= $_POST["tag"];

mysql_query("INSERT INTO tags (tagText) VALUES ('" . $tag . "')");
?>
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="sitestyle.css" />
</head>
<div class="success">New tag added successfully.</div>