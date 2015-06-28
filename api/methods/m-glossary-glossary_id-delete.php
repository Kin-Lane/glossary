<?php
$route = '/glossary/:glossary_id/';
$app->delete($route, function ($glossary_id) use ($app){

	$ReturnObject = array();

	$query = "DELETE FROM glossary WHERE glossary_id = " . $glossary_id;
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());

	$ReturnObject = array();
	$ReturnObject['message'] = "Glossary Deleted!";
	$ReturnObject['glossary_id'] = $glossary_id;

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
