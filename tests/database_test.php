<?php

require_once('../lib/database.php');
/**
* Test Database related functions
* @author Rajesh Hegde
*/
class DatabaseConnectionTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }
  /**
  * Test the database connection
  */
  public function testConnectionIsValid()
  {
    
   $db = new Database();
   $this->assertTrue($db != NULL);
  }

  /**
  * Test the get_institute_name function
  */
  public function testGetInstituteName()
  {

  	$this->assertTrue(Database::get_institute_name('1') == "Indian Institute of Technology Madras");
  }

  /**
  * Test the get_institute_id function
  */
  public function testGetInstituteID()
  {

  	$this->assertTrue(Database::get_institute_id("Indian Institute of Technology Madras") == "1");
  }

  /**
  * Test the get_department_name function
  */
  public function testGetDepartmentName()
  {

  	$this->assertTrue(Database::get_department_name('AE') == "Aerospace Engineering");
  }

}
?>