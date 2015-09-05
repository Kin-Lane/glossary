<?php
$route = '/glossary/:glossary_id/';
$app->put($route, function ($glossary_id) use ($app){

  $host = $_SERVER['HTTP_HOST'];
	$glossary_id = prepareIdIn($glossary_id,$host);

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['term'])){ $term = $param['term']; } else { $term = ''; }
	if(isset($param['definition'])){ $definition = $param['definition']; } else { $definition = ''; }

  $LinkQuery = "SELECT * FROM glossary WHERE glossary_id = " . $glossary_id;
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$query = "UPDATE glossary SET ";

		if(isset($term))
			{
			$query .= "term='" . mysql_real_escape_string($term) . "'";
			}
		if(isset($definition))
			{
			$query .= ",definition='" . mysql_real_escape_string($definition) . "'";
			}

		$query .= " WHERE glossary_id = " . $glossary_id;

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());

	  $glossary_id= prepareIdOut($glossary_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Glossary Updated!";
		$ReturnObject['glossary_id'] = $glossary_id;

		}
	else
		{
		$Link = mysql_fetch_assoc($LinkResult);

    $glossary_id= prepareIdOut($glossary_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Glossary Doesn't Exist!";
		$ReturnObject['glossary_id'] = $glossary_id;

		}

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
