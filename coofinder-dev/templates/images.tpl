    <!--{include file="header.tpl"}-->
<!--{if $is_capn==1}-->

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

    <div id="img_content" class="img_class" style="padding: 15px 20px 0 20px;" >
       <!--{if isset($imagesList)}-->
            <!--{foreach $imagesList as $imgitem}-->
            <div style="float: left;margin: 4px;position: relative;" class="img_div" data-w='<!--{$imgitem['Thumbnail']['Width']}-->' data-h='<!--{$imgitem['Thumbnail']['Height']}-->'>
                <a href="<!--{$imgitem['SourceUrl']}-->" target="_blank">
                    
                    <!--{if $imgitem['Thumbnail']['MediaUrl']|strpos:'https'}-->
                    <img  src="<!--{$imgitem['Thumbnail']['MediaUrl']}-->" style="width: auto;">
                    <!--{else}-->
                    <img  src="<!--{"http"|str_replace:"https":$imgitem['Thumbnail']['MediaUrl']}-->" style="height: 100%;width: 100%;">
                    <!--{/if}-->
                </a>
            </div>
            <!--{/foreach}-->
        <!--{/if}-->


       

    </div>

        <div style="clear: both;" id="img_clear" ></div>
        <!--{if $is_capn}--> 
</div>
</div>
<!--{/if}--> 
    </div>
    <div class="img_click" style="text-align: center;margin-top: 5px;display: none;">
        <a id="img_click_a" href="javascript:void(0);" style="text-decoration: none;font-size: 20px;"><img src="/images/product-fleches.png"></a>
    </div>
    <div class="img_loader" style="text-align: center;margin-top: 5px;margin-bottom: 10px;display: none;">
        <img src="/images/ajax_loader.gif">
    </div>


    <!--{include file="footer.tpl"}-->
    <br>
    <br>
    <div id="ad-params" style="display: none;"   data-kwd="<!--{$kwd}-->" data-stype="<!--{$searchType}-->" data-da="<!--{$debug_apiurl}-->"  ></div>



    <script>

        var img_start = 0;
        var isLoading = false;
        var vid_start=0;
        align_imgs();


        if(getWindowHeights() == $(document).height() ){
           // showMoreImg();
        }


        <!--{if !$debug_apiurl}-->
        $(window).scroll(function () {
            /*if($(window).scrollTop() + getWindowHeights() == $(document).height()) {
                if (!isLoading ) {
                    isLoading = true;
                    $(".img_loader").show();
                    $.post(
                            "<!--{$http_url}-->get_image.php",
                            { kwd : '<!--{$kwd|urlencode}-->', num : 35, ind : img_start+35 , mob : 0},
                            function(html){
                                $(".img_loader").hide();
                                $("#img_clear").before(html);
                                align_imgs();
                                isLoading = false;
                                img_start = img_start+35;

                            },
                            'html'
                    );
                }
            }*/
        });
        <!--{/if}-->

        function showMoreImg(){
            $(".img_loader").show();
            if (!isLoading) {
                isLoading = true;
                $.post(
                        "<!--{$http_url}-->get_image.php",
                        { kwd : '<!--{$kwd|urlencode}-->', num : 35, ind : img_start+35 },
                        function(html){
                            $(".img_loader").hide();
                            $("#img_clear").before(html);
                            align_imgs();
                            isLoading = false;
                            img_start = img_start+35;
                        },
                        'html'
                );
            }
        }

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


        function align_imgs() {
            $('#img_content').flexImages({rowHeight: 165, container:'.img_div', truncate:0});
        }


    </script>






