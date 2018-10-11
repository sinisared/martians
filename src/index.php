<?php
spl_autoload_register(function ($class) { include  $class . '.php'; });

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
    $game->moveRobot($robot, $robotCommands);
    echo "input: init $robotInit, command $robotCommands\n";
    echo $robot->printResult();
}