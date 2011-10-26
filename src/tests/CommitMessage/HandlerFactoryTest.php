<?php

require_once 'src/CommitMessage/HandlerFactory.php';

/**
 * Test class for CommitMessage_HandlerFactory.
 * Generated by PHPUnit on 2011-10-26 at 19:40:11.
 */
class CommitMessage_HandlerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_HandlerFactory
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_HandlerFactory;
    }

    /**
     * check factory method
     */
    public function testCreateHandler()
    {
        $this->assertInstanceOf(
            'stdClass', 
            $this->_object->createHandler(
                'stdClass'
            )
        );
    }
}
