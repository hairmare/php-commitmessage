<?php

require_once 'src/CommitMessage/Analyse.php';

/**
 * Test class for CommitMessage_Analyse.
 * Generated by PHPUnit on 2011-10-26 at 17:25:50.
 */
class CommitMessage_AnalyseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Analyse
     */
    protected $_object;

    protected $_handlerFactory = false;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_Analyse;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->_handlerFactory = false;
    }

    private function _initAnalyseForHandlerStack($head, $body)
    {
        $splitter = $this->getMock(
            'CommitMessage_Splitter',
            array(
                'getData'
            )
        );

        $returnValue = $this->returnValue(
            array(
                'head' => $head,
                'body'=>$body
            )
        );
        $splitter->expects($this->once())
                 ->method('getData')
                 ->will($returnValue);

        $handlerStack = $this->getMock(
            'CommitMessage_HandlerStack',
            array(
                'setCaller',
                'append'
            )
        );

        $this->_handlerFactory = $this->getMock(
            'CommitMessage_Factory'
        );

   
        $this->_object->setSplitter($splitter);
        $this->_object->setFactory($this->_handlerFactory);
        $this->_object->setHandlerStack($handlerStack);

        return $handlerStack;
    }

    /**
     * test getting and setting of splitter
     */
    public function testGetSetSplitter()
    {
        $splitter = $this->getMock(
            'CommitMessage_Splitter'
        );

        $this->_object->setSplitter($splitter);
        $this->assertSame($splitter, $this->_object->getSplitter());
    }

    /**
     * check for working caller relation in setter
     */
    public function testSetHandlerStack()
    {
        $handlerStack = $this->getMock(
            'CommitMessage_HandlerStack',
            array('setCaller')
        );
        $handlerStack->expects($this->once())
                     ->method('setCaller')
                     ->with($this->isInstanceOf($this->_object));

        $this->_object->setHandlerStack($handlerStack);
    }

    /**
     * test missing splitter
     */
    public function testAnalyseMissingSplitter()
    {
        $this->setExpectedException('Exception');
        $this->_object->analyse();
    }

    /**
     * test missing handler stack
     */
    public function testAnalyseMissingHandlerStack()
    {
        $this->setExpectedException('Exception');
        $this->_object->setSplitter($this->getMock('CommitMessage_Splitter'));
        $this->_object->analyse();
    }

    /**
     * test missing handler factory
     */
    public function testAnalyseMissingFactory()
    {
        $this->setExpectedException('Exception');
        $this->_object->setSplitter($this->getMock('CommitMessage_Splitter'));
        $this->_object->setHandlerStack(
            $this->getMock(
                'CommitMessage_HandlerStack',
                array(
                    'setCaller'
                )
            )
        );
        $this->_object->analyse();
    }
    /**
     * check for missing head error
     */
    public function testAnalyseMissingHead()
    {
        $handlerStack = $this->_initAnalyseForHandlerStack('', 'body');

        $returnValue = $this->returnValue(
            $this->getMock(
                'CommitMessage_Handler_WarnMissingText'
            )
        );
        $this->_handlerFactory->expects($this->once())
                              ->method('create')
                              ->will($returnValue);

        $isInstanceOf = $this->isInstanceOf(
            'CommitMessage_Handler_WarnMissingText'
        );
        $handlerStack->expects($this->once())
                     ->method('append')
                     ->with($isInstanceOf);
    
        $this->_object->analyse();
    }

    public function testAnalyseMissingBody()
    {
        $handlerStack = $this->_initAnalyseForHandlerStack('head', '');

        $returnValue = $this->returnValue(
            $this->getMock(
                'CommitMessage_Handler_WarnMissingText'
            )
        );
        $this->_handlerFactory->expects($this->once())
                              ->method('create')
                              ->will($returnValue);

        $isInstanceOf = $this->isInstanceOf(
            'CommitMessage_Handler_WarnMissingText'
        );
        $handlerStack->expects($this->once())
                     ->method('append')
                     ->with($isInstanceOf);
    
        $this->_object->analyse();
    }

    public function testAnalyseWithIssueBody()
    {
        $handlerStack = $this->_initAnalyseForHandlerStack(
            'head',
            'body text with issue #1'
        );

        $issuecheck = $this->getMock(
            'CommitMessage_Handler_IssueCheck',
            array(
                'setIssueId',
                'setFactory'
            )
        );
        $issuecheck->expects($this->once())
                   ->method('setIssueId')
                   ->with(1);
        $issuecheck->expects($this->once())
                   ->method('setFactory');

        $issuedecorate = $this->getMock(
            'CommitMessage_Handler_IssueDecorate',
            array(
                'setIssueId',
                'setFactory'
            )
        );
        $issuedecorate->expects($this->once())
                      ->method('setIssueId')
                      ->with(1);
        $issuedecorate->expects($this->once())
                      ->method('setFactory');

        $onConsecutiveCalls = $this->onConsecutiveCalls(
            $issuecheck,
            $issuedecorate
        );
        $this->_handlerFactory->expects($this->any())
                              ->method('create')
                              ->will($onConsecutiveCalls);

        $handlerStack->expects($this->exactly(2))
                     ->method('append');

        $this->_object->analyse();
    }
}
