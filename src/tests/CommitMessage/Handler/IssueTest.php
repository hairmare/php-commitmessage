<?php

require_once 'src/CommitMessage/Handler/Issue.php';

class Concrete_CommitMessage_Handler_Issue
    extends CommitMessage_Handler_Issue
{
    /**
     * method fullfills interface demands and allows testing _initRedmine()
     */
    public function run()
    {
        $this->_initRedmine();
    }
}

/**
 * Test class for CommitMessage_Handler_Issue.
 * Generated by PHPUnit on 2011-10-26 at 21:53:10.
 */
class CommitMessage_Handler_IssueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Handler_Issue
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new Concrete_CommitMessage_Handler_Issue;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     */
    public function testGetSetIssueId()
    {
        $issueId = 1234;
        
        $this->_object->setIssueId($issueId);
        $this->assertEquals($issueId, $this->_object->getIssueId($issueId));
    }

    /**
     */
    public function testInitRedmine()
    {
        $factory = $this->getMock(
            'CommitMessage_Factory',
            array(
                'createHandler'
            )
        );
        $redmine = $this->getMock('Issue');
        $factory->expects($this->once())
                ->method('createHandler')
                ->with('Issue')
                ->will($this->returnValue($redmine));

        $this->_object->setFactory($factory);
        $this->_object->run();
    }

	public function testInitRedmineMissingFactory()
	{
		$this->setExpectedException('Exception');
		$this->_object->run();
	}
}
