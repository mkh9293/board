<?php
    class ErrorController{
        function __construct()
        {
        }

        public function getError(){
            require_once ('./views/common/notFound.php');
            return false;
        }
    }
?>