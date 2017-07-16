        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3><?= empty($list[0]['BOARD_SUBJECT'])? '기본 게시판' : $list[0]['BOARD_SUBJECT']; ?>
                        <?php if(!empty($list[0]['BOARD_TYPE'])){ ?>
                           (<?=$list[0]['BOARD_TYPE']?>)
                        <?php }?>
                    </h3>
                    <table class="table table-striped table-condensed">
                        <tr>
                            <td>No.</td>
                            <td>Title.</td>
                            <td>Date.</td>
                            <td>Writer.</td>
                            <td>Hit.</td>
                        </tr>
                            <?php if(!empty($list)) {
                                foreach ($list as $key => $board) { ?>
                                    <tr onClick="<?= $board['href']; ?>">
                                        <td><?= $board['space'] . ' ' . $board['step']; ?><?= $board['BOARD_NO']; ?></td>
                                        <td><?= $board['BOARD_NM']; ?></td>
                                        <td><?= $board['BOARD_YMD']; ?></td>
                                        <td><?= $board['USER_NM']; ?></td>
                                        <td><?= $board['HIT']; ?></td>
                                    </tr>
                                <?php }
                            }else{
                                echo '데이터가 없습니다.';
                            }?>
                    </table>
                    <div class="pull-right">
                        <a class="btn btn-default" href="/<?= ROOT_DOC ?>/board/add?type_no=<?=empty($data['BOARD_TYPE_NO'])? '':$data['BOARD_TYPE_NO']?>">글쓰기</a>
                    </div>
                    <nav class="text-center">
                        <ul class="pagination ">
                            <?php
                            foreach ($data['pages'] as $value) { ?>
                                <?= $value; ?>
                            <?php } ?>
                        </ul>
                    </nav>
                    <form action="list" method="get">
                        <div class="input-group col-lg-4 col-lg-offset-4">
                            <input type="text" name="search" class="form-control" placeholder="search Title" />
                            <input type="hidden" name="BOARD_TYPE_NO" value="<?=empty($data['BOARD_TYPE_NO'])? '':$data['BOARD_TYPE_NO']?>"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>