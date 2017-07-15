<?php for($i=0;$i<count($boardList);++$i){?>
    <h3><?=$boardList[$i][0]['BOARD_SUBJECT'];?></h3>
    <div><a href="/<?= ROOT_DOC ?>/board/list?BOARD_TYPE_NO=<?=$boardList[$i][0]['BOARD_TYPE_NO']?>">더보기</a></div>
<table>
    <thead>
        <th>No.</th>
        <th>Title.</th>
        <th>Date.</th>
        <th>Writer.</th>
        <th>Hit.</th>
    </thead>
    <tbody>
        <?php foreach($boardList[$i] as $board){?>
            <tr onClick="<?= $board['href']; ?>">
                <td><?= $board['space'] . ' ' . $board['step']; ?><?= $board['BOARD_NO']; ?></td>
                <td><?= $board['BOARD_NM']; ?></td>
                <td><?= $board['BOARD_YMD']; ?></td>
                <td><?= $board['USER_NM']; ?></td>
                <td><?= $board['HIT']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php } ?>