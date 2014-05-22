<?php
	/**
	* Process the request and form the appropriate response
	* 
	*/
	/**
	* Include required files
	*/
	require_once("search_result_page.php");
	require_once("search.php");
	//error_reporting(0);
	

	$search_text = isset($_POST['searchbox']) ? $_POST['searchbox'] : "";
	
	// $results_limit = isset($_POST['results_limit']) ? $_POST['results_limit'] : "";
	// $search_text_array = str_replace(" ","%2B",$search_text_array);	

	
	// $query = "select?q=*:*&fq=faculty_name:" . $search_text_array .
	// 			"+OR+research_field:" . $search_text_array . 
	// 			"+OR+dept_code:". $search_text_array .
	// 			"+OR+dept_name:". $search_text_array . 
	// 			"+OR+institute_name:" . $search_text_array .
	// 			"&row=". $results_limit .
	// 			"&sort=score+desc&wt=json&indent=true";

	$search_text = trim($search_text);
	if ($search_text == "") {
		return;
	}
	$search_text = preg_replace('/\s+/', ' ', $search_text);
	$search_text_array = explode(" ", $search_text);

    if (count($search_text_array) == 1) {
    	$query = "select?q=*:*".
				"&fq=faculty_name:" . $search_text_array[0] .
					"+OR+research_field:" . $search_text_array[0] . 
					"+OR+dept_code:". $search_text_array[0] .
					"+OR+dept_name:". $search_text_array[0] . 
					"+OR+institute_name:" . $search_text_array[0] .
					"+OR+qualifications:" . $search_text_array[0] .
					"+OR+publications:" . $search_text_array[0] .
					"+OR+specialization:" . $search_text_array[0] .
					"+OR+designation:" . $search_text_array[0] .
				"&row=". $results_limit .
				"&sort=score+desc&wt=json&indent=true";
    }
    else if (count($search_text_array) == 2) {
    	$query = "select?q=*:*".
				"&fq=(faculty_name:" . $search_text_array[0] .
					"+AND+research_field:" . $search_text_array[1] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+dept_code:" . $search_text_array[1] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+dept_name:" . $search_text_array[1] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] . ")" .

					"+OR+(research_field:" . $search_text_array[0] .
					"+AND+faculty_name:" . $search_text_array[1] . ")" .

					"+OR+(research_field:" . $search_text_array[0] .
					"+AND+dept_code:" . $search_text_array[1] . ")" .

					"+OR+(research_field:" . $search_text_array[0] .
					"+AND+dept_name:" . $search_text_array[1] . ")" .

					"+OR+(research_field:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] . ")" .
					
					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+faculty_name:" . $search_text_array[1] . ")" .

					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+dept_code:" . $search_text_array[1] . ")" .

					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+dept_name:" . $search_text_array[1] . ")" .

					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+research_field:" . $search_text_array[1] . ")" .
				"&row=". $results_limit .
				"&sort=score+desc&wt=json&indent=true";
    }
    else if (count($search_text_array) == 3) {
    	$query = "select?q=*:*".
				"&fq=(faculty_name:" . $search_text_array[0] .
					"+AND+research_field:" . $search_text_array[1] .
					"+AND+institute_name:" . $search_text_array[2] . ")" .

					"+OR+(research_field:" . $search_text_array[0] .
					"+AND+dept_code:" . $search_text_array[1] .
					"+AND+institute_name:" . $search_text_array[2] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] . 
					"+AND+dept_name:" . $search_text_array[2] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] . 
					"+AND+dept_code:" . $search_text_array[2] . ")" .


					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] . 
					"+AND+research_field:" . $search_text_array[2] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+dept_name:" . $search_text_array[1] . 
					"+AND+institute_name:" . $search_text_array[2] . ")" .

					"+OR+(faculty_name:" . $search_text_array[0] .
					"+AND+dept_code:" . $search_text_array[1] . 
					"+AND+institute_name:" . $search_text_array[2] . ")" .

					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+dept_code:" . $search_text_array[1] .
					"+AND+faculty_name:" . $search_text_array[2] . ")" .

					// "+OR+(research_field:" . $search_text_array[0] .
				// 	// "+AND+dept_name:" . $search_text_array[1] . 
				// 	// "+AND+research_field:" . $search_text_array[2] . ")" .

				// 	// "+OR+(research_field:" . $search_text_array[0] .
				// 	// "+AND+institute_name:" . $search_text_array[1] . 
				// 	// "+AND+dept_name:" . $search_text_array[2] . ")" .

					
					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+faculty_name:" . $search_text_array[1] . 
					"+AND+dept_code:" . $search_text_array[2] . ")" .

					"+OR+(institute_name:" . $search_text_array[0] .
					"+AND+faculty_name:" . $search_text_array[1] . 
					"+AND+dept_name:" . $search_text_array[2] . ")" .

				// 	"+OR+(institute_name:" . $search_text_array[0] .
				// 	"+AND+dept_name:" . $search_text_array[1] . 
				// 	"+AND+research_field:" . $search_text_array[2] . ")" .

					"+OR+(dept_code:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] .
					"+AND+faculty_name:" . $search_text_array[2] . ")" .
					
					"+OR+(dept_name:" . $search_text_array[0] .
					"+AND+institute_name:" . $search_text_array[1] .
					"+AND+faculty_name:" . $search_text_array[2] . ")" .

				"&row=". $results_limit .
				"&sort=score+desc&wt=json&indent=true";
    }
	
	
	
	$results =  Search::getURL(SOLR_URL . $query);
	//$search_text = str_replace("%2B"," ",$search_text);	
	display_results_head($search_text, $results_limit);
	display_results($results);
    display_results_end();
        
	//Call the process function dynamically
    //$func = 'process_'.$critiria ;
    //$func($critiria, $search_text_array, $results_limit);
    
