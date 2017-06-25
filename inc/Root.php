<?php
    class Root{
        public function __construct()
        {
            spl_autoload_register('Root::class_autoLoader');
            require_once ('config.php');
            require_once ('Log.php');
            $this->error = new ErrorController();

            $action = $_GET['url'];
            $url = explode("/",$action);
//            if(empty($url[0]) || empty($url[1])){
//                require_once ('./controllers/BoardController.php');
//                $this->class = new BoardController();
//                $this->class->getBoardList();
//                return;
//            }

            $class = ucFirst($url[0]).'Controller';
            $fileCheck = './controllers/'.$class.'.php';
            if(!file_exists($fileCheck)){
                $this->error->getError();
                return false;
            }

            $this->class = new $class();
            $this->method = ucfirst($url[0]);
            $this->method .= ucfirst($url[1]);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//                $this->class->{'post' . $this->method}();
                self::callMethod($url[1],'post');
            } else {
//                $this->class->{'get' . $this->method}();
                self::callMethod($url[1],'get');
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

        private function callMethod($action,$type){
            switch($action){
                case 'add':
                    $this->class->{$type.'BoardAdd'}();
                    break;
                case 'list':
                    $this->class->{$type.'BoardList'}();
                    break;
                case 'view':
                    $this->class->{$type.'BoardView'}();
                    break;
                case 'delete':
                    $this->class->{$type.'BoardDelete'}();
                    break;
                case 'reply':
                    $this->class->{$type.'BoardReply'}();
                    break;
                case 'update':
                    $this->class->{$type.'BoardUpdate'}();
                    break;
                case 'addComment':
                    $this->class->{$type.'CommentAdd'}();
                    break;
                case 'fileDownload':
                    $this->class->{$type.'DownloadFile'}();
                    break;
                default:
                    $this->class->{$type.'BoardList'}();
            }
        }
    }
?>