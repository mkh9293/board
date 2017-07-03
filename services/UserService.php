<?php
    class UserService{
        function __construct()
        {
            require_once('./models/UserModel.php');
            $this->userModel = new UserModel();
            $this->log = new Log();
        }


        /* 회원가입 */
        function getUserRegist(){
            require_once('./views/user/userRegist.php');
        }
        function postUserRegist(){
            if (isset($_POST['submit'])) {
                $data = $_POST;
                $idCount = $this->userModel->getId($data);
                $this->log->info('id Count = '.$idCount);
                if($idCount>0){
                    echo "<script>alert('이미 존재하는 아이디입니다.'); history.back();</script>";
                    return;
                }
                $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                $this->userModel->addUser($data);
            }
            header("Location:".ROOT_URL.'user/login');
        }

        /* 로그인 */
        function getUserLogin(){
            require_once ('./views/user/userLogin.php');
        }
        function postUserLogin(){
            if (isset($_POST['submit'])) {
                $data = $_POST;
                $hash = $this->userModel->getPass($data);
                if (password_verify($data['pass'], $hash['USER_PASS'])) {
                    $_SESSION['logined'] = true;
                    $_SESSION['userId']  = $data['id'];
                    header('Location:'.ROOT_URL.'board/list');
                }else{
                    echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
                }
            }
        }

        /* 로그아웃 */
        function getUserLogout(){
            if (isset($_GET)) {
                session_start();
                session_unset();
                session_destroy();
                header('Location:' . ROOT_URL . 'board/list');
            }
        }

        function getUserMypage(){
            require_once ('./views/user/mypage.php');
        }
    }
?>