/*	switch ($critiria) {
	    case "name":
	        process_name($critiria, $search_text_array, $results_limit);
	        break;
	        
	    case "name_research_area":
	    	process_name_research_area($critiria, $search_text_array, $results_limit);
	    	break;

	    case "name_institute":
	     	process_name_institute($critiria, $search_text_array, $results_limit);
	        break;

	    case "name_department":
	     	process_name_department($critiria, $search_text_array, $results_limit);
	        break;

	    case "name_department_institute":
	    	process_name_department_institute($critiria, $search_text_array, $results_limit);
	    	break;

	    case "research_area":
	    	process_research_area($critiria, $search_text_array, $results_limit);
	    	break;

	    case "institute":
	    	process_institute($critiria, $search_text_array, $results_limit);
	    	break;

	    case "department":
	    	process_department($critiria, $search_text_array, $results_limit);
	    	break;
	}
*/
	// /**
	// * Process the request based on name
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_name($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
 //        $results = Database::get_names($search_text_array, $results_limit);
 //        display_results($results);
 //        display_results_end();
        
	// }

	// /**
	// * Process the request based on research area
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_research_area($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
 //        $results = Database::get_research_area($search_text_array, $results_limit);
 //        display_results($results);
 //        display_results_end();
	// }

	// /**
	// * Process the request based on name and research area
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_name_research_area($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
		
	// 	//Split search text for name and research area
	// 	$search_text_array_split = explode(" AND ", $search_text_array);
	// 	$search_text_array_name = $search_text_array_split[0];
	// 	$search_text_array_research_area = isset($search_text_array_split[1]) ? $search_text_array_split[1] : "";
        
 //        $results = Database::get_name_research_area($search_text_array_name, $search_text_array_research_area, $results_limit);
 //        display_results($results);
 //        display_results_end();	
	// }

	// /**
	// * Process the request based on name and institute
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_name_institute($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
		
	// 	//Split search text for name and research area
	// 	$search_text_array_split = explode(" AND ", $search_text_array);
	// 	$search_text_array_name = $search_text_array_split[0];
	// 	$search_text_array_institute = isset($search_text_array_split[1]) ? $search_text_array_split[1] : "";
      
 //        $results = Database::get_name_institute($search_text_array_name, $search_text_array_institute, $results_limit);
 //        display_results($results);
 //        display_results_end();		
	// }

	// /**
	// * Process the request based on department
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_department($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
 //        $results = Database::get_department($search_text_array, $results_limit);
 //        display_results($results);
 //        display_results_end();		
	// }

	// /**
	// * Process the request based on name and department
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_name_department($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
		
	// 	//Split search text for name and research area
	// 	$search_text_array_split = explode(" AND ", $search_text_array);
	// 	$search_text_array_name = $search_text_array_split[0];
	// 	$search_text_array_department = isset($search_text_array_split[1]) ? $search_text_array_split[1] : "";
      
 //        $results = Database::get_name_department($search_text_array_name, $search_text_array_department, $results_limit);
 //        display_results($results);
 //        display_results_end();	
	// }

	// /**
	// * Process the request based on institute
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_institute($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
 //        $results = Database::get_institute($search_text_array, $results_limit);
 //        display_results($results);
 //        display_results_end();
	// }

	// /**
	// * Process the request based on name, department and institute
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_name_department_institute($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
		
	// 	//Split search text for name and research area
	// 	$search_text_array_split = explode(" AND ", $search_text_array);
	// 	$search_text_array_name = $search_text_array_split[0];
	// 	$search_text_array_department = isset($search_text_array_split[1]) ? $search_text_array_split[1] : "";
	// 	$search_text_array_institute = isset($search_text_array_split[2]) ? $search_text_array_split[2] : "";
      
 //        $results = Database::get_name_department_institute($search_text_array_name, $search_text_array_department, $search_text_array_institute, $results_limit);
 //        display_results($results);
 //        display_results_end();		
	// }

	// /**
	// * Process the request based on research area and institute
	// * @param String $critiria Search Critiria 
	// * @param String $search_text_array Search text
	// * @param Integer $results_limit Limit for query results
	// */
	// function process_research_area_institute($critiria, $search_text_array, $results_limit){
	// 	display_results_head($critiria, $search_text_array, $results_limit);
		
	// 	//Split search text for name and research area
	// 	$search_text_array_split = explode(" AND ", $search_text_array);
	// 	$search_text_array_research_area = $search_text_array_split[0];
	// 	$search_text_array_institute = isset($search_text_array_split[1]) ? $search_text_array_split[1] : "";
      
 //        $results = Database::get_research_area_institute($search_text_array_research_area, $search_text_array_institute, $results_limit);
 //        display_results($results);
 //        display_results_end();		
	// }
?>