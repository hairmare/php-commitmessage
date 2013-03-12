<?php
/* bootstrap
 *
 * gets stuff going and needs refactoring
 */

/* active resource gets include here so i can haz clean
 * coverge in builds. This should be in ActiveResource.php
 * and it will get removed when i do autoloading anyhow.
 */
require_once 'lib/phpactiveresource/ActiveResource.php';

/* these are my own working, they to need autoloading
 */
require_once __DIR__.'/../src/CommitMessage/Split.php';
require_once __DIR__.'/../src/CommitMessage/Analyse.php';
require_once __DIR__.'/../src/CommitMessage/Factory.php';
require_once __DIR__.'/../src/CommitMessage/HandlerStack.php';
require_once __DIR__.'/../src/CommitMessage/Handler/Issue.php';
require_once __DIR__.'/../src/CommitMessage/Handler/IssueCheck.php';
require_once __DIR__.'/../src/CommitMessage/Handler/IssueDecorate.php';
require_once __DIR__.'/../src/CommitMessage/Handler/IssueChangeStatus.php';
