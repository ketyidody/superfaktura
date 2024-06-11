<?php

use Task3\Task3Cli;
use Task3\Task3Web;

include_once 'Task3/Task3Cli.php';
include_once('task3/Task3Web.php');

const PHP_TAB = "\t";

$url = 'https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/';

if (isCommandLineInterface()) {
    $task = new Task3Cli($url);
} else {
    $task = new Task3Web($url);
}

echo $task->handle();

function isCommandLineInterface()
{
    return (php_sapi_name() === 'cli');
}