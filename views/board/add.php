        <div class="container">
            <div class="row ">
            <div class="col-lg-8 col-lg-offset-2">
                <form action="<?= $this->type ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <?php if($this->type == 'add' || $this->type == 'reply'){?>
                    <input type="hidden" name="type_no" value="<?=$this->typeNo;?>"/>
                    <?php }?>
                    <?php if (isset($this->type) && ($this->type=='update' || isset($this->board['BOARD_NO']))) { ?>
                        <input type="hidden" name="no" value="<?=$this->board['BOARD_NO'];?>"/>
                        <input type="hidden" name="parent" value="<?=$this->board['PARENT_NO'];?>"/>
                        <input type="hidden" name="depth" value="<?=$this->board['DEPTH_NO'];?>"/>
                        <input type="hidden" name="index" value="<?=$this->board['INDEX_NO'];?>"/>
                        <input type="hidden" name="page" value="<?=$this->page;?>"/>
                        <input type="hidden" name="type" value="<?=$this->type;?>"/>
                    <?php } ?>
                    <div class="input-group col-lg-12">
                        <div class="form-group">
                            <label for="title" class="col-md-2">제목 : </label>
                            <div class="col-md-4">
                            <input type="text" class="form-control" id="title" name="title" value="<?php if(isset($this->board['BOARD_NM'])){echo $this->board['BOARD_NM']; }  ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usr" class="col-md-2">작성자 : </label>
                            <div class="col-md-4">
                                <?php if(!empty($_SESSION['userId'])){ ?>
                                    <input type="text" class="form-control" name="user" value="<?=$_SESSION['userId']?>" readonly/>
                                <?php }else{?>
                                    <input type="text" class="form-control" name="user" value="<?php if(isset($this->board['USER_NM'])){echo $this->board['USER_NM'];}?>"/>
                                <?php }?>
                            </div>
                        </div>
                        <div class="form-group">
                        <?php if ($this->type == 'update'){ ?>
                            <label class="col-md-2">첨부파일 : </label>
                            <div class="col-md-4">
                                <span class="form-control"><?= $this->board['FILE_ORG_NM']; ?></span>
                            </div>
                        <?php }?>
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-md-2">첨부 파일 : </label>
                            <div class="col-md-4">
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-md-2">비밀번호 : </label>
                            <div class="col-md-4">
                                <input type="password" class="form-control" id="pass" name="pass">
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="usr" class="col-md-2">내용 : </label>
                                <div class="col-md-9">
                                <textarea name="content" class="form-control" rows="10"><?php if(isset($this->board['BOARD_CONTENT'])){echo $this->board['BOARD_CONTENT'];} ?></textarea>
                                </div>
                            </div>
                        <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-default"/>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </body>
</html>