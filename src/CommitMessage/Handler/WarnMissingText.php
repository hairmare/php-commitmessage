<?php

require_once 'src/CommitMessage/Handler/Abstract.php';

class CommitMessage_Handler_WarnMissingText
    extends CommitMessage_Handler_Abstract
{
    public function run()
    {
        throw new RuntimeException('missing test');
    }
}
