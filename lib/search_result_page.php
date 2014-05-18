<?php
/**
* Desplay the search results properly
*/
/**
* Include database.php
*/
	require_once("database.php");
	/**
	* Display the result head portion on the web page
	* @param String $critiria Search Critiria 
	* @param String $search_query Search text
	* @param Integer $results_limit Limit for query results
	*/
	function display_results_head($critiria, $search_query, $results_limit){
		echo '<!DOCTYPE HTML>
		<html>
			<head>
				<title>Knowledge Base Search Engine</title>
				<link rel="stylesheet" type="text/css" href="../css/main.css">
				<script src="../js/main.js"> </script>
				<script src="../js/jquery.min.js"> </script>
			</head>
			
			<body onload="select_item(\''. $critiria .'\')">
			<div id="result_page_search" class="containers"> 
				<form method="POST" action="process.php">
					<h1 id="heading"> Knowledge Based Search Engine  </h1>
					<fieldset id="result_page_search_select_field" class="border">
						<label>Search critiria :</label>
						<select name="critiria">
							<option id="name" value="name">Name</option>
							<option id="name_research_area" value="name_research_area">Name Research Area</option>
							<option id="name_institute" value="name_institute">Name Institute</option>
							<option id="name_department" value="name_department">Name Department</option>
							<option id="name_department_institute" value="name_department_institute">Name Department Institute</option>
							<option id="research_area" value="research_area">Research Area</option>
							<option id="research_area_institute" value="research_area_institute">Research Area Institute</option>
							<option id="institute" value="institute">Institute</option>
							<option id="department" value="department">Department</option>
						</select>
						<label> Result Limit :</label>
					<input name="results_limit" value="'. $results_limit .'" size="5">	
					</fieldset>

					<fieldset id="result_page_search_field">
						<input name="searchbox" id="result_page_search_bar" maxlength="200" type="text" autocapitalize="off" autocomplete="off" value="'.$search_query.'">
						<input id="submit_button" type="submit" value="Search">
					</fieldset>
					<label id="info_label">**Use AND to search for more than one criteria</label>
				<!--	<a href=""><label id="advance_search_label" onclick="advanced_search(true)">Advanced Search</label></a> -->
				</form>
			</div>
			<section id="answer" class="containers">';

	}

	/**
	* Display the result end portion on the web page
	*/
	function display_results_end(){
		echo '</section>		
			</body>
		</html>';
	}
	/**
	* Display the results into each faculty box fashion
	* @param mixed $results Query result from database
	*/
	function display_results($results)
	{
	    if (mysql_num_rows($results) == 0) 
	    { 
	     	echo  "<center id='no_result'>No results returned..!</center>";
        }
        else
        {
		    while($row = mysql_fetch_array($results))
		  	{
		  		echo '<div id="each_result" >';
		  		//Print Photo if available
			    echo "<div id='photo'>"; 
			    if($row['photo_href'] != "")
			    	echo "<img src='". $row['photo_href'] . "'></img>";
			    else
			    	echo "<img src='../images/default_photo.jpg'></img>";
			    echo "</div>";

			    //Display institute and department
			    //Display Designation if available
			    //Get designation from the lookup table
			    echo "<div class='result_box' id='personel_info'>"; 
			    echo '<p> <label><b> Name :</b></label><label>'. $row['faculty_name'] . '</label></p>';
			    echo '<p> <label><b> Institute :</b></label><label>'. Database::get_institute_name($row['institute_id']) . '</label></p>';
			    echo "<p><label><b> Department :</b></label>";
			    
			    if($row['dept_code'] != "")
			    	echo ' <label>'. Database::get_department_name($row['dept_code']) . '</label></p>';
			    else
			    	echo '<label>NOT AVALABLE</label></p>';	
			    
			    echo "<p><label><b> Designation :</b></label>";
			    if($row['designation'] != "")
			    	echo '<label>'. $row['designation'] . '</label></p>';
			    else
			    	echo '<label>NOT AVALABLE</label></p>';	

			    echo '<p> <label><b> Email :</b></label>
			    	<label><a href="mailto:'. $row['faculty_email'] . '" target="_blank">'. $row['faculty_email'] . '</a></label></p>';
			    if($row['faculty_page'] != "")
					echo '<p> <label><b> Faculty Page :</b></label>
						<label><a href="'. $row['faculty_page'] . '" target="_blank">'. $row['faculty_name'] . '</a></label></p>';
			    echo "</div>";

			    


			    //Display Research fields if available
			    echo "<div class='result_box' >"; 
			    echo "<p> <label> <b> Research Fields :</b></label>";
			   // echo $row['research_field'];
			   if ($row['research_field'] && $row['research_field'] != '[""]') {
			   		$research_list = json_decode($row['research_field'], true);
			   		if($research_list){
			   			echo "<ul>";
				   		foreach ($research_list as $key => $value) {
				   			echo "<li>". $value ."</li>";
				   		}
				   		echo "</ul>";	
			   		}
			   		else{
			   			echo '<label>' . $row['research_field'] . '</label></p>';	
			   		}
			   		
			   }	
			   else
			   		echo '<label>NOT AVALABLE</label></p>';	


			    echo "</div>";
			    echo "<hr /> ";
			    echo "</div>";
			    


			    //echo $row['qualifications'] . '<br />';
			    
			    //echo $row['publications'] . '<br />';

			    //echo $row['specialization'] . '<br />';

			    //Relevant Names
	
		  	}
		    
       	}
	}
