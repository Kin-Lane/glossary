<?php
$route = '/glossary/';
$app->post($route, function () use ($app){

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['term'])){ $term = $param['term']; } else { $term = ''; }
	if(isset($param['definition'])){ $definition = $param['definition']; } else { $definition = ''; }

  	$LinkQuery = "SELECT * FROM glossary WHERE term = '" . $term . "'";
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$Link = mysql_fetch_assoc($LinkResult);

		$glossary_id = $Link['glossary_id'];

		$ReturnObject = array();
		$ReturnObject['message'] = "Glossary Already Exists!";
		$ReturnObject['glossary_id'] = $glossary_id;

		}
	else
		{

		$query = "INSERT INTO glossary(";


		if(isset($term)){ $query .= "term,"; }
		if(isset($definition)){ $query .= "definition,"; }

		$query .= "closing";

		$query .= ") VALUES(";

		if(isset($term)){ $query .= "'" . mysql_real_escape_string($term) . "',"; }
		if(isset($definition)){ $query .= "'" . mysql_real_escape_string($definition) . "',"; }

		$query .= "'nothing'";

		$query .= ")";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$glossary_id = mysql_insert_id();

    $host = $_SERVER['HTTP_HOST'];
	  $glossary_id= prepareIdOut($glossary_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Glossary Term Added";
		$ReturnObject['glossary_id'] = $glossary_id;

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
