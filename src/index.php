<?php
namespace jbt\Console;
/**
 * this class is the start moduel for the console
 * if in dev mode it will return a full console class
 * if in live mode it will deploy a dummy console that has empty functions
 * the Console::start('modeString') will init the console
 * the constructor is not used
 */
class Console {
    public static function start ($mode="dev"){
        if ($mode === "dev"){
            return new ConsoleDev();
        }
        if ($mode === "live"){
            return new ConsoleEmpty();
        }
    }
}

class ConsoleDev {
    private $lines = array('message'=>array(), 'function'=>array(), 'class'=>array(), 'phpWarning'=>array(), 'type'=>array());

    function __construct() {

    }

    public function dump($message){ //dumps a var into the console
        $this->lines['message'][] = str_replace('\\u0000', '->', json_encode ((array)$message)); //shows html string rahter than adding html to document.
        $this->lines['type'][] = 'dump';
        $this->lines['function'][] = '';
        $this->lines['class'][] = '';
        $this->lines['phpWarning'][] = '';
    }

    public function log ($message = ""){
        if (!is_array($message) && ! is_object($message)){
            $this->lines['message'][] = str_replace('`',"`+'`'+`",htmlspecialchars ($message)); //shows html string rahter than adding html to document.
            $this->lines['type'][] = 'defoult';
            $this->lines['function'][] = '';
            $this->lines['class'][] = '';
            $this->lines['phpWarning'][] = '';
        }else{
            $this->warning ("Can't log object or array. Use dump instead.", "log", "console");
        }

    }

    // public function logHTML ($message = ""){
    //     $this->lines['message'][] = $message;
    //     $this->lines['type'][] = 'defoult';
    // }

    public function warning ($message = "", $function = "", $class="", $phpWarning="Exception Not Caught"){
        $this->lines['message'][] = str_replace('`',"`+'`'+`",$message);
        $this->lines['type'][] = 'warning';
        $this->lines['function'][] = str_replace('`',"`+'`'+`",$function);
        $this->lines['class'][] = str_replace('`',"`+'`'+`",$class);
        $this->lines['phpWarning'][] = str_replace('`',"`+'`'+`",$phpWarning);
    }

    public function show (){
        echo "<script>";
        $messageCss = "display: block; color:orange; background:black; line-height: 20px;";
        $logCss = "display: block; color:white; background:black; line-height: 20px;";
        $dumpCSS = "display: block; color:black; background:white; line-height: 20px;";

        for ($i=0; $i<count($this->lines['message']); $i++){

                switch ($this->lines['type'][$i]){
                    case 'defoult':?> console.log(`%c <?php echo $i ?> log: <?php echo $this->lines['message'][$i];?>`, "<?php echo $logCss; ?>");<?php break;
                    case 'dump':?>
                        console.log("%c <?php echo $i ?> dump:","<?php echo  $dumpCSS; ?>");
                        console.log(<?php echo $this->lines['message'][$i];?>);

                        <?php break;
                    case 'warning': ?>console.log(`%c <?php echo $i ?> warning: <?php echo $this->lines['message'][$i]."\n"; ?>
<?php echo "  ->".$this->lines['function'][$i]."\n"; ?>
<?php echo "  ->".$this->lines['class'][$i]."\n"; ?>
<?php echo "  ->".$this->lines['phpWarning'][$i]; ?>
                    `, "<?php echo $messageCss; ?>");
                    <?php break;
                }


            }
            echo "</script>";
    }

    /*public function createController ($controllerName){
        $sucessfull = true;
        //set up new controller
            $controlerFM = new FileManager ("..");
            $controlerFM->folder_open("controllers");

            $viewFM = new FileManager ("..");
            $viewFM->folder_open("views");


            $controllerFileName = $controllerName.".c.php";
            $viewileName = $controllerName.".v.php";
        //create master controller
            $sucessfull = $controlerFM->new_file($controllerFileName);


            if ($sucessfull){
                //fill controller with defoult data
                $controlerFM->apend_line_to_file ($controllerFileName, "<?php");
                $controlerFM->apend_line_to_file ($controllerFileName, "");
                $controlerFM->apend_line_to_file ($controllerFileName, '$pageTitle = "'.$controllerName.'";');
                $controlerFM->apend_line_to_file ($controllerFileName, '$view->title( $pageTitle);');
                $controlerFM->apend_line_to_file ($controllerFileName, "");
                $controlerFM->apend_line_to_file ($controllerFileName, '$view->addView("'.$controllerName.'");');
                $controlerFM->apend_line_to_file ($controllerFileName, "");
                $controlerFM->apend_line_to_file ($controllerFileName, '$view->flush();');
                $controlerFM->apend_line_to_file ($controllerFileName, "");
                $controlerFM->apend_line_to_file ($controllerFileName, "?>");

            //set up mutators
                $controlerFM->create_folder("$controllerName-mutators");
                $controlerFM->folder_open("$controllerName-mutators");

            //create new mutators
                $sucessfull = $controlerFM->new_file("create.c.php");
                $sucessfull = $controlerFM->new_file("drop.c.php");
                $sucessfull = $controlerFM->new_file("get.c.php");
                $sucessfull = $controlerFM->new_file("read.c.php");
                $sucessfull = $controlerFM->new_file("update.c.php");

            //set up view
                $viewFM->new_file($viewileName);
                $viewFM->apend_line_to_file ($viewileName, ":)");

            }else{
                $this->warning (
                    "Could not create controller '$controllerName'. Controller may allready exist.",
                    "createController ($controllerName)",
                    "Console"
                );
            }

    }*/
}


class ConsoleEmpty {
    function __construct() {}
    public function log ($message = ""){}
    public function warning ($message = "", $function = "", $class="", $phpWarning="Exception Not Caught"){}
    public function show(){}
    public function dump($message){}
}

//$test = Console::start();
?>
