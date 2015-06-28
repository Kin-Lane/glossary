<?php
$route = '/glossary/:glossary_id/tags/:tag';
$app->delete($route, function ($glossary_id,$tag)  use ($app){


	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($tag))
		{

		$tag = trim(mysql_real_escape_string($tag));

		$ChecktagQuery = "SELECT tag_id FROM tags where tag = '" . $tag . "'";
		$ChecktagResults = mysql_query($ChecktagQuery) or die('Query failed: ' . mysql_error());
		if($ChecktagResults && mysql_num_rows($ChecktagResults))
			{
			$tag = mysql_fetch_assoc($ChecktagResults);
			$tag_id = $tag['tag_id'];

			$DeleteQuery = "DELETE FROM glossary_tag_pivot WHERE tag_id = " . trim($tag_id) . " AND glossary_id = " . trim($glossary_id);
			$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());
			}

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['profile_count'] = 0;

		array_push($ReturnObject, $F);

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
 ?>
