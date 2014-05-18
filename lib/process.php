<?php
	/**
	* Process the request and form the appropriate response
	* 
	*/
	/**
	* Include required files
	*/
	require_once("search_result_page.php");
	require_once("database.php");
	$search_text = isset($_POST['searchbox']) ? $_POST['searchbox'] : "";
	$critiria = isset($_POST['critiria']) ? $_POST['critiria'] : "";
	$results_limit = isset($_POST['results_limit']) ? $_POST['results_limit'] : "";

	//Call the process function dynamically
    $func = 'process_'.$critiria ;
    $func($critiria, $search_text, $results_limit);
    
/*	switch ($critiria) {
	    case "name":
	        process_name($critiria, $search_text, $results_limit);
	        break;
	        
	    case "name_research_area":
	    	process_name_research_area($critiria, $search_text, $results_limit);
	    	break;

	    case "name_institute":
	     	process_name_institute($critiria, $search_text, $results_limit);
	        break;

	    case "name_department":
	     	process_name_department($critiria, $search_text, $results_limit);
	        break;

	    case "name_department_institute":
	    	process_name_department_institute($critiria, $search_text, $results_limit);
	    	break;

	    case "research_area":
	    	process_research_area($critiria, $search_text, $results_limit);
	    	break;

	    case "institute":
	    	process_institute($critiria, $search_text, $results_limit);
	    	break;

	    case "department":
	    	process_department($critiria, $search_text, $results_limit);
	    	break;
	}
*/
	/**
	* Process the request based on name
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_name($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
        $results = Database::get_names($search_text, $results_limit);
        display_results($results);
        display_results_end();
        
	}

	/**
	* Process the request based on research area
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_research_area($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
        $results = Database::get_research_area($search_text, $results_limit);
        display_results($results);
        display_results_end();
	}

	/**
	* Process the request based on name and research area
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_name_research_area($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
		
		//Split search text for name and research area
		$search_text_split = explode(" AND ", $search_text);
		$search_text_name = $search_text_split[0];
		$search_text_research_area = isset($search_text_split[1]) ? $search_text_split[1] : "";
        
        $results = Database::get_name_research_area($search_text_name, $search_text_research_area, $results_limit);
        display_results($results);
        display_results_end();	
	}

	/**
	* Process the request based on name and institute
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_name_institute($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
		
		//Split search text for name and research area
		$search_text_split = explode(" AND ", $search_text);
		$search_text_name = $search_text_split[0];
		$search_text_institute = isset($search_text_split[1]) ? $search_text_split[1] : "";
      
        $results = Database::get_name_institute($search_text_name, $search_text_institute, $results_limit);
        display_results($results);
        display_results_end();		
	}

	/**
	* Process the request based on department
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_department($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
        $results = Database::get_department($search_text, $results_limit);
        display_results($results);
        display_results_end();		
	}

	/**
	* Process the request based on name and department
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_name_department($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
		
		//Split search text for name and research area
		$search_text_split = explode(" AND ", $search_text);
		$search_text_name = $search_text_split[0];
		$search_text_department = isset($search_text_split[1]) ? $search_text_split[1] : "";
      
        $results = Database::get_name_department($search_text_name, $search_text_department, $results_limit);
        display_results($results);
        display_results_end();	
	}

	/**
	* Process the request based on institute
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_institute($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
        $results = Database::get_institute($search_text, $results_limit);
        display_results($results);
        display_results_end();
	}

	/**
	* Process the request based on name, department and institute
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_name_department_institute($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
		
		//Split search text for name and research area
		$search_text_split = explode(" AND ", $search_text);
		$search_text_name = $search_text_split[0];
		$search_text_department = isset($search_text_split[1]) ? $search_text_split[1] : "";
		$search_text_institute = isset($search_text_split[2]) ? $search_text_split[2] : "";
      
        $results = Database::get_name_department_institute($search_text_name, $search_text_department, $search_text_institute, $results_limit);
        display_results($results);
        display_results_end();		
	}

	/**
	* Process the request based on research area and institute
	* @param String $critiria Search Critiria 
	* @param String $search_text Search text
	* @param Integer $results_limit Limit for query results
	*/
	function process_research_area_institute($critiria, $search_text, $results_limit){
		display_results_head($critiria, $search_text, $results_limit);
		
		//Split search text for name and research area
		$search_text_split = explode(" AND ", $search_text);
		$search_text_research_area = $search_text_split[0];
		$search_text_institute = isset($search_text_split[1]) ? $search_text_split[1] : "";
      
        $results = Database::get_research_area_institute($search_text_research_area, $search_text_institute, $results_limit);
        display_results($results);
        display_results_end();		
	}
?>