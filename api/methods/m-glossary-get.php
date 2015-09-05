<?php
$route = '/glossary/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}

	if($query=='')
		{
		$Query = "SELECT * FROM glossary WHERE term LIKE '%" . $query . "%' OR definition LIKE '%" . $query . "%'";
		}
	else
		{
		$Query = "SELECT * FROM glossary";
		}

	$Query .= " ORDER BY term ASC";
	//echo $Query . "<br />";

	$GlossaryResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Glossary = mysql_fetch_assoc($GlossaryResult))
		{

		$glossary_id = $Glossary['glossary_id'];
		$term = $Glossary['term'];
		$definition = $Glossary['definition'];

		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$glossary_id = prepareIdOut($glossary_id,$host);

		$F = array();
		$F['glossary_id'] = $glossary_id;
		$F['term'] = $term;
		$F['definition'] = $definition;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
