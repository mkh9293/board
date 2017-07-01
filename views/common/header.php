<html>
    <body>
        <?php if($_SESSION['logined']){?>
            <div>
                <span><a href="/<?=ROOT_DOC?>/user/logout">로그아웃</a></span>
                <span><a href="/<?=ROOT_DOC?>/user/mypage">설정</a></span>
            </div>
        <?php } else{ ?>
            <div>
                <span><a href="/<?=ROOT_DOC?>/user/regist">회원가입</a></span>
                <span><a href="/<?=ROOT_DOC?>/user/login">로그인</a></span>
            </div>
        <?php } ?>
