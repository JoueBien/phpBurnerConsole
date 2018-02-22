# php Burner Console (jbt/console)
A small console for php5/7 for logging and dumping into a browsers js console. This package has been designed to work with php Burner 5 however it can also be used as a standalone library for native PHP or your favourite php framework.

Note that this is beta software and is not considered 100% production ready. Previous versions of the console have been used in php Burner 4, however, all these systems have been decommissioned. This iteration of the console is still being tested in php Burner 5 (in active development) and has yet to be tested in Laravel 5_6/5_5/5_4. 

## Installation 
### php Burner 5
1. Add the package to your package.json
```composer require jbt/console```

2. In the www/index.php file add the following
```
use jbt\Console\Console as Console;

$app->use('console',Console::start());
```

### standard php
1. Add the package to your package.json
```composer require jbt/console```

2. include the composer autoloader by adding 
```
require_once ( './../vendor/autoload.php'); //include composer libs
```
to the top of you page

3. then import the namespace using
```
use jbt\Console\Console as Console;
```

4.  and finally, init the console Class
```
$console = Console::start());
```

## inti options
### Development and Production Modes
The development mode is turned on by default when you call 
```
Console::start();
```
to visually specify the development mode is on it is  recommended that you init the console using 
```
Console::start('dev');
```
Alternatively, if you want to disable the console for production than you can init the console using
```
Console::start('live');
```
This returns an empty class with empty members and thus will not log anything into the js console

## Use
### dumping vars to the js console
You can dump variables (arrays and objects) into the js console so that they are rendered as JSON object in the js console. To do this you use the `->dump(varToDump)` member function.
```
//php burner 5
$console = $app->getLib('console'); // get console var
$TestVar = array(); 
$console->dump($TestVar); //add a var to dump
$console->show(); //echo to page - should be the last thing you call in your php
```
```
//native & other
$console = Console::start();
$TestVar = array();
$console->dump($TestVar);
$console->show(); //echo to page - should be the last thing you call in your php
```

### logging a string or number
You can log strings or numbers to the js console by using the `->log(varToDump)` member function. Do not pass objects or arrays into the log funciton unless they have a toString meathod.
```
//php burner 5
$console = $app->getLib('console'); // get console var
$testStr = "testStr"; 
$testNum = "testNum";
//add a vars to log
$console->log($testStr); 
$console->log($testNum); 
$console->log("passing a string"."concat"); 
$console->log(10); 
$console->show(); //echo to page - should be the last thing you call in your php
```
```
//native & other
$console = Console::start();
$testStr = "testStr"; 
$testNum = "testNum";
//add a vars to log
$console->log($testStr); 
$console->log($testNum); 
$console->log("passing a string"."concat"); 
$console->log(10); 
$console->show(); //echo to page - should be the last thing you call in your php
```

### logging warnings
Sometimes you might need to log warnings - this is particularly true if your writing db or file managment code using native php. The member function 
`->warning ("message as a string", "function name", "class name", "the php warning and stack trace string");`
is used to log warnings to the browsers js console. 

```
public function db_MYSQL ($console,$host,$username,$password,$dbname){
    try {
    $database = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array( PDO::ATTR_PERSISTENT => false));
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->db=$database;
    return true;
    }catch (PDOException $e){
      $console->warning(
         " MySQL databse could not conected to $dbname.",
            "db_MYSQL('$host','$username','$password','$dbname')",
            "DatabaseConection",
            $e
       );
       return false;
    }
  }
```



