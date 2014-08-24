Knowledge-Engine
================

A Knowledge Based Search engine specifically for searching faculty information.

##Features:
* Search by Faculty Name
* Search by Designation
* Search by Department
* Search by Institute
* Search by combination of above. i.e., Department and Institute, Designation and Institute etc.

##Setup
* Download the code from github
* Setup lamp/wamp server
* Place the code in the www/ or public directory with read/write access.
* Download solr and replace conf files with conf/ files. i.e., data-config.xml, schema.xml, solrconfig.xml
* Create a database in mysql named knowledge_engine
* Change the database credentials in data-config.xml
* Run and index the solr.
* Access knowledge Engine portal at http://localhost/{path/from/publuc/directory/to/knowledge/enige/folder}

##Extractio Unit
* It is a eclipse project. Import this folder as eclipse project.
* Run it as python script.

