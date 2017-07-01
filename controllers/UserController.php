<?php
    class UserController{
        function __construct()
        {
            require_once('./services/UserService.php');
            $this->userService = new UserService();
        }

        function getUserRegist(){
            $this->userService->getUserRegist();
        }

        function postUserRegist(){
            $this->userService->postUserRegist();
        }

        function getUserLogin(){
            $this->userService->getUserLogin();
        }

        function postUserLogin(){
            $this->userService->postUserLogin();
        }
    }

?>