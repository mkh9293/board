<?php
    class BoardController{
        public function __construct()
        {
            require_once('./services/BoardService.php');
            $this->boardService = new BoardService();
        }

        /* 글 메인 */
        function getBoardMain(){
            $type = 'main';
            $list = $this->boardService->boardList($type,null);
            $boardList = array();
            array_push($boardList,$list);

            $boardTypeList = $this->boardService->getBoardTypeInfo();
            foreach ($boardTypeList as $key => $value) {
                $list = $this->boardService->boardList($type,$value);
                array_push($boardList,$list);
            }
            require_once ('./views/common/header.php');
            require_once ('./views/main.php');
        }

        /* 글 저장 */
        function getBoardAdd(){
            $this->boardService->boardAddGet();
        }
        function postBoardAdd(){
            $this->boardService->boardAddPost($_POST);
        }

        /* 글 리스트 */
        function getBoardList(){
            try{
                $data = $this->boardService->getPaging($_GET);
                $list = $this->boardService->boardList('',$data);

                require_once ('./views/common/header.php');
                require_once ('./views/board/list.php');
            }catch (Exception $e){
                $e ->getMessage();
            }
        }

        /* 글 보기 */
        function getBoardView(){
            $this->boardService->boardViewGet($_GET);
        }
        function postBoardView(){
            $this->boardService->boardViewPost($_POST);
        }


        /* 글 삭제 */
        function getBoardDelete(){
            $this->boardService->boardDelete($_GET);
        }

        /* 글 업데이트 */
        function getBoardUpdate(){
            $this->boardService->boardUpdateGet($_GET);
        }
        function postBoardUpdate(){
            $this->boardService->boardUpdatePost($_POST);
        }

        /* 게시판 답글 */
        function getBoardReply(){
            $this->boardService->boardReplyGet($_GET);
        }
        function postBoardReply(){
            $this->boardService->boardReplyPost($_POST);
        }

        /* 댓글 작성 */
        function postBoardAddComment(){
            $this->boardService->boardCommentPost($_POST);
        }

        /* 파일 다운로드 */
        function getBoardFileDownload(){
            $this->boardService->fileDownloadGet($_GET);
        }

        /* 게시판 추가 */
        function postBoardAddBoard(){
            $this->boardService->addBoard($_POST);
        }
    }
?>