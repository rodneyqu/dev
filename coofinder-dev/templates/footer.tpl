    <footer id="footer" class="footer hidden-print">
        <div class="container">
            <div class="row">
                <div class="font-icon-list col-xs-12 col-md-12 col-sm-12 col-lg-12">
                    <p style="text-align: center; font-size: 12px; color: #555; padding-top: 10px">
                        Copyright © 2016 <a href="<!--{$http_host}-->">COOFINDER</a>.All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>

        $(document).ready(function(){
            var iframe = document.getElementById("myframe");
            iframe.height = "900px";
            if( "<!--{$searchType}-->" =="web"){
                (adsbygoogle = window.adsbygoogle || []).push({});
                (adsbygoogle = window.adsbygoogle || []).push({});
                /*(adsbygoogle = window.adsbygoogle || []).push({});
                (adsbygoogle = window.adsbygoogle || []).push({});*/
                changeSrc();
            }else if("<!--{$searchType}-->"=="shopping"){
                (adsbygoogle = window.adsbygoogle || []).push({});
                (adsbygoogle = window.adsbygoogle || []).push({});
                (adsbygoogle = window.adsbygoogle || []).push({});
                (adsbygoogle = window.adsbygoogle || []).push({});


            }
        });

        function changeSrc() {
            /*var words = document.getElementById("word").value;
            var i;
            for(i=0;i<words.length;i++){
                if(words.charAt(i)!=" ") {
                    break;
                }
            }
            var word = words.substring(i,words.length);
            if(word==""||word==null){
                return ;
            }*/
            //changeWeb();
            var url = "/list-web.html?q=<!--{$kwd}-->";
            document.getElementById("myframe").src = url;
           // document.iframe['ifrmname'].location.reload();

        }


        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return decodeURIComponent(r[2].replace('+','%20').trim()); return null;
        }

        var q=getUrlParam('q');

        $.ajax({
            url: "http://api.bing.net/qson.aspx?Query=" + q + "&JsonType=callback&JsonCallback=?",
            dataType: "jsonp",

            success: function (data) {
                if('<!--{$searchType}-->'!='shopping'){
                    var rshtml='<tr>';
                }else{
                    var rshtml='<br />';
                }
                var i=10;

                var suggestions = [];
                $.each(data.SearchSuggestion.Section, function (index, val) {

                    if(index<i){
                        text = val.Text.replace(q, '<b>' + q + '</b>');
                        if('<!--{$searchType}-->'!='shopping'){
                            if (((index+1)&1) == 0){
                                rshtml+='<td ><a href="/s?q='+encodeURIComponent(val.Text)+'&t=<!--{$searchType}-->"  style="font-size: 15px;"  >'+text+'</a></td></tr><tr>';
                            }else{
                                rshtml+='<td ><a href="/s?q='+encodeURIComponent(val.Text)+'&t=<!--{$searchType}-->"  style="font-size: 15px;"  >'+text+'</a></td>';
                            }
                        }else{


                            rshtml+='<li><a style="font-weight:bold;" href="/s?q='+encodeURIComponent(val.Text)+'&t=<!--{$searchType}-->">'+text+'</a></li>';
                        }
                    }

                });
                $('.nrel').append(rshtml);
                if('<!--{$searchType}-->'!='shopping'){
                    $('.nrel').append('</tr>');
                }
            }
        });
    </script>


    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-75230026-1', 'auto');

        ga('send', 'pageview');
        try {
            $(document).ready(function(){
                $("click").click(function(){
                    ga('send', 'event', 'search', 'click ', 'Search');
                })
            })
        }catch(e) {
        }
    </script>


    </body>
</html>