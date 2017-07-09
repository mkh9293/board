    <?php for($i=0;$i<count($boardList);++$i){ ?>
        <h3><?=$boardList[$i][4];?></h3>
        <table>
            <tr>
                <td>No.</td>
                <td>Title.</td>
                <td>Date.</td>
                <td>Writer.</td>
                <td>Hit.</td>
            </tr>
            <?php if(isset($boardList[$i][0])){
            foreach ($boardList[$i][0] as $board) { ?>
                <tr onClick="<?= $board['href']; ?>">
                    <td><?= $board['space'] . ' ' . $board['step']; ?><?= $board['BOARD_NO']; ?></td>
                    <td><?= $board['BOARD_NM']; ?></td>
                    <td><?= $board['BOARD_YMD']; ?></td>
                    <td><?= $board['USER_NM']; ?></td>
                    <td><?= $board['HIT']; ?></td>
                </tr>
            <?php }} ?>
        </table>
        <div>
            <a href="/<?= ROOT_DOC ?>/board/add?type_no=<?=$boardList[$i][3];?>">글쓰기</a>
        </div>
        <div>
            <?php if(isset($boardList[$i][1])){
            foreach ($boardList[$i][1] as $value) { ?>
                <?= $value; ?>
            <?php }} ?>
        </div>
    <?php }?>
    <div>
        <form action="list" method="get">
            <input type="text" name="search"/>
            <input type="submit">
        </form>
    </div>
    </body>
</html>
