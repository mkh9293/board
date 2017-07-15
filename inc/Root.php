<?php
    class Root{
        public function __construct()
        {
            spl_autoload_register('Root::class_autoLoader');
            require_once ('config.php');
            require_once ('Log.php');


            if(!isset($_GET['url'])){
                require_once ('./controllers/BoardController.php');
                $this->class = new BoardController();
                $this->class->getBoardMain();
                return;
            }

            $action = $_GET['url'];
            $url = explode("/",$action);

            $class = ucFirst($url[0]).'Controller';
            $fileCheck = './controllers/'.$class.'.php';
            if(!file_exists($fileCheck)){
                require_once ('./views/common/notFound.php');
                return false;
            }

            $this->class = new $class();
            $this->method = ucfirst($url[0]);
            $this->method .= ucfirst($url[1]);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->class->{'post' . $this->method}();
//                self::callMethod($url[1],'post');
            } else {
                $this->class->{'get' . $this->method}();
//                self::callMethod($url[1],'get');
            }

        }

//        private function checkMethod($url){
//            $method = ucFirst($url[0]).ucFirst($url[1]);
//            if(!method_exists($this->class,'get'.$method) && !method_exists($this->class,'post'.$method)){
//                $this->error->getError();
//                return false;
//            }
//            return true;
//        }

        private function class_autoLoader($class){
            include $controller = './controllers/'.$class.'.php';
        }

//        private function callMethod($action,$type){
//            switch($action){
//                case 'add':
//                    $this->class->{$type.'BoardAdd'}();
//                    break;
//                case 'list':
//                    $this->class->{$type.'BoardList'}();
//                    break;
//                case 'view':
//                    $this->class->{$type.'BoardView'}();
//                    break;
//                case 'delete':
//                    $this->class->{$type.'BoardDelete'}();
//                    break;
//                case 'reply':
//                    $this->class->{$type.'BoardReply'}();
//                    break;
//                case 'update':
//                    $this->class->{$type.'BoardUpdate'}();
//                    break;
//                case 'addComment':
//                    $this->class->{$type.'CommentAdd'}();
//                    break;
//                case 'fileDownload':
//                    $this->class->{$type.'DownloadFile'}();
//                    break;
//                default:
//                    $this->class->{$type.'BoardList'}();
//            }
//        }
    }
?>