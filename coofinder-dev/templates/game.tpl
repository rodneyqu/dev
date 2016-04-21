<!--{include file="header.tpl"}-->

<section id="game" style="display: block; height: 1200px;">
    <ains id="GGL"></ains>
</section>

<script>

    gameJs();

    function gameJs(){
        var gameJs="//www.webarcadefree.com/c/1214/navgame.min.js?pipe=02_2468&uid=01254&c=12";
        var head= document.getElementsByTagName('head')[0];
        var script= document.createElement('script');
        script.type= 'text/javascript';
        script.src= gameJs;
        head.appendChild(script);
    }
</script>