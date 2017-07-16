<?php
    class BoardService{
        public function __construct(){
            require_once ('./models/BoardModel.php');
            $this->boardModel = new BoardModel();
            $this->log = new Log();
        }

        /* 글 메인 */
        function boardMain($type = null){
            $param[':text'] = "%%";
            $param[':start'] = 0;
            $param[':end'] = 5;
            if (isset($type)) {
                $where = 'AND BOARD_TYPE_NO = :board_type_no';
                $param[':board_type_no'] = $type;
            }else{
                $where = 'AND BOARD_TYPE_NO is null';
            }

            return $this->boardModel->getList($param,$where);
        }

        /* 글 저장 로직 */
        function boardAddPost($data){
            if(isset($data['submit'])){
                if ($data['pass']!='') {
                    $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                }
                if ($data['type_no'] == '') {
                    $data['type_no'] = null;
                }
                $data['no'] = $this->boardModel->add($data);
                self::fileUpload($data,'add');
                header('Location:' . ROOT_URL . 'board/list');
            }
        }
        function boardAddGet(){
            $this->type = "add";
            if (isset($_GET['type_no'])) {
                $this->typeNo = $_GET['type_no'];
            }
//            require_once ('./views/board/add.php');
            self::requiresFile($this->type);
        }

        /* 답글 작성 */
        function boardReplyGet($data){
            if (isset($data['no'])) {
                $no = $data['no'];
                $this->board = $this->boardModel->get($no);
                $this->board['BOARD_NM'] = '';
                $this->board['BOARD_CONTENT'] = '';
                $this->board['USER_NM'] = '';
                $this->type = 'reply';
                if (isset($_GET['type_no'])) {
                    $this->typeNo = $_GET['type_no'];
                }
                $this->page = $data['page'];
                self::requiresFile('add');
            }
        }

        function boardReplyPost($data){
            if(isset($data['submit'])){
                if($data['pass']!=''){
                    $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                }
                if ($data['type_no'] == '') {
                    $data['type_no'] = null;
                }
                $no = $this->boardModel->addReply($data);
                $data['no'] = $no;
                self::fileUpload($data,'reply');

                header('Location:'.ROOT_URL.'board/view?no='.$no.'&page='.$data['page']);
            }
        }

        /* 글 보기 비밀번호 체크 후 글 보기 뷰 출력*/
        function boardViewPost($data){
            if (isset($data['submit'])) {
                $no = $data['no'];
                $pass = $data['pass'];
                $hash = $this->boardModel->getPass($no);
                if(password_verify($pass,$hash->board_pass)){
                    $this->board = $this->boardModel->get($no);
                    $this->commentList = $this->boardModel->getComment($no);
                    $this->file = $this->boardModel->getFile($no);
                    $this->fileHref = 'fileDownload?fileName='.$this->file['FILE_NEW_NM'].'&orgFileName='.$this->file['FILE_ORG_NM'];
                    $this->boardModel->upHit($no);
                    $this->page = $data['page'];
                    self::requiresFile('view');
                }else{
                    echo "<script>history.back(); alert('error');</script>";
                }
            }
        }

        /* 글 보기 */
        function boardViewGet($data){
            if (isset($data['no'])) {
                $no = $data['no'];
                $this->page = $data['page'];
                $this->board = $this->boardModel->get($no);
                $this->commentList = $this->boardModel->getComment($no);
                $this->file = $this->boardModel->getFile($no);
                $this->fileHref = 'fileDownload?fileName='.$this->file['FILE_NEW_NM'].'&orgFileName='.$this->file['FILE_ORG_NM'];
                if (!is_null($this->board['BOARD_PASS']) && $this->board['BOARD_PASS'] != '') {
                    $this->no = $no;
                    self::requiresFile('passCheck');
                    return;
                }
                $this->boardModel->upHit($no);
                self::requiresFile('view');
            }
        }

        /* 글 업데이트 */
        function boardUpdateGet($data){
            if(isset($data['no'])){
                $no = $data['no'];
                $this->board = $this->boardModel->get($no);
                $this->type = 'update';
                $this->page = $data['page'];
                self::requiresFile('add');
            }
        }
        function boardUpdatePost($data){
            if (isset($data['submit'])) {
                if($data['pass']!=''){
                    $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                }
                self::fileUpload($data,'update');
                $this->boardModel->update($data);
                header('Location:'.ROOT_URL.'board/view?no='.$data['no'].'&page='.$data['page']);
            }
        }

        /* 글 삭제 */
        function boardDelete($data){
            if (isset($data['no'])) {
                $no = $data['no'];
                $no = $this->boardModel->delete($no);
                header('Location:'.ROOT_URL.'board/list?no='.$no);
            }
        }

        /* 글 리스트 세팅 */
        function boardList($type,$data)
        {
            $page = 1;
            if (isset($data['page'])) {
                $page = $data['page'];
            }
            if(!empty($type)){
                $param[':text'] = '%%';
                $param[':start'] = 0;
                $param[':end'] = 5;
            }else{
                $param[':text'] = $data[':text'];
                $param[':start'] = $data[':start'];
                $param[':end'] = $data[':end'];
            }

            if (!empty($data['BOARD_TYPE_NO'])) {
                $where = 'AND bt.BOARD_TYPE_NO = :board_type_no';
                $param[':board_type_no'] = $data['BOARD_TYPE_NO'];
            }else{
                $where = 'AND bt.BOARD_TYPE_NO is null';
            }

            $this->boardList = $this->boardModel->getList($param,$where);

            $j = 0;
//            $this->boardList = $list[0];
            if (!empty($this->boardList)) {
                foreach ($this->boardList as $board) {
                    $this->boardList[$j]['step'] = "";
                    $this->boardList[$j]['space'] = "";

                    if ($board['DEPTH_NO'] > 0) {
                        $this->boardList[$j]['step'] = "ㄴ";
                    }

                    $blank = "";
                    for ($i = 0; $i < $board['DEPTH_NO']; ++$i) {
                        $blank .= "&nbsp;&nbsp";
                    }

                    if ($board['del'] == 1) {
                        $this->boardList[$j]['BOARD_NM'] = '삭제된 게시글 입니다';
                        $this->boardList[$j]['href'] = "location.href='#'";
                    } else {
                        $this->boardList[$j]['href'] = "location.href='" . ROOT_URL . "board/view?no=" . $board['BOARD_NO'] . "&page=" . $page . "'";
                    }
                    $this->boardList[$j++]['space'] = $blank;
                }
//            self::requiresFile('list');
//                $list[0] = $this->boardList;
//                return $list;
                return $this->boardList;
            }
        }

        /* 페이징 */
        function getPaging($data){
            $type = '';
            if (!empty($data['BOARD_TYPE_NO'])) {
                $type = $data['BOARD_TYPE_NO'];
            }
            $searchText = '';
            if (isset($data['search']) && !is_null($data['search'])) {
                $searchText = $data['search'];
            }

            // 기본 게시판의 글만 가지고 올 때와 추가된 게시판의 글을 가져올 때를 구분
            $param['where'] = '';
            if ($type != '') {
                $param['where'] = 'AND BOARD_TYPE_NO = ?';
                $param['data'] = array('%'.$searchText.'%', $type);
            }else{
                $param['where'] = 'AND BOARD_TYPE_NO is null';
                $param['data'] = array('%'.$searchText.'%');
            }

            $total = $this->boardModel->getBoardSize($param)->rows;
            $page_num = 10;
            $block_num = 5;
            $page = 1;
            if(isset($data['page']) && !empty($data['page'])){
                $page = $data['page'];
            }

            $limit_start = $page_num * $page - $page_num;

            $total_page = ceil($total/$page_num);
            $total_block = ceil($total_page / $block_num);
            $now_block = ceil($page / $block_num);

            $start_page = (($now_block * $block_num) - ($block_num - 1));
            $last_page  = ($now_block * $block_num);
            $prev_page  = ($now_block * $block_num)-$block_num;
            $next_page  = ($now_block * $block_num)+1;

            $pages = array();
            // 이전 페이지
            if($now_block > 1){
                $pages[] = "<li><a aria-label='Previous' href=?page=$prev_page&BOARD_TYPE_NO=$type> &laquo; </a></li>";
            }

            // 페이지 리스트
            if($last_page < $total_page) {
                $for_end=$last_page;
            }
            else{
                $for_end=$total_page;
            }

            for($i=$start_page; $i<=$for_end; $i++){
                if($i==$page){
                    $pages[] = "<li class='active'><span>$i</span></li>";
                }else{
                    $pages[] = "<li><a href=?page=$i&search=$searchText&BOARD_TYPE_NO=$type> $i </a></li>";
                }
            }

            // 다음 페이지
            if($now_block < $total_block){
                $pages[] = "<li><a aria-label='Next' href=?page=$next_page&BOARD_TYPE_NO=$type> &raquo; </a></li>";
            }

            $data[':text'] = "%".$searchText."%";
            $data[':start'] = $limit_start;
            $data[':end'] = $page_num;
            $data['page'] = $page;
            $data['pages'] = $pages;
            return $data;
         }

        /* 댓글 작성 */
        function boardCommentPost($data){
            if (isset($data['submit'])) {
                $this->boardModel->addComment($data);
                header('Location:'.ROOT_URL.'board/view?no='.$data['no'].'&page='.$data['page']);
            }
        }

        /* 파일 다운로드*/
        function fileDownloadGet($data){
            if(isset($data['fileName'])){
                $file_dir = FILE_PATH . $data['fileName'] ;

                header('Content-Type: application/x-octetstream');
                header('Content-Length:'.filesize($file_dir));
                header('Content-Disposition: attachment; filename='.$data['orgFileName']);
                header('Content-Transfer-Encoding:binary');

                $fp = fopen($file_dir,"rb");
                fpassthru($fp);
                fclose($fp);
            }
        }

        /* 파일 업로드 */
        private function fileUpload($data,$type){
            if ($_FILES['file']['error'] != 4) {
                $ext = array_pop(explode(".", $_FILES['file']['name']));
                $uploadFile = md5(date("YmdHis", time()) . basename($_FILES['file']['name']));
                $uploadDir = FILE_PATH . $uploadFile . '.' . $ext;
                // http post로 업로드 된 파일인 지 체크
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir)) {
                        $data['file_org_name'] = $_FILES['file']['name'];
                        $data['file_new_name'] = $uploadFile . '.' . $ext;
                        $this->log->info('file = '.$uploadDir);
                        if($type=='update'){
                            $this->file = $this->boardModel->getFile($data['no']);
                            $result = self::fileDelete(FILE_PATH.$this->file['FILE_NEW_NM']);
                            if($result){
                                $this->boardModel->updateFile($data);
                            }else{
                                $this->boardModel->addFile($data);
                            }
                        }else{
                            $this->boardModel->addFile($data);
                        }
                    }
                } else {
                    return "<script>alert('post로 전송된 파일이 아닙니다.');</script>";
                }
            }
        }

        /* 파일 삭제 */
        private function fileDelete($uploadDir){
            if(is_file($uploadDir)==true){
                unlink($uploadDir);
                return true;
            }
            return false;
        }

        /* 게시판  추가 */
        function addBoard($data){
            if (isset($data['submit'])) {
                $result = $this->boardModel->addBoard($data);
                if($result > 0){
                    header('Location:'.ROOT_URL.'board/list');
                }else{
                    return "<script>alert('게시판을 추가하는데 실패하였습니다.'); history.back();</script>";
                }
            }
        }

        /** 게시판 종류 불러오기 **/
        function getBoardTypeInfo(){
            return $this->boardModel->getBoardTypeInfo();
        }

        /* 뷰 파일 호출 */
        private function requiresFile($type){
            require_once ('./views/common/header.php');
            require_once ('./views/board/'.$type.'.php');
        }
    }
?>