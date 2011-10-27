<?php

require_once 'src/CommitMessage/Handler/WarnMissingText.php';

/**
 * analyse parts and fill handler stack
 */
class CommitMessage_Analyse
{
    private $_splitter = false;
    private $_handlerStack = false;
    private $_handlerFactory = false;
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
    public function setFactory($handlerFactory)
    {
        $this->_handlerFactory = $handlerFactory;
    }
    public function analyse()
    {
        if (!$this->_splitter) {
            throw new Exception(
                'please set a splitter before calling analyse()'
            );
        }
        if (!$this->_handlerStack) {
            throw new Exception(
                'please set a handlerStack before calling analyse()'
            );
        }
        if (!$this->_handlerFactory) {
            throw new Exception(
                'please set a handlerFactory before calling analyse()'
            );
        }
        $data = $this->_splitter->getData();
        $this->_analyseHead($data['head']);
        $this->_analyseBody($data['body']);
    }

    private function _analyseHead($head)
    {
        if (empty($head)) {
            $this->_appendHandlerStack(
                $this->_handlerFactory->create(
                    'CommitMessage_Handler_WarnMissingText'
                )
            );
        }
    }
    private function _analyseBody($body)
    {
        if (empty($body)) {
            $this->_appendHandlerStack(
                $this->_handlerFactory->create(
                    'CommitMessage_Handler_WarnMissingText'
                )
            );
        }
        preg_match_all('/#[0-9]+/', $body, $matches);
        foreach ($matches[0] AS $match) {
            $issueId = substr($match, 1);

            $check = $this->_handlerFactory->create(
                'CommitMessage_Handler_IssueCheck'
            );
            $check->setIssueId($issueId);
            $check->setFactory($this->_handlerFactory);

            $decorate = $this->_handlerFactory->create(
                'CommitMessage_Handler_IssueDecorate'
            );
            $decorate->setIssueId($issueId);
            $decorate->setFactory($this->_handlerFactory);

            $this->_appendHandlerStack(
                array(
                    $check,
                    $decorate
                )
            );
        }
    }

    private function _appendHandlerStack($handler)
    {
        if (is_array($handler)) {
            foreach ($handler AS $thisHandler) {
                $this->_appendHandlerStack($thisHandler);
            }
        } else {
            $this->_handlerStack->append($handler);
        }
    }
}

