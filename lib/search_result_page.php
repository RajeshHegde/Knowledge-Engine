<?php
/**
* Desplay the search results properly
*/

	/**
	* Display the result head portion on the web page
	* @param String $critiria Search Critiria 
	* @param String $search_query Search text
	* @param Integer $results_limit Limit for query results
	*/
	function display_results_head($search_query, $results_limit){
		?>
		<!DOCTYPE HTML>
		<html>
			<head>
				<title>Knowledge Base Search Engine</title>
				<link rel="stylesheet" type="text/css" href="../css/main.css">
				<script src="../js/main.js"> </script>
				<script src="../js/jquery.min.js"> </script>
			</head>
			
			<body >
			<div id="result_page_search" class="containers"> 
				<form method="POST" action="process.php">
					<h1 id="heading"> Knowledge Based Search Engine  </h1>
					<fieldset id="result_page_search_field">
						<input name="searchbox" id="result_page_search_bar" maxlength="200" type="text" autocapitalize="off" autocomplete="off" value="<?php echo $search_query ?>">
						<input id="submit_button" type="submit" value="Search">
					</fieldset>
			
				</form>
			</div>
			<section id="answer" class="containers">
<?php
	}


	/**
	* Display the result end portion on the web page
	*/
	function display_results_end(){
?>
			</section>
<!-- 				<footer id="foot" class="containers">
					<label>Copyright@RClouds Technologies Pvt. Ltd. </label>
				</footer> -->	
			</body>
		</html>
<?php
	}
	/**
	* Display the results into each faculty box fashion
	* @param mixed $results Query result from database
	*/
	function display_results($response)
	{
	    if ($response['numFound'] == 0) 
	    { 
	     	echo  "<center id='no_result'>No results returned..!</center>";
        }
        else
        {
		    foreach ($response['docs'] as $row) {
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
			    echo '<p> <label class="labels"><b> Name :</b></label><label class="value_labels">'. $row['faculty_name'] . '</label></p>';
			    echo '<p> <label class="labels"><b> Institute :</b></label><label class="value_labels">'. $row['institute_name'] . '</label></p>';
			    echo '<p><label class="labels"><b> Department :</b></label>';
			    
			    if($row['dept_code'] != "")
			    	echo ' <label class="value_labels">'. $row['dept_code'] . '</label></p>';
			    else
			    	echo '<label class="value_labels">NOT AVALABLE</label></p>';	
			    
			    echo '<p><label class="labels"><b> Designation :</b></label>';
			    if($row['designation'] != "")
			    	echo '<label class="value_labels">'. $row['designation'] . '</label></p>';
			    else
			    	echo '<label class="value_labels">NOT AVALABLE</label></p>';	

			    echo '<p> <label  class="labels"><b> Email :</b></label>
			    	<label><a href="mailto:'. $row['faculty_email'] . '" target="_blank">'. $row['faculty_email'] . '</a></label></p>';
			    if($row['faculty_page'] != "")
					echo '<p> <label class="labels"><b> Faculty Page :</b></label>
						<label><a href="'. $row['faculty_page'] . '" target="_blank">'. $row['faculty_name'] . '</a></label></p>';
			    echo "</div>";

			    


			    //Display Research fields if available
			    echo "<div class='result_box' >"; 
			    echo "<p> <label class='research_field_label'> <b> Research Fields :</b></label>";
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

