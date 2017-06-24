<html>
    <body>
        <div>
            <form action="<?= $this->type ?>" method="post" enctype="multipart/form-data">
                <?php if (isset($this->type)) { ?>
                    <input type="hidden" name="no" value="<?=$this->board['BOARD_NO'];?>"/>
                    <input type="hidden" name="parent" value="<?=$this->board['PARENT_NO'];?>"/>
                    <input type="hidden" name="depth" value="<?=$this->board['DEPTH_NO'];?>"/>
                    <input type="hidden" name="index" value="<?=$this->board['INDEX_NO'];?>"/>
                    <input type="hidden" name="page" value="<?=$this->page;?>"/>
                    <input type="hidden" name="type" value="<?=$this->type;?>"/>
                <?php } ?>
                <ul>
                    <li>
                        <label>제목</label>
                        <input type="text" name="title" value="<?= $this->board['BOARD_NM']; ?>"/>
                    </li>
                    <li>
                        <label>내용</label>
                        <textarea name="content"><?=$this->board['BOARD_CONTENT']; ?></textarea>
                    </li>
                    <li>
                        <label>작성자</label>
                        <input type="text" name="user" value="<?=$this->board['USER_NM']?>"/>
                    </li>
                    <?php if ($this->type == 'update'){ ?>
                        <li>
                            <label>첨부파일</label>
                            <?= $this->board['FILE_ORG_NM']; ?>
                        </li>
                    <?}?>
                    <li>
                        <label>첨부파일</label>
                        <input type="file" name="file" value="" />
                    </li>
                    <li>
                        <label>비밀번호</label>
                        <input type="password" name="pass" />
                    </li>
                    <input type="submit" name="submit">
                </ul>
            </form>
        </div>
    </body>
</html>