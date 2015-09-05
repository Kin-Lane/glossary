<?php
$route = '/glossary/:glossary_id/';
$app->get($route, function ($glossary_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$glossary_id = prepareIdIn($glossary_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM glossary WHERE glossary_id = " . $glossary_id;
	//echo $Query . "<br />";

	$GlossaryResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Glossary = mysql_fetch_assoc($GlossaryResult))
		{

		$glossary_id = $Glossary['glossary_id'];
		$term = $Glossary['term'];
		$definition = $Glossary['definition'];

		// manipulation zone

		$glossary_id= prepareIdOut($glossary_id,$host);

		$F = array();
		$F['glossary_id'] = $glossary_id;
		$F['term'] = $term;
		$F['definition'] = $definition;

		$ReturnObject = $F;
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
 ?>
