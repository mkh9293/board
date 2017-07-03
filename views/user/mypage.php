<html>
<body>
    <form action="<?=ROOT_URL?>board/addBoard" method="POST">
        <label>게시판 제목</label>
        <input type="text" name="subject"/>
        <label>게시판 유형</label>
        <select name="type">
            <option value="free">free</option>
            <option value="notice">notice</option>
        </select>
        <input type="submit" name="submit"/>
    </form>
</body>
</html>