<html>
    <body>
    <div>
        <a href="/<?=ROOT_DOC?>/">메인</a>
        <?php if(isset($_SESSION['logined'])){ ?>
            <?= $_SESSION['userId'] ?>

                <span><a href="/<?=ROOT_DOC?>/user/logout">로그아웃</a></span>
                <span><a href="/<?=ROOT_DOC?>/user/mypage">설정</a></span>
        <?php } else{ ?>
                <span><a href="/<?=ROOT_DOC?>/user/regist">회원가입</a></span>
                <span><a href="/<?=ROOT_DOC?>/user/login">로그인</a></span>
        <?php } ?>
    </div>