/*
	function display_results_name($results)
	{
	    if (mysql_num_rows($results) == 0) 
	    { 
	     	echo  "<center id='no_result'>No results returned..!</center>";
        }
        else
        {
		    while($row = mysql_fetch_array($results))
		  	{
		  		echo '<div id="each_result" >';
		  		//Print Photo if available
			    echo "<div id='photo'>"; 
			    if($row['photo_href'] != "")
			    	echo "<img src='". $row['photo_href'] . "'></img>";
			    else
			    	echo "<img src='../images/default_photo.jpg'></img>";
			    echo "</div>";

			    //Display institute and department
			    //Display Designation if available
			    //Get designation from the lookup table
			    echo "<div class='result_box' id='personel_info'>"; 
			    echo '<p> <label><b> Name :</b></label><label>'. $row['faculty_name'] . '</label></p>';
			    echo '<p> <label><b> Institute :</b></label><label>'. Database::get_institute_name($row['institute_id']) . '</label></p>';
			    echo "<p><label><b> Department :</b></label>";
			    
			    if($row['dept_code'] != "")
			    	echo ' <label>'. Database::get_department_name($row['dept_code']) . '</label></p>';
			    else
			    	echo '<label>NOT AVALABLE</label></p>';	
			    
			    echo "<p><label><b> Designation :</b></label>";
			    if($row['designation'] != "")
			    	echo '<label>'. $row['designation'] . '</label></p>';
			    else
			    	echo '<label>NOT AVALABLE</label></p>';	

			    echo '<p> <label><b> Email :</b></label>
			    	<label><a href="mailto:'. $row['faculty_email'] . '" target="_blank">'. $row['faculty_email'] . '</a></label></p>';
			    if($row['faculty_page'] != "")
					echo '<p> <label><b> Faculty Page :</b></label>
						<label><a href="'. $row['faculty_page'] . '" target="_blank">'. $row['faculty_name'] . '</a></label></p>';
			    echo "</div>";


			    //Display Research fields if available
			    echo "<div class='result_box' >"; 
			    echo "<p> <label> <b> Research Fields :</b></label>";
			   // echo $row['research_field'];
			   if ($row['research_field'] != '[""]') {
			   		$research_list = json_decode($row['research_field'], true);
			   		echo "<ul>";
			   		foreach ($research_list as $key => $value) {
			   			echo "<li>". $value ."</li>";
			   		}
			   		echo "</ul>";
			   }	
			   else
			   		echo '<label>NOT AVALABLE</label></p>';	


			    echo "</div>";
			    echo "<hr /> ";
			    echo "</div>";
			    


			    //echo $row['qualifications'] . '<br />';
			    
			    //echo $row['publications'] . '<br />';

			    //echo $row['specialization'] . '<br />';

			    //Relevant Names
	
		  	}
		    
       	}
	}

	function display_results_research_area($results)
	{
	    if (mysql_num_rows($results) == 0) 
	    { 
	     	echo  "<center id='no_result'>No results returned..!</center>";
        }
        else
        {
		    while($row = mysql_fetch_array($results))
		  	{
		  		echo '<div id="each_result" >';
		  		//Print Photo if available
			    echo "<div id='photo'>"; 
			    if($row['photo_href'] != "")
			    	echo "<img src='". $row['photo_href'] . "'></img>";
			    else
			    	echo "<img src='../images/default_photo.jpg'></img>";
			    echo "</div>";

			    //Display institute and department
			    //Display Designation if available
			    //Get designation from the lookup table
			    echo "<div class='result_box' id='personel_info'>"; 
			    echo '<p> <label><b> Name :</b></label><label>'. $row['faculty_name'] . '</label></p>';
			    echo '<p> <label><b> Institute :</b></label><label>'. Database::get_institute_name($row['institute_id']) . '</label></p>';
			    echo "<p><label><b> Department :</b></label>";
			    
			    if($row['dept_code'] != "")
			    	echo ' <label>'. Database::get_department_name($row['dept_code']) . '</label></p>';
			    else
			    	echo '<label>NOT AVALABLE</label></p>';	
			    
			    echo "<p><label><b> Designation :</b></label>";
			    if($row['designation'] != "")
			    	echo '<label>'. $row['designation'] . '</label></p>';
			    else
			    	echo '<label>NOT AVALABLE</label></p>';	

			    echo '<p> <label><b> Email :</b></label>
			    	<label><a href="mailto:'. $row['faculty_email'] . '" target="_blank">'. $row['faculty_email'] . '</a></label></p>';
			    if($row['faculty_page'] != "")
					echo '<p> <label><b> Faculty Page :</b></label>
						<label><a href="'. $row['faculty_page'] . '" target="_blank">'. $row['faculty_name'] . '</a></label></p>';
			    echo "</div>";

			    


			    //Display Research fields if available
			    echo "<div class='result_box' >"; 
			    echo "<p> <label> <b> Research Fields :</b></label>";
			   // echo $row['research_field'];
			   if ($row['research_field'] != '[""]') {
			   		$research_list = json_decode($row['research_field'], true);
			   		echo "<ul>";
			   		if ($research_list) {
			   			foreach ($research_list as $key => $value) {
			   			echo "<li>". $value ."</li>";
			   		
			   			}
			   		}
			   		else
			   		{
			   			echo $row['research_field'] ;
			   		}

			   		echo "</ul>";
			   }	
			   else
			   		echo '<label>NOT AVALABLE</label></p>';	
			    echo "</div>";
				echo "<hr /> ";
				echo "</div>";
			    
			    


			    //echo $row['qualifications'] . '<br />';
			    
			    //echo $row['publications'] . '<br />';

			    //echo $row['specialization'] . '<br />';

			    //Relevant Names
	
		  	}

		    
       	}
	}
	*/
?>

