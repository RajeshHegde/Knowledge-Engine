<?php
/**
* All database related functions are defined in one file
*/
	/**
	* All database related interaction will be performed through Database methods
	*	@var Database
	*/
	class Database
	{
		/**
		* Default constructor for Database
		* @author Rajesh Hegde
		*/
		function __construct()
		{
			$connection = mysql_connect("localhost", "rajesh", "rajesh") or die ('Unable to connect!');
			$database = mysql_select_db("knowledge_engine") or die ('Unable to connect!');
		}

		/**
		* For Retreiving Institution name using institution ID
		* @static
		* @param Integer $institute_id Institution ID
		* @return String For valid institution ID,  returuns institution name, otherwise empty string
		*/
		public static function get_institute_name($institute_id)
		{
			$query = "SELECT institute_name FROM institute WHERE institute_id = " . $institute_id ;
			$result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			
			if (mysql_num_rows($result) == 0) 
	        { 
	        	return "";
	        }
	        else
	        {
	        	$row = mysql_fetch_array($result);
	      		return $row['institute_name'];
	        }

		}

		/**
		* For retreving Institution ID using Institution name
		* @static
		* @param String $institute_name Name of the Institute
		* @return String For valid institution Name,  returuns institution ID, otherwise empty string. Just reverse of get_institute_name()
		*/
		public static function get_institute_id($institute_name)
		{
			if($institute_name != ''){
				$query = "SELECT institute_id FROM institute WHERE institute_name LIKE '%" . $institute_name . "%'" ;
				$result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			}
			else{
				return "0";
			}
			if (mysql_num_rows($result) == 0) 
	        { 
	        	return "0";
	        }
	        else
	        {
	        	$row = mysql_fetch_array($result);
	      		return $row['institute_id'];
	        }

		}

		/**
		* Get Faculties matching the name
		* @static
		* @param String $search_text Search query
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculty deatails matching the query
		*/
		public static function get_names($search_text, $results_limit)
		{
			$query = "SELECT * FROM faculty WHERE faculty_name LIKE '".$search_text."%'" . " LIMIT " .$results_limit;
			//die($query);
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;

		}

		
		/**
		* Get the department name using department code
		* @static
		* @param String $dept_code Department code like ISE for Information Science and Engineering
		* @return String For valid department code,  returuns corresponding department name, otherwise empty string.
		*/
		public static function get_department_name($dept_code)
		{
			$query = "SELECT dept_name FROM department_lookup WHERE dept_code = '" . $dept_code . "'";
			$result = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			
			if (mysql_num_rows($result) == 0) 
	        { 
	        	return "";
	        }
	        else
	        {
	        	$row = mysql_fetch_array($result);
	      		return $row['dept_name'];
	        }

		}

		/**
		* Get Faculties matching the research area
		* @static
		* @param String $search_text Search query
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching Research area 
		*/
		public static function get_research_area($search_text, $results_limit){
			$query = "SELECT * FROM faculty WHERE research_field LIKE '%".$search_text."%'" . " LIMIT " .$results_limit;
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;
		}

		/**
		* Get Faculties matching the name and research area
		* @static
		* @param String $search_text_name Search query for name
		* @param String $search_text_research_area Search query for research area
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching both Name and Research area 
		*/
		public static function get_name_research_area($search_text_name, $search_text_research_area, $results_limit)
		{
			$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND research_field LIKE '%". $search_text_research_area ."%'" . " LIMIT " .$results_limit;
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;	
		}
		
		/**
		* Get Faculties matching the name and institute
		* @static
		* @param String $search_text_name Search query for name
		* @param String $search_text_institute Search query for institute name
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching both Name and Institute
		*/
		public static function get_name_institute($search_text_name, $search_text_institute, $results_limit)
		{
			$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND institute_id = " . Database::get_institute_id($search_text_institute) ." LIMIT " .$results_limit;
			//die($query);
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;
		}

		/**
		* Get Faculties matching the department
		* @static
		* @param String $search_text Search query for Department
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching department
		*/
		public static function get_department($search_text, $results_limit)
		{
			//$query = "SELECT * FROM faculty WHERE dept_code = '". $search_text ."' OR dept_code IN (SELECT dept_code FROM department_lookup WHERE dept_name LIKE '". $search_text ."%') LIMIT " .$results_limit;
			$query = "SELECT * FROM faculty WHERE dept_code = '". $search_text ."'  LIMIT " .$results_limit;
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;
		}

		/**
		* Get Faculties matching the name and department
		* @static
		* @param String $search_text_name Search query for name
		* @param String $search_text_department Search query for department name
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching both Name and Department
		*/
		public static function get_name_department($search_text_name, $search_text_department, $results_limit)
		{
			//$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND dept_code IN (SELECT dept_code FROM department_lookup WHERE dept_code = '". $search_text_department ."' OR dept_name LIKE '%". $search_text_department ."%') LIMIT " .$results_limit;
			//$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND (dept_code = '". $search_text_department ."' OR dept_code IN (SELECT dept_code FROM department_lookup WHERE dept_name LIKE '". $search_text_department ."%'))  LIMIT " .$results_limit;
			$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND dept_code = '". $search_text_department ."' LIMIT " .$results_limit;
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;
		}

		/**
		* Get Faculties matching the institute name
		* @static
		* @param String $search_text Search query for institute
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching institite
		*/
		public static function get_institute($search_text, $results_limit)
		{
			$query = "SELECT * FROM faculty WHERE institute_id = ". Database::get_institute_id($search_text) ." LIMIT " . $results_limit;
			//die($query);
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;
		}

		/**
		* Get Faculties matching the name, department and institute name
		* @static
		* @param String $search_text_name Search query for name
		* @param String $search_text_department Search query for department name
		* @param String $search_text_institute Search query for institute name
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching Name, Department and Institute
		*/
		public static function get_name_department_institute($search_text_name, $search_text_department, $search_text_institute, $results_limit){
			//$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND (dept_code = '". $search_text_department ."' OR dept_code IN (SELECT dept_code FROM department_lookup WHERE dept_name LIKE '". $search_text_department ."%')) AND institute_id = ". Database::get_institute_id($search_text_institute) ." LIMIT " .$results_limit;
			$query = "SELECT * FROM faculty WHERE faculty_name LIKE '%". $search_text_name ."%' AND dept_code = '". $search_text_department ."' AND institute_id = ". Database::get_institute_id($search_text_institute) ." LIMIT " .$results_limit;
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;
		}

		/**
		* Get Faculties matching the research area and institute name
		* @static
		* @param String $search_text_research_area Search query for research area
		* @param String $search_text_institute Search query for institute name
		* @param Integer $results_limit Limit for query results
		* @return mixed Returns Faculties Details matching both Research Area and Institute
		*/
		public static function get_research_area_institute($search_text_research_area, $search_text_institute, $results_limit){
			$query = "SELECT * FROM faculty WHERE research_field LIKE '%".$search_text_research_area."%' AND institute_id = " . Database::get_institute_id($search_text_institute) . " LIMIT " . $results_limit; 
	   		$results = mysql_query($query) or die ('Error in query: $query. ' . mysql_error());
			return $results;	
		}

	}
	
	$db = new Database();
?>