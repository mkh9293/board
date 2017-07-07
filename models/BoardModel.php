<?php
class BoardModel extends PDO
{
    public function __construct()
    {
        $this->db = new PDO(DB_VENDOR . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->log = new Log();
    }

    /* 게시글 저장 */
    public function add($board)
    {
        try{
            $rs = $this->db->prepare("INSERT INTO board_tb(BOARD_NM,BOARD_YMD,BOARD_CONTENT,USER_NM,BOARD_PASS) VALUES (?,now(),?,?,?);");
            $rs->execute(array($board['title'], $board['content'], $board['user'],$board['pass']));

            $no = $this->db->lastInsertId();
            $rs = $this->db->prepare("update board_tb set PARENT_NO = ? where BOARD_NO = ?");
            $rs->execute(array($no, $no));
            return $no;
        }catch(PDOException $e){
            print 'add no! '.$e->getMessage();
        }
    }

    /* 답글 저장 */
    public function addReply($board)
    {
        try {
            $rs = $this->db->prepare("update board_tb set INDEX_NO = INDEX_NO+1 where PARENT_NO = ? and INDEX_NO > ?");
            $rs->execute(array($board['parent'], $board['index']));

            $rs = $this->db->prepare("INSERT INTO board_tb(BOARD_NM,BOARD_YMD,BOARD_CONTENT,USER_NM,DEPTH_NO,INDEX_NO,PARENT_NO,BOARD_PASS) VALUES (?,now(),?,?,?,?,?,?);");
            $rs->execute(array($board['title'], $board['content'], $board['user'], $board['depth'] + 1, $board['index'] + 1, $board['parent'],$board['pass']));
            return $this->db->lastInsertId();
        }catch(PDOException $e){
            print 'addReply no! '.$e->getMessage();
        }
    }

    /* 게시글 리스트 불러오기 */
    public function getList($param)
    {
        try{
            $rs = $this->db->prepare("select * from board_tb where BOARD_NM like :text " . $param['where'] . " order by PARENT_NO desc, INDEX_NO asc limit :start, :end");
//            print_r($param);
            foreach($param as $key => $value){
                echo $value;
                $rs->bindValue($key,$value,PDO::PARAM_INT);
            }
            $rs->execute();
            return $rs->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            print 'getList no! '.$e -> getMessage();
        }
    }

    /* 게시글 내용 불러오기 */
    public function get($index)
    {
        $rs = $this->db->prepare("select *,bt.BOARD_NO as BOARD_NO from board_tb bt left outer join FILE_TB ft on bt.BOARD_NO = ft.BOARD_NO where bt.BOARD_NO = ?");
        $rs->execute(array($index));
        $data = $rs->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    /* 조회수 업데이트 */
    public function upHit($index)
    {
        $rs = $this->db->prepare("update board_tb set hit=hit+1 where board_no = ?");
        $rs->execute(array($index));
    }

    /* 게시글 리스트 사이즈 불러오기 */
    public function getBoardSize($param)
    {
        $rs = $this->db->prepare('select count(*) as rows from board_tb where BOARD_NM like ? '.$param['where']);
        $rs->execute($param['data']);
        return $data = $rs->fetch(PDO::FETCH_OBJ);
    }

    /* 게시글 삭제 */
    public function delete($no){
        $rs = $this->db->prepare("update board_tb set del = 1 where board_no = ?");
        return $rs->execute(array($no));
    }

    /* 게시글 업데이트 */
    public function update($board){
        try{
            $rs = $this->db->prepare("update board_tb set board_nm= :board_nm, board_content= :board_content, user_nm=:user_nm, board_ymd=now(), board_pass=:board_pass where BOARD_NO=:board_no");
            $rs->bindParam(':board_nm',$board['title']);
            $rs->bindParam(':board_content',$board['content']);
            $rs->bindParam(':user_nm',$board['user']);
            $rs->bindParam(':board_no',$board['no']);
            $rs->bindParam(":board_pass",$board['pass']);
            $rs->execute();
        }catch(PDOException $e){
            print 'update no! = '.$e->getMessage();
        }
    }

    /* 게시글 비밀번호 불러오기 */
    public function getPass($no){
        try{
            $rs = $this->db->prepare("select board_pass from board_tb where board_no = :board_no");
            $rs->bindValue(":board_no", $no);
            $rs->execute();
            return $data = $rs->fetch(PDO::FETCH_OBJ);
        }catch(PDOException $e){
            print 'getPass no! = '.$e->getMessage();
        }
    }

    /* 댓글 저장 */
    function addComment($data){
        try{
            $rs = $this->db->prepare('insert into COMMENT_TB(BOARD_NO,COMMENT_CONTENT,COMMENT_YMD,USER_NM) values(:board_no,:comment_content,now(),:user_nm)');
            $rs->bindValue(':board_no',$data['no']);
            $rs->bindValue(':comment_content',$data['comment']);
            $rs->bindValue(':user_nm',$data['writer']);
            $rs->execute();
        }catch(PDOException $e){
            print 'addComment no! = '.$e->getMessage();
        }
    }

    /* 댓글 불러오기 */
    function getComment($no){
        try{
            $rs = $this->db->prepare('select * from COMMENT_TB where BOARD_NO = :board_no');
            $rs->bindValue(':board_no', $no);
            $rs->execute();
            return $rs->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            print 'getComment no! = '.$e->getMessage();
        }
    }

    /* 파일 저장 */
    function addFile($data){
        try{
            $this->log->info('datadddd = '.$data['no']);
            $rs = $this->db->prepare("insert into FILE_TB(BOARD_NO,FILE_ORG_NM,FILE_NEW_NM,FILE_YMD) values(:board_no,:file_org_nm,:file_new_nm,now())");
            $rs->bindValue(':board_no',$data['no']);
            $rs->bindValue(':file_org_nm',$data['file_org_name']);
            $rs->bindValue(':file_new_nm',$data['file_new_name']);
            $rs->execute();
        }catch (PDOException $e){
            print 'addFile no! = '.$e->getMessage();
        }
    }

    /* 파일 불러오기 */
    function getFile($no){
        try{
            $rs = $this->db->prepare('select * from FILE_TB where BOARD_NO = :board_no');
            $rs->bindValue(":board_no", $no);
            $rs->execute();
            $data = $rs->fetch(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $e){
            print 'getFile no! ='.$e->getMessage();
        }
    }

    /* 파일 업데이트 */
    function updateFile($data){
        try{
            $rs = $this->db->prepare('update FILE_TB set FILE_ORG_NM = :FILE_ORG_NM, FILE_NEW_NM = :FILE_NEW_NM, FILE_YMD = now() where BOARD_NO = :board_no');
            $rs->bindValue(':FILE_ORG_NM',$data['file_org_name']);
            $rs->bindValue(':FILE_NEW_NM',$data['file_new_name']);
            $rs->bindValue(':board_no',$data['no']);
            $rs->execute();
        }catch(PDOException $e){
            print 'updateFile no! = '.$e->getMessage();
        }
    }

    /* 게시판 추가 */
    function addBoard($data){
        try{
            $rs = $this->db->prepare('INSERT INTO BOARD_TYPE_TB(BOARD_SUBJECT, BOARD_TYPE) VALUES(:board_subject, :board_type)');
            $rs->bindValue(':board_subject', $data['subject']);
            $rs->bindValue(':board_type', $data['type']);
            $rs->execute();
            return $this->db->lastInsertId();
        }catch(PDOException $e){
            print 'addBoard no! ='.$e->getMessage();
        }
    }

    /** 게시판 종류 불러오기 **/
    function getBoardTypeInfo(){
        try{
            $rs = $this->db->query('SELECT * FROM BOARD_TYPE_TB');
            $rs->execute();
            return $rs->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            print 'getBoardTypeInfo no! ='.$e->getMessage();
        }
    }
}

?>