<?php

require_once 'src/CommitMessage/Handler/Abstract.php';

/**
 * stub class for testing abstract class
 */
class Concrete_CommitMessage_Handler_Abstract 
    extends CommitMessage_Handler_Abstract
{
    public function run()
    {
    }
}

/**
 * Test class for CommitMessage_Handler_Abstract.
 * Generated by PHPUnit on 2011-10-26 at 19:00:47.
 */
class CommitMessage_Handler_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Handler_Abstract
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new Concrete_CommitMessage_Handler_Abstract;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testSetCaller().
     */
    public function testGetSetCaller()
    {
        $caller = $this->getMock('CommitMessage_HandlerStack');

        $this->_object->setCaller($caller);
        $this->assertSame($caller, $this->_object->getCaller());
    }

    public function testSetCallerOnlyOnce()
    {
        $caller = $this->getMock('CommitMessage_HandlerStack');

        $this->setExpectedException('Exception');
        $this->_object->setCaller($caller);
        $this->_object->setCaller($caller);
    }
}
