<div class="container">
    <div class="row">
    <?php for($i=0;$i<count($boardList);++$i){?>
        <div class="wrapper col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h3>
                        <?php if(empty($boardList[$i][0]['BOARD_SUBJECT'])){ ?>
                            기본 테이블
                        <?php }else{?>
                            <?=$boardList[$i][0]['BOARD_SUBJECT'];?>
                            (<?=$boardList[$i][0]['BOARD_TYPE']?>)
                        <?php }?>
                        <span class="label pull-right"><a href="/<?= ROOT_DOC ?>/board/list?BOARD_TYPE_NO=<?=$boardList[$i][0]['BOARD_TYPE_NO']?>">더보기</a></span>
                    </h3>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                    <th>No.</th>
                    <th>Title.</th>
                    <th>Date.</th>
                    <th>Writer.</th>
                    <th>Hit.</th>
                </thead>
                <tbody>
                    <?php if(isset($boardList[$i][0]['BOARD_NO'])){
                        foreach($boardList[$i] as $board){?>
                            <tr onClick="<?= $board['href']; ?>">
                                <td><?= $board['space'] . ' ' . $board['step']; ?><?= $board['BOARD_NO']; ?></td>
                                <td><?= $board['BOARD_NM']; ?></td>
                                <td><?= $board['BOARD_YMD']; ?></td>
                                <td><?= $board['USER_NM']; ?></td>
                                <td><?= $board['HIT']; ?></td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    </div>
</div>
