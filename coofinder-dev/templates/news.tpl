<!--{include file="header.tpl"}-->

    <div id="dynamicContent" class="scx572" >
        <br>
        <div class='container-table scx402'>
            <div class='left scx428' style="min-width: 151px;">
                <div class=scx679></div>
            </div>
            <div class='middle scx361' style="width: 577px;">
                <table id='resultTable' class='resultTable scx831'>
                    <!--north ads start-->
                    <tr id="north-ads">
                        <td class='splink'></td>
                        <td class='splink'>
                            <div class='section-title scx736 north-goodness north-ads ads-table'></div>
                            <table id="north_ads_html" class='goodness-list scx830 north-ads ads-table'>
                               
                            </table>
                            <!--north related search start-->

                            <div class='section-title scx736 north-related'>Related searches for <b><!--{$kwd|limit_text:7}--></b></div>
                            <table class="scx741 north-related nrel">


                            </table>

                            <!--north related search end-->
                            <div class='section-title scx736 webresults' >News Results <!--{if isset($results_kwd)}-->for <b><!--{$results_kwd|limit_text:7}--></b><!--{/if}--></div>
                        </td>
                    </tr>
                    <!--north ads end-->

                    <!--news search start-->
                     <!--{if isset($newsList) && $newsList}-->
                    <!--{foreach $newsList as $ritem}-->
                    <tr id='trFor0' initialRank='0'>
                        <td class='position'></td>
                        <td>
                            <div class='scx449 search-result'><a class='activeLink' href='<!--{$ritem['Url']}-->' target='_blank' style="font-size: 16px;"><!--{$ritem['Title']}--></a>
                                <div class=scx372 id='img-wrapper'></div><br />
                                <span class='url scx232' style='width: 500px'><!--{$ritem['Source']}-->&nbsp;</span><br><span style="font-size:13px;"><!--{$ritem['Description']}--></span>
                            </div>
                        </td>
                    </tr>
                    <!--{/foreach}-->
                    <!--{/if}-->

                    

                        <tr>
                            <td class='splink'></td>
                            <td class='splink'>
                                <div class='section-title scx736 south-goodness south-ads'></div>
                                <table id="south_ads_html" class='goodness-list scx830 south-ads ads-table'>

                                   
                                </table>
                                <!--south related search start-->

                                <div class='section-title scx736 north-related'>Related searches for <b><!--{$kwd|limit_text:7}--></b></div>
                                <table class="scx741 north-related nrel">


                                </table>
                               
                                <!--south related search end-->
                            </td>
                        </tr>
                </table>
                <div class='scx479 pagination_html' style='margin: 15px 0 20px 5px; text-align: center'>
                  

                </div>
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- coofinder_728x90 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-3456478881457138"
     data-ad-slot="6179530408"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                
            </div>
            <div class='right scx273' <!--{if $is_capn}-->style="display: none;"<!--{/if}-->>
                <div id='right-content' class='right-content scx326'>
                    <div  class=scx843>
                        <div class='section-title scx736 east-goodness right-ads'></div>
                        <section id="advertiseWeb">
             <ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-3456478881457138"
     data-ad-slot="1749330801"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </section>
                        <table id="right_ads_html" class="goodness-list scx830   ads-table" >


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!--{include file="footer.tpl"}-->
    <br>
    <br>
    <div id="ad-params" style="display: none;"   data-kwd="<!--{$kwd}-->" data-stype="<!--{$searchType}-->" data-da="<!--{$debug_apiurl}-->"  ></div>






