<?php

require_once('../lib/process.php');
/**



*/
class ProcessTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }

  function testProcessName()
  {
    $this->assertTrue(process_name('name', 'rajesh',  1));
  }


}
?>