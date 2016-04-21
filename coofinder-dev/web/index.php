<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, maximum-scale=1.0,target-densitydpi=medium-dpi, user-scalable=no"/>
    <title>Coofinder</title>
    <meta name="description" content="Coofinder"/>
    <meta name="keywords" content=""/>
    <meta name="author" content="Coofinder"/>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/css/theme.min.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script><![endif]-->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./images/logo_144.png"/>
    <link rel="shortcut icon" href="./images/favicon.ico"/>
</head>
<body class="home-template">
<header class="site-header jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-xs-12" style="padding:10px 0 30px 0">
                <img src="./images/logo_home.png">
            </div>
            <div class="col-xs-12">
                <div class="col-xs-12 col-md-3 col-sm-12 col-lg-3">
                </div>
                <form action="/s" method="get" name="form">
                    <div class="col-xs-12 col-md-6 col-sm-12 col-lg-6" style="width:100%;">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" maxlength='100' id="words" name="q"/>
                   <span class="input-group-btn">
                         <a href="javascript:;" id="click"  class="btn btn-default" type="button" ><img src="./images/ic_search_1.png"></a>
                   </span>
                            <input type="hidden" name="t" value="web"/>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </form>
                <div class="col-xs-12 col-md-3 col-sm-12 col-lg-3">
                </div>

            </div>
        </div>
    </div>
</header>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <div class="container col-xs-12 col-md-12 col-sm-12 col-lg-12" style="padding-top:2px">
        <div class="row">
            <div class="font-icon-list col-xs-12 col-md-12 col-sm-12 col-lg-12">
                <p style="text-align:center; font-size:12px; color:#555; padding-top:15px">Copyright &copy; 2016 <a
                        href="#" style="color:#2196f3">COOFINDER</a>.All Rights Reserved.</p>
            </div>
        </div>
    </div>
</nav>

<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script>
$('#click').click(function(){
        $("form").submit();
});
</script>
</body>
</html>
