 <div>
            <table>
                <tr>
                    <th>No.</th>
                    <th>Title.</th>
                    <th>Content.</th>
                    <th>Date.</th>
                    <th>Writer.</th>
                    <th>File.</th>
                    <th>Hit.</th>
                </tr>
                <tr>
                    <td><?=$this->board['BOARD_NO'];?></td>
                    <td><?=$this->board['BOARD_NM']?></td>
                    <td><?=$this->board['BOARD_CONTENT'];?></td>
                    <td><?=$this->board['BOARD_YMD'];?></td>
                    <td><?=$this->board['USER_NM'];?></td>
                    <td><a href="<?=$this->fileHref?>"><?=$this->file['FILE_ORG_NM'];?></a></td>
                    <td><?=$this->board['HIT'];?></td>
                </tr>
            </table>
        </div>
        <div>
            <a href="reply?no=<?=$this->board['BOARD_NO']?>&page=<?=$this->page?>">답글쓰기</a>
            <a href="update?no=<?=$this->board['BOARD_NO']?>&page=<?=$this->page?>">수정하기</a>
            <a href="delete?no=<?=$this->board['BOARD_NO']?>">삭제하기</a>
            <a href="list?page=<?=$this->page?>">목록으로</a>
        </div>

        <div style="margin-top:10px;">
            <form action="addComment" method="post">
                <input type="hidden" name="no" value="<?=$this->board['BOARD_NO'];?>" />
                <input type="hidden" name="page" value="<?=$this->page;?>" />
                <textarea name="comment" placeholder="댓글 작성"></textarea>
                <input type="text" name="writer" placeholder="작성자" />
                <input type="submit" name="submit"/>
            </form>

            <div>
                <table>
                    <tr>
                        <th>Comment.</th>
                        <th>writer.</th>
                        <th>Date.</th>
                    </tr>
                    <?php foreach($this->commentList as $comment){ ?>
                        <tr>
                            <td><?=$comment['COMMENT_CONTENT'];?></td>
                            <td><?=$comment['USER_NM'];?></td>
                            <td><?=$comment['COMMENT_YMD'];?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </body>
</html>