<?php

require_once 'src/CommitMessage/Factory.php';

/**
 * Test class for CommitMessage_Factory.
 * Generated by PHPUnit on 2011-10-26 at 19:40:11.
 */
class CommitMessage_FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Factory
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_Factory;
    }

    /**
     * check factory method
     */
    public function testCreate()
    {
        $this->assertInstanceOf(
            'stdClass', 
            $this->_object->create(
                'stdClass'
            )
        );
    }
}
