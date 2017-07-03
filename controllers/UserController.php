<?php
    class UserController{
        function __construct()
        {
            require_once('./services/UserService.php');
            $this->userService = new UserService();
        }

        /**
         * 회원가입
         */
        function getUserRegist(){
            $this->userService->getUserRegist();
        }
        function postUserRegist(){
            $this->userService->postUserRegist();
        }

        /**
         * 로그인
         */
        function getUserLogin(){
            $this->userService->getUserLogin();
        }
        function postUserLogin(){
            $this->userService->postUserLogin();
        }

        /**
         * 로그아웃
         */
        function getUserLogout(){
            $this->userService->getUserLogout();
        }

        function getUserMypage(){
            $this->userService->getUserMypage();
        }
    }
?>