<?php
    class UserModel{
        function __construct()
        {
            $this->db = new PDO(DB_VENDOR . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        /**
         * @param $data
         * 회원 저장 (회원가입)
         */
        function addUser($data){
            try {
                $result = $this->db->prepare("INSERT INTO USER_TB(USER_ID,USER_NM,USER_PASS) VALUES(:USER_ID, :USER_NM, :USER_PASS)");
                $result->bindValue(":USER_ID", $data['id']);
                $result->bindValue(":USER_NM", $data['name']);
                $result->bindValue(":USER_PASS", $data['pass']);
                $result->execute();
            }catch(PDOException $e){
                print 'addUser No! = '.$e->getMessage();
            }
        }


        /**
         * @param $data
         * @return mixed
         * 패스워드 불러오기
         */
        function getPass($data){
            try{
                $result = $this->db->prepare('SELECT USER_PASS FROM USER_TB WHERE USER_ID = :user_id');
                $result->bindValue(':user_id', $data['id']);
                $result->execute();
                return $result->fetch(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                print 'getPass no! = '.$e->getMessage();
            }
        }

        function getId($data){
            try {
                $result = $this->db->prepare('SELECT count(*) FROM USER_TB WHERE USER_ID = :user_id');
                $result->bindValue(':user_id', $data['id']);
                $result->execute();
                return $result->fetchColumn();
            } catch (PDOException $e) {
                print "getId no! = ".$e->getMessage();
            }
        }
        
    }
?>