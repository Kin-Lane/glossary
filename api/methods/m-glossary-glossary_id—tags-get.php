<?php
$route = '/glossary/:glossary_id/tags/';
$app->get($route, function ($glossary_id)  use ($app){


	$ReturnObject = array();

	$Query = "SELECT t.tag_id, t.tag, count(*) AS Profile_Count from tags t";
	$Query .= " JOIN glossary_tag_pivot ptp ON t.tag_id = ptp.tag_id";
	$Query .= " WHERE ptp.glossary_id = " . $glossary_id;
	$Query .= " GROUP BY t.tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];
		$glossary_count = $Database['Profile_Count'];

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['glossary_count'] = $glossary_count;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});	
 ?>
