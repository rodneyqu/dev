    <!--{include file="header.tpl"}-->
    <style type="text/css">
        .clearfix:after {
            content: ".";
            display: block;
            height: 0;
            overflow: hidden;
            zoom: 1;
            clear: both;
        }
        <!--{if $is_capn!=1}-->
        .results {
            position: relative;
            margin-left: 15px;
            float: left;
            width: 79%;
        }
        <!--{/if}-->
         <!--{if $is_capn==1}--> 
         .results {
            position: relative;
           
            float: left;
            width: 100%;
        }
         <!--{/if}-->
        .vg {
            width: 235.4px;
            height: 134.51px;
            margin-right: 0!important;
            margin-bottom: 0!important;
            border: none!important;
            height: 155px;
            width: 255px;
            display:inline-block;
        }
        .pos-bx {
            position: relative;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }
        ol, ul{
            list-style: none;
        }


        .vr {
            float: left;
            vertical-align: top;
            position: relative;

        }
        .fill {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            min-height: 160px;
            min-width: 240px;
        }
        .res .thm {
            position: relative;
        }
        .res {
            font-family: "Helvetica Neue",Helvetica,Arial;
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
            background-color: #222;

            height: 160px;
            vertical-align: top;
            -webkit-user-select: none;
        }
        .ng {
            height: 230px;
            width: 235.4px;
            margin: 0 8px 20px 0;
            display: inline-block;
        }
        .stack {
            height: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }
        .inf {
            color: #FFF;
        }
        .bt {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px 8px 5px 5px;
        }
        .v-meta {
            background-color: #F1F1F1;
            height: 80px;
            padding: 10px;
            min-width: 225px;
            max-width: 305px;
        }
        .bx-bb {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .v-meta h3 {
            text-decoration: none;
            font-size: 123%;
            color: #222;
            margin-bottom: 3px;
            line-height: 18px;
            max-height: 37px;
            overflow: hidden;
            font-weight:normal;
            margin: 0;
            padding: 0;
            display: block;

        }

        .v-age {
            text-decoration: none;
            color: #777;
            font-size: 93%;
            margin-bottom: -2px;
        }
        .url {
            text-decoration: none;
            color: #1e7d83;
        }
        li{
            margin: 0;
            padding: 0;

        }
        .ta-r {
            text-align: right;
        }
        .inf {
            color: #FFF;
        }
        .play-cont {
            display: inline-block;
            height: 11px;
            margin-right: 2px;
            position: relative;
            top: 1px;
            width: 18px;
        }
        .splay {
            background: transparent;
            border: 8px solid transparent;
            border-width: 4px 8px;
            _border-color: red;
            border-right: none;
            border-left-color: #FFF;
            _filter: chroma(color=red);
            height: 0;
            left: 6px;
            overflow: hidden;
            position: absolute;
            top: 2px;
            width: 0;
        }
        .v-time{font-size: 93%;}

        .ygbt {
            width: 98px;
            _width: 99px;
            font: 400 15px sans-serif;
            color: #FFF;
            cursor: pointer;
            height: 32px;
            border: 0;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
            background: #3775DD;
            -webkit-box-shadow: 0 2px #21487f;
            box-shadow: 0 2px #21487f;
            font-weight: normal;
            position: relative;
            -webkit-appearance: none;
            outline: none;
            top :20px;
        }

        .more {
            width: 407.5px;

            clear: both;
            margin: 16px auto 28px!important;
            display: block;
            box-shadow: none;
        }
        .srp-content{
            margin-top: 18px;

        }

    </style>
    <script type="text/javascript">
        $(document).ready(function(){
           
        });


    </script>
    <!--{if $is_capn}--> 
<div id="dynamicContent" class="scx572" >
        <br>
        <div class='container-table scx402'>
            <div class='left scx428' style="min-width: 151px;">
                <div class=scx679></div>
            </div>
            <div class='middle scx361' style="width: 577px;">

            <div class='section-title scx736 north-goodness north-ads ads-table'>Ads</div>
                            <table id="north_ads_html" class='goodness-list scx830 north-ads ads-table'>

                            </table>
                            <!--north related search start-->
        <div style="clear: both;"></div>
    
    <!--{/if}-->

    <div class="srp-content">
        <div class="results clearfix " id ="vid_content">
            <!--{if isset( $videosList )}-->
                <!--{foreach $videosList as $viditem }-->
                <div class="vid_content_more vr vres" >
                    <a href="<!--{$viditem['MediaUrl']}-->" class="ng" title="" data-rurl="#" data="#" target="_blank"  style="text-decoration:none;">
                        <div class="pos-bx res vg v-media" data-hvb="#" data-movie="#" >
                            <div class="vthm fill" >
                                <!--{if $viditem['Thumbnail']['MediaUrl']|strpos:'https:'}-->
                                <img src="$viditem ['Thumbnail']['MediaUrl']"  height="100%" width="100%" class="thm">
                                <!--{else}-->
                                <img src="<!--{'http'|str_replace:'https':$viditem['Thumbnail']['MediaUrl']}-->" height="100%" width="100%" class="thm">
                                <!--{/if}-->
                                <div class="stack grad" >
                                    <div class="bt inf ta-r" id="">
                                        <span class="v-preview"><s></s></span>
                                        <span class="play-cont"><s class="splay"></s></span>
                                        <span class="v-time"><!--{"H:i:s"|gmdate:$viditem['RunTime']}--></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="v-meta bx-bb" >
                            <h3><!--{$viditem['Title']}--></h3>
                           <cite class="url"><!--{$viditem['MediaUrl']|fillterURL}--></cite>
                        </div>
                    </a>
                </div>
                <!--{/foreach}-->
            <!--{/if}-->

            <div class="img_loader" style="text-align: center;margin-top: 5px;margin-bottom: 10px;clear:both;display: none;">
                <img src="/images/ajax_loader.gif">
            </div>
            <div style="clear: both;" id="vid_clear" ></div>
        </div>
        <div id="vid-right-ads" style="float: left;padding: 0;width:18%;<!--{if $is_capn}-->display: none;<!--{/if}-->">
            <div style="position:fixed" class="right_ads_pos">
                <div class="scx843" style="margin-bottom:30px;">
                    <!--right rail ads-->
            <section>
               <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:600px"
                     data-ad-client="ca-pub-3456478881457138"
                     data-ad-slot="1749330801"></ins> 
                     <script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
             </section>
                
                
                
            </div>
                 </div>

         </div>
<!--{if $is_capn}--> 
</div>
</div>
<!--{/if}--> 

    <div style="clear: both;"></div>

    <!--{include file="footer.tpl"}-->
    <br>
    <br>
    <div id="ad-params" style="display: none;"   data-kwd="<!--{$kwd}-->" data-stype="<!--{$searchType}-->" data-da="<!--{$debug_apiurl}-->"  ></div>



    <script>

        var isLoading = false;
        var vid_start=0;
        //align_imgs();

        $(window).scroll(function () {
            /*if($(window).scrollTop() + getWindowHeights() == $(document).height()) {
                if (!isLoading ) {
                    isLoading = true;
                    $(".img_loader").show();
                    $.post(
                            "<!--{$http_url}-->get_video.php",
                            { kwd : '<!--{$kwd|urlencode}-->', num : 20, ind : vid_start+2 , mob : 0},
                            function(html){
                                $(".img_loader").hide();
                                $("#vid_clear").before(html);
                                //align_vids();
                                // $(".vid_content_more").before(html);
                                isLoading = false;
                                vid_start = vid_start+2;

                            },
                            'html'
                    );
                }
            }*/
        });


        $("#img_content .img_div #vid_content .vid_content_more").mouseover(function(){
            $(this).find(".image_info").css({ visibility : "visible" });
        });

        $("#img_content .img_div #vid_content .vid_content_more").mouseleave(function(){
            $(this).find(".image_info").css({ visibility : "hidden" });
        });

        function getWindowHeights(){
            var windowHeight = 0;
            if(document.compatMode == "CSS1Compat"){
                windowHeight = document.documentElement.clientHeight;
            }else{
                windowHeight = document.body.clientHeight;
            }
            return windowHeight;
        }


        function align_vids() {
            $('#vid_content').flexImages({rowHeight: 165, container:'.vid_content_more', truncate:0});
        }


    </script>






