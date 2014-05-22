<?php
/**
* All search related functions are defined in this file
*/
/**
* 
*/
	require_once("search_result_page.php");
	define("SOLR_URL", "http://localhost:8983/solr/collection1/");
	class Search
	{
		public static function getURL($URL='')
		{
			$content = file_get_contents($URL);
			if($content) {
				$content = json_decode($content, true);
				//var_dump($content['response']['docs']);
				//var_dump($content);
			    return $content['response'];
			}
		}
	}
?>