<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            min-height: 45%;
        }
    </style>
</head>
    <body>
    <div class="header">
        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/<?=ROOT_DOC?>/">Project</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(isset($_SESSION['logined'])){ ?>
                            <li><a href="/<?=ROOT_DOC?>/user/logout">로그아웃</a></li>
                            <li><a href="/<?=ROOT_DOC?>/user/mypage">설정</a></li>
                        <?php } else{ ?>
                            <li><a href="/<?=ROOT_DOC?>/user/regist">회원가입</a></li>
                            <li><a href="/<?=ROOT_DOC?>/user/login">로그인</a></li>
                        <?php } ?>
                    </ul>
                    <ul class="collapse nav navbar-nav nav-collapse" id="nav-collapse1">
                        <?php if(isset($_SESSION['logined'])){ ?>
                            <li><a href="/<?=ROOT_DOC?>/user/logout">로그아웃</a></li>
                            <li><a href="/<?=ROOT_DOC?>/user/mypage">설정</a></li>
                        <?php } else{ ?>
                            <li><a href="/<?=ROOT_DOC?>/user/regist">회원가입</a></li>
                            <li><a href="/<?=ROOT_DOC?>/user/login">로그인</a></li>
                        <?php } ?>
                        <li><a href="#">Web design</a></li>
                        <li><a href="#">Development</a></li>
                        <li><a href="#">Graphic design</a></li>
                        <li><a href="#">Print</a></li>
                        <li><a href="#">Motion</a></li>
                        <li><a href="#">Mobile apps</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->
    </div>
