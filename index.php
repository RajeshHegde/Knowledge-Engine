<!DOCTYPE HTML>
<html>
	<head>
		<title>Knowledge Base Search Engine</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
<!--		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
	</head>
	<body >
		<div class="containers" id="search_form">
			<form method="POST" action="lib/process.php"  >
				<h1 id="heading"> Knowledge Based Search Engine  </h1>
				<!-- <fieldset id="search_select_field" class="border">
					<label>Search critiria :</label>
					<select name="critiria">
						<option value="name">Name</option>
						<option value="name_research_area">Name Research Area</option>
						<option value="name_institute">Name Institute</option>
						<option value="name_department">Name Department</option>
						<option value="name_department_institute">Name Department Institute </option>
						<option value="research_area">Research Area</option>
						<option value="research_area_institute">Research Area Institute</option>
						<option value="institute">Institute</option>
						<option value="department">Department</option>
					</select>
					<label> Results Limit :</label>
					<input name="results_limit" value="01" size="4">
				</fieldset>
 -->
				<fieldset id="search_field">
					<input name="searchbox" id="search_bar" maxlength="200" type="text" autocapitalize="off" autocomplete="off"  required>
					<input id="submit_button" type="submit" value="Search">
				</fieldset>

				<!-- <label id="info_label">**Use AND to search for more than one criteria</label> -->
			<!--	<a href=""><label id="advance_search_label" onclick="advanced_search(true)">Advanced Search</label></a>
				<div id="advanced_search"> -->
					
				</div>
			</form>
		</div>
	</body>
</html>