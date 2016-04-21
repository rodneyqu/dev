<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,target-densitydpi=medium-dpi, user-scalable=no">
    <meta name="description" content="Coofinder">
    <meta name="keywords" content="">
    <meta name="author" content="Coofinder">
    <title>Coofinder</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/theme.min.css" rel="stylesheet">
    <link href="/css/searchSite-min.css" rel="stylesheet">
    <!--[if lt IE 9]><script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script><![endif]-->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/logo_144.png">
    <link rel="shortcut icon" href="/images/favicon.ico">
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src='<!--{$cloud_host}-->/js/jquery.flex-images.min.js'></script>
    <style>
        #list{width:100%; height:1250px; margin:2px auto; position:relative}
        #list table{width: 100%; table-layout: fixed;}
        #list table tr td{ text-align: center; width:33%; height:420px; margin:2px ;font-family:Microsoft YaHei;color: #AAA }
        #list table tr td div{height: 100%;width: 90%}
        #list table tr td div a img{width:auto; height:220px ;object-fit: contain;max-width: 100%}
        #list table tr td div a p{line-height:15px;font-size: 20px; color:#FFA826;padding-top: 10px;}
		/*#list table tr td div a span{ color:#545454}*/
		#result span{ font-size: 15px;color: #AAA;font-family:Microsoft YaHei}
        #setpage{width:100%; margin:10px auto; text-align:center; }
		/*#setpage span{margin:4px; font-size:20px}
		#setpage  a{color: blue;font-weight:bold;margin:4px; font-size:30px;}*/
		#advertiseWeb { float: left;width:42%; position: relative;  left: 85px; }
        #advertiseShopping { float: left;width:35%; position: relative;  left: 110px; }
        .keyword{color:#f57c00;font-weight: bold }
        #adcontainer2{position: relative;left: 25px; }
        #adcontainer1{position: relative;left: 25px; top:-40px;}

		/*#setpage div a:link,#setpage div a:visited,#setpage div a:hover,.current,#info{
			border:1px solid #DDD;
			background:#F2F2F2;
			display:inline-block;
			margin:1px;
			text-decoration:none;
			font-size:22px;
			width:auto;
			height:25px;
			text-align:center;
			line-height:15px;
			color:#AAA;
			padding:1px 2px;
		}
		#setpage div a:hover{  border:1px solid #E5E5E5;  background:#F9F9F9;  }
		.current{  border:1px solid #83E7E4;  background:#DFF9F8;  margin:1px;  color:#27CBC7;  }
		#info{  width:auto;  }*/
		/*#list ul li#loading{width:120px; height:32px; border:1px solid #d3d3d3;
			position:absolute; top:35%; left:42%; text-align:center; background:#f7f7f7
		!*url(loading.gif)*! no-repeat 8px 8px;-moz-box-shadow:1px 1px 2px rgba(0,0,0,.2);
			-webkit-box-shadow:1px 1px 2px rgba(0,0,0,.2); box-shadow:1px 1px 2px rgba(0,0,0,.2);}*/



        #top_nav {
            padding-top: 5px;
            border-bottom: 1px solid #EBEBEB;
            background: #ffffff;
            padding-left: 110px;
            min-width: 320px;
            height: 56px;
        }

		#top_nav .navbar-nav li {
            padding-right: 15px;
            display: block;
            float: left;
        }

        #top_nav .navbar-nav li a {
            font-size: 13px;
            padding: 0 8px;
            height: 51px;
            line-height: 50px;
            color: #777;
            position: relative;
            display: block;
            text-decoration: none;
            font-size: 13px;
        }

        #top_nav .navbar-nav {
            margin: 0;
            float: left;
        }
        .nav {
            padding-left: 66px;
            margin-bottom: 0;
            list-style: none;
        }

        #top_nav .navbar-nav li a.nav_active { color: #0084F9;font-weight: bold;border-bottom: 3px solid #0084F9; }
        #img_content {  background: #f1f1f1; }
        .image_info {
            visibility: hidden;
            background: none repeat scroll 0 0 rgba(51, 51, 51, 0.8);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 0 3px;
            font-size: 9px;
            color: #ffffff;
            text-align: left;
        }
	</style>
    <script>
        function Search(){
            $("#searchForm").submit();
        }
    </script>
</head>

<body class="home-template">
    <nav class="navbar navbar-default" style="margin-bottom: 0;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    <img src="/images/logo_nav.png"></a>
                <form class="navbar-form navbar-left" role="search" id="searchForm">
                    <div class="input-group ">
                        <input type="text"  class="form-control" maxlength="100" name="q" id="word" value="<!--{$kwd}-->">
                        <span class="input-group-btn">
                                <a href="javascript:Search()" id="click" class="btn btn-default " type="button"><img src="/images/ic_search.png"></a>
                            </span>
                        <input type="hidden" name="t" value="<!--{$searchType}-->">
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div id="top_nav" class="navbar-default wrap fieldspace load-show" >
        <div class="navbar-collapse collapse in">
            <ul class="nav navbar-nav fs_inner">
                <li><a href="<!--{$http_url}-->?q=<!--{$kwd}-->&t=web" class="<!--{if $searchType == 'web' }-->nav_active<!--{/if}-->" >Web</a></li>
                <li><a href="<!--{$http_url}-->?q=<!--{$kwd}-->&t=news" class="<!--{if $searchType == 'news' }-->nav_active<!--{/if}-->" >News</a></li>
                <li><a href="<!--{$http_url}-->?q=<!--{$kwd}-->&t=game" class="<!--{if $searchType == 'game' }-->nav_active<!--{/if}-->" >Game</a></li>
                <li><a href="<!--{$http_url}-->?q=<!--{$kwd}-->&t=img" class="<!--{if $searchType == 'img' }-->nav_active<!--{/if}-->" >Images</a></li>
                <li><a href="<!--{$http_url}-->?q=<!--{$kwd}-->&t=vid" class="<!--{if $searchType == 'vid' }-->nav_active<!--{/if}-->" >Video</a></li>
                <li><a href="<!--{$http_url}-->?q=<!--{$kwd}-->&t=shopping" class="<!--{if $searchType == 'shopping' }-->nav_active<!--{/if}-->">Shopping</a></li>
            </ul>
        </div>
    </div>
