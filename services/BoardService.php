<?php
    class BoardService{
        public function __construct(){
            require_once ('./models/BoardModel.php');
            $this->boardModel = new BoardModel();
            $this->log = new Log();
        }

        /* 글 저장 로직 */
        function boardAddPost($data){
            if(isset($data['submit'])){
                if ($data['pass']!='') {
                    $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                }
                $data['no'] = $this->boardModel->add($data);
                if ($_FILES['file']['error'] != 4) {
                    $ext = array_pop(explode(".", $_FILES['file']['name']));
                    $uploadFile = md5(date("YmdHis", time()) . basename($_FILES['file']['name']));
                    $uploadDir = FILE_PATH . $uploadFile . '.' . $ext;
                    // http post로 업로드 된 파일인 지 체크
                    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir)) {
                            $data['file_org_name'] = $_FILES['file']['name'];
                            $data['file_new_name'] = $uploadFile.'.'.$ext;
                            $this->boardModel->addFile($data);
                        }
                    } else {
                        return "<script>alert('post로 전송된 파일이 아닙니다.');</script>";
                    }
                }
                header('Location:' . ROOT_URL . 'list');
            }
        }
        function boardAddGet(){
            $this->type = "add";
            require_once ('./views/add.php');
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
                $this->page = $data['page'];
                require_once ('./views/add.php');
            }
        }

        function boardReplyPost($data){
            if(isset($data['submit'])){
                if($data['pass']!=''){
                    $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                }
                $no = $this->boardModel->addReply($data);
                header('Location:'.ROOT_URL.'view?no='.$no.'&page='.$data['page']);
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
                    require_once ('./views/view.php');
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
                if (!is_null($this->board['BOARD_PASS']) && $this->board['BOARD_PASS'] != '') {
                    $this->no = $no;
                    require_once('./views/passCheck.php');
                    return;
                }
                $this->boardModel->upHit($no);
                require_once ('./views/view.php');
            }
        }

        /* 글 업데이트 */
        function boardUpdateGet($data){
            if(isset($data['no'])){
                $no = $data['no'];
                $this->board = $this->boardModel->get($no);
                $this->type = 'update';
                $this->page = $data['page'];
                require_once ('./views/add.php');
            }
        }
        function boardUpdatePost($data){
            if (isset($data['submit'])) {
                if($data['pass']!=''){
                    $data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
                }
                $this->boardModel->update($data);
                header('Location:'.ROOT_URL.'view?no='.$data['no'].'&page='.$data['page']);
            }
        }

        /* 글 삭제 */
        function boardDelete($data){
            if (isset($data['no'])) {
                $no = $data['no'];
                $no = $this->boardModel->delete($no);
                header('Location:'.ROOT_URL.'list?no='.$no);
            }
        }

        /* 글 리스트 출력 */
        function boardList($list){
            $j = 0;
            $this->boardList = $list[0];
            foreach($this->boardList as $board){
                $this->boardList[$j]['step'] = "";
                $this->boardList[$j]['space'] = "";

                if ($board['DEPTH_NO']>0) {
                    $this->boardList[$j]['step'] = "ㄴ";
                }

                $blank = "";
                for($i=0;$i<$board['DEPTH_NO'];++$i){
                    $blank .= "&nbsp;&nbsp";
                }

                if($board['del']==1){
                    $this->boardList[$j]['BOARD_NM'] = '삭제된 게시글 입니다';
                    $this->boardList[$j]['href'] = "location.href='#'";
                }else{
                    $this->boardList[$j]['href'] = "location.href='view?no=".$board['BOARD_NO']."&page=".$list[2]."'";
                }
                $this->boardList[$j++]['space'] = $blank;
            }

            require_once ('./views/list.php');
        }

        /* 페이징 */
        function getPaging($data){
            $searchText = '';
            if (isset($data['search'])) {
                $searchText = $data['search'];
            }

            $total = $this->boardModel->getBoardSize($searchText)->rows;
            $page_num = 10;
            $block_num = 5;
            $page = 1;
            if(!is_null($data['page'])){
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
                $pages[] = "<a href=?page=$prev_page> [이전] </a>";
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
                    $pages[] = "<b>$i</b>";
                }else{
                    $pages[] = "<a href=?page=$i&search=$searchText> $i </a>";
                }
            }

            // 다음 페이지
            if($now_block < $total_block){
                $pages[] = "<a href=?page=$next_page> [다음] </a>";
            }

            $this->boardList = $this->boardModel->getList($searchText,$limit_start,$page_num);

            $this->List = array();
            array_push($this->List, $this->boardList);
            array_push($this->List, $pages);
            array_push($this->List, $page);

            return $this->List;
        }

        /* 댓글 작성 */
        function boardCommentPost($data){
            if (isset($data['submit'])) {
                $this->boardModel->addComment($data);
                header('Location:'.ROOT_URL.'view?no='.$data['no'].'&page='.$data['page']);
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
    }
?>