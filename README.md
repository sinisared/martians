# Martian Robots
Used programing language was PHP version >= 7.1.
There are no framework used for running but you need phpunit installed to run tests. 
Supplied composer configuration will install it.

## Structure
* src/ - contains app code and classes
* tests/ - contains unit tests
* data/ - contains test data files
* src/index.php is the app
* run_valid.sh
* run_invalid.sh
* run_tests.sh

## Classes
* Robot - holds robot state
* RobotGame - holds Mars exploration state and game logic, could be refactored into two separate classes

## Running

run from root directory calling run_valid.sh or run_invalid.sh
alternatively call manually:
  
  php src/index.php data/test.txt

## Testing
Use composer install to install phpunit into the project. after install run provided run_tests.sh script.

## Sample outputs
### test_valid.txt command file
```
vagrant@homestead:~/test$ sh run_valid.sh 
input: init: 1 1 E, command(s): RFRFRFRF
1 1 E 
input: init: 3 2 N, command(s): FRRFLLFFRRFL
3 3 N LOST
input: init: 0 3 W, command(s): LLFFFLFLFL
2 3 S 
input: init: 3 2 N, command(s): FRRFLLFFRRFL
3 2 E 
```

### test_invalid.txt command file
```
vagrant@homestead:~/test$ sh run_invalid.sh 
input: init: 1 1 E, command(s): RFRAFRFRF
Error processing file: (1) Unknown command A
input: init: 3 2 N, command(s): FRRFBLLFFRRFL
Error processing file: (1) Unknown command B
input: init: 0 3 W, command(s): LLWFFFLFLFL
Error processing file: (1) Unknown command W
input: init: 3 2 N, command(s): FRRFLLFFRCRFL
3 3 N LOST
```
### phpunit test result
```
vagrant@homestead:~/test$ sh run_tests.sh 
PHPUnit 7.4.0 by Sebastian Bergmann and contributors.

RobotGame
 ✔ Instantiate new game
 ✔ Robot turn right
 ✔ Robot turn left
 ✔ Robot move forward
 ✔ Robot move forward north single command
 ✔ Robot move forward east single command
 ✔ Second robot move forward east single command
 ✔ Second robot move forward north single command
 ✔ Third robot move forward north turn east turn north forward get lost single command

Robot
 ✔ Instantiate new robot
 ✔ Robot set lost
 ✔ Robot get pos
 ✔ Robot set x
 ✔ Robot set y
 ✔ Robot get orientation

Time: 62 ms, Memory: 4.00MB

OK (15 tests, 74 assertions)
```
