<?php
    class Root{
        public function __construct()
        {
            require_once ('config.php');
            require_once (BASE_CONT);
            require_once ('Log.php');

            $this->board = new BoardController();
            $action = $_GET['url'];

            if($_SERVER['REQUEST_METHOD']=='POST'){
                self::callMethod($action,'post');
            }else{
                self::callMethod($action,'get');
            }
        }


        function callMethod($action,$type){
            switch($action){
                case 'add':
                    $this->board->{$type.'BoardAdd'}();
                    break;
                case 'list':
                    $this->board->{$type.'BoardList'}();
                    break;
                case 'view':
                    $this->board->{$type.'BoardView'}();
                    break;
                case 'delete':
                    $this->board->{$type.'BoardDelete'}();
                    break;
                case 'reply':
                    $this->board->{$type.'BoardReply'}();
                    break;
                case 'update':
                    $this->board->{$type.'BoardUpdate'}();
                    break;
                case 'addComment':
                    $this->board->{$type.'CommentAdd'}();
                    break;
                case 'fileDownload':
                    $this->board->{$type.'DownloadFile'}();
                    break;
            }
        }
    }
?>