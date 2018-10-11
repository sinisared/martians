<?php
spl_autoload_register(function ($class) { include  $class . '.php'; });

if (sizeof($argv) == 1) {
    die("Syntax: php " . $argv[0] . " <filename>\n");
}

$file = file($argv[1]);
$init = trim(array_shift($file));
$field = explode(' ', $init);
$game = new \RobotGame($field[0], $field[1]);
while ($robotInit = trim(array_shift($file))) {

    /**
     *  parsing command and space line
     */
    $robotCommands = trim(array_shift($file));
    $filler = trim(array_shift($file));
    $robotStart = explode(' ', $robotInit);


    $robot = new \Robot($robotStart);
    try {
    $game->moveRobot($robot, $robotCommands);
    } catch (Exception $e) {
        echo sprintf("input: init: %s, command(s): %s\n",$robotInit,$robotCommands);
        echo sprintf("Error processing file: (%s) %s\n",$e->getCode(),$e->getMessage());
        continue;
    }
    echo sprintf("input: init: %s, command(s): %s\n",$robotInit,$robotCommands);
    echo $robot->printResult();
}
