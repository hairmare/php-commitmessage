<?php

/**
 * analyse parts and fill handler stack
 */
class CommitMessage_Analyse
{
    private $_splitter = false;
    private $_handlerStack = false;
    public function setSplitter($splitter)
    {
        $this->_splitter = $splitter;
    }
    public function getSplitter()
    {
        return $this->_splitter;
    }
    public function setHandlerStack($handlerStack)
    {
        $handlerStack->setCaller($this);
        $this->_handlerStack = $handlerStack;
    }
    public function analyse()
    {
        if (!$this->_splitter) {
            throw new Exception('please set a splitter before calling analyse()');
        }
        if (!$this->_handlerStack) {
            throw new Exception('please set a handlerStack before calling analyse()');
        }
        $data = $this->_splitter->getData();
        $this->_analyseHead($data['head']);
        $this->_analyseBody($data['body']);
    }

    private function _analyseHead($head)
    {
        if (empty($head)) {
            throw new CommitMessage_Exception('no header found in commit message');
        }
    }
    private function _analyseBody($body)
    {
        if (empty($body)) {
            $this->_appendHandlerStack(
                new CommitMessage_Handler_WarnMissingText
            );
        }
        preg_match_all('/#[0-9]+/', $body, $matches);
        foreach ($matches[0] AS $match) {
            $issueId = substr($match, 1);

            $check = new CommitMessage_Handler_IssueCheck;
            $check->setIssueId($issueId);
            $this->_appendHandlerStack($check);

            $decorate = new CommitMessage_Handler_IssueDecorate;
            $decorate->setIssueId($issueId);
            $this->_appendHandlerStack($decorate);
        }
    }

    private function _appendHandlerStack($handler)
    {
        if (is_array($handler)) {
            foreach ($handler AS $this_handler) {
                $this->_appendHandlerStack($this_handler);
            }
        } else {
            $this->_handlerStack->append($handler);
        }
    }
}

