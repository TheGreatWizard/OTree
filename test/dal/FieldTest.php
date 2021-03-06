<?php

namespace DAL;

/**
 * Test class for Field.
 * Generated by PHPUnit on 2015-06-26 at 18:35:39.
 */
class FieldTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Field
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testFieldName()
    {
        $testfield = new \DAL\Field('testfield', 'INT', '');
        $this->assertEquals('testfield', $testfield->getName());
    }

    public function testFieldTypeINT()
    {
        $testfield = new \DAL\Field('testfield', 'INT', '');
        $this->assertEquals('INT', $testfield->getType());
    }

    public function testFieldTypeBadINT()
    {
        $this->setExpectedException('Exception');
        $testfield = new \DAL\Field('testfield', 'BadINT', '');

        //@todo $this->assertEquals("Field type is not recognized", $e->getMessage());
    }

    public function testFieldBadName()
    {
        $this->setExpectedException('Exception');
        $testfield = new \DAL\Field('bad<', 'INT', '');
        //@todo:    		$this->assertEquals("Bad field name. Field name can contain only english letters & digits",$e->getMessage());
    }

    public function testFieldTypeValueVARCHAR30()
    {
        $testfield = new \DAL\Field('testfield', 'VARCHAR', '30');
        $this->assertEquals('VARCHAR(30)', $testfield->getType());
    }

    public function testFieldTypeVARCHAR30()
    {
        $testfield = new \DAL\Field('testfield', 'VARCHAR(30)', '');
        $this->assertEquals('VARCHAR(30)', $testfield->getType());
    }

    public function testFieldTypeID()
    {
        $testfield = new \DAL\Field('ID', 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', '');
        $this->assertEquals('INT(6) UNSIGNED', $testfield->getType());
        $this->assertEquals(true, $testfield->getAutoIncrement());
        $this->assertEquals(true, $testfield->getPrimaryKey());
    }

    public function testFieldTypeTEXT()
    {
        $testfield = new \DAL\Field('MyTxt', 'TEXT', 256);
        $this->assertEquals('TEXT(256)', $testfield->getType());
    }

    public function testFieldTypeIDGetSQL()
    {
        $testfield = new \DAL\Field('ID', 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY', '');
        $this->assertEquals('ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL', $testfield->getSQL());
    }

    public function testFieldTypeNOTNULL()
    {
        $testfield = new \DAL\Field('Name', 'VARCHAR(30) NOT NULL', '');
        $this->assertEquals('VARCHAR(30)', $testfield->getType());
        $this->assertEquals(false, $testfield->getNull());
    }

    public function testsetFromMysqlDesc()
    {
        $correct_field = new \DAL\Field('id', 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY');

        //echo ">>1>>".$correct_field->invalid;

        $arrMysqlDesc = array('Field' => "id",
            'Type' => "int(6) unsigned",
            'Null' => "NO",
            'Key' => "PRI",
            'Default' => null,
            'Extra' => "auto_increment");

        $testfield = new \DAL\Field();
        //echo ">>2>>".$testfield->invalid;
        $testfield->setFromMysqlDesc($arrMysqlDesc);

        $Comp = \Manager\Comparer::getInstance();
        $this->assertTrue($Comp->areEqual($correct_field, $testfield));
    }

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testextractValuesFromStringOnevalue()
    {
        $str = "BIGINT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY";
        $testfield = new \DAL\Field();
        $values = $this->invokeMethod($testfield, "extractValuesFromString", array($str));
        $this->assertEquals(1, count($values));
        $this->assertEquals(6, $values[0]);
    }

    public function testextractValuesFromStringTwovalues()
    {
        $str = "DOUBLE(5,3) ZEFOFILL UNSIGNED";
        $testfield = new \DAL\Field();
        $values = $this->invokeMethod($testfield, "extractValuesFromString", array($str));
        print_r($values);
        $this->assertEquals(2, count($values));
        $this->assertEquals(5, $values[0]);
        $this->assertEquals(3, $values[1]);
    }

    public function testFieldTypeDOUBLEtwovalues()
    {
        $testfield = new \DAL\Field('Name', 'DOUBLE(7,3) ZEROFILL', '');
        $this->assertEquals('DOUBLE(7,3) ZEROFILL UNSIGNED', $testfield->getType());
    }
}
