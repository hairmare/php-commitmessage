<?php

/**
 * allows us to create heaps of handlers
 */
class CommitMessage_Factory
{
    public function create($classname)
    {
        return new $classname;
    }
}
