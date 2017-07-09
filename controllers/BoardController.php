<?php
    class BoardController{
        public function __construct()
        {
            require_once('./services/BoardService.php');
            $this->boardService = new BoardService();
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
                $list = $this->boardService->getPaging($_GET);
                $list = $this->boardService->boardList($list);
                $boardTypeList = $this->boardService->getBoardTypeInfo();
                $boardList = array();
                $list[3] = "";
                $list[4] = "";
                array_push($boardList,$list);
                if(!empty($boardTypeList)) {

                    $i = count($list);
//                    foreach ($boardTypeList as $key => $value) {
//                        $list[$i] = $this->boardService->getPaging('', $value['BOARD_TYPE_NO']);
//                        $list[++$i] = "";
//                        $list[$i] = $this->boardService->boardList($list[$i]);
//                        print_r($list);
//                        array_push($boardList,$list);
//                    }
                    foreach ($boardTypeList as $key => $value) {
                        $list = $this->boardService->getPaging('', $value['BOARD_TYPE_NO']);
                        $list = $this->boardService->boardList($list);
                        $list[3] = $value['BOARD_TYPE_NO'];
                        $list[4] = $value['BOARD_SUBJECT'];
                        array_push($boardList,$list);
                    }
                }
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
            print_r($_POST);
            $this->boardService->addBoard($_POST);
        }
    }
?>