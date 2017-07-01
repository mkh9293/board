 <table>
            <tr>
                <td>No.</td>
                <td>Title.</td>
                <td>Date.</td>
                <td>Writer.</td>
                <td>Hit.</td>
            </tr>
            <?php foreach($this->boardList as $board){?>
                <tr onClick="<?= $board['href']; ?>">
                    <td><?= $board['space'].' '.$board['step']; ?><?= $board['BOARD_NO']; ?></td>
                    <td><?= $board['BOARD_NM']; ?></td>
                    <td><?= $board['BOARD_YMD']; ?></td>
                    <td><?= $board['USER_NM']; ?></td>
                    <td><?= $board['HIT']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <div>
            <a href="/<?=ROOT_DOC?>/board/add">글쓰기</a>
        </div>
            <div>
                <form action="list" method="get">
                    <input type="text" name="search"/>
                    <input type="submit">
                </form>
            </div>
        <div>
            <?php foreach($this->pages as $value){ ?>
                <?= $value; ?>
            <?php } ?>
        </div>
    </body>
</html>
