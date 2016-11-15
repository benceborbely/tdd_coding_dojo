<?php

require_once 'vendor/autoload.php';

$curl = new \Util\Curl();
$converter = new \Util\JsonToArrayConverter();
$firstQuestionIdParser = new \Parser\FirstQuestionIdParser();
$userIdsParser = new \Parser\UserIdsParser();

$repository = new \Repository\ApiQuestionRepository($curl, $converter, $firstQuestionIdParser, $userIdsParser);

$application = new Application($repository);

$userIds = $application->run();

foreach ($userIds as $id) {
    echo $id . '<br/>';
}
