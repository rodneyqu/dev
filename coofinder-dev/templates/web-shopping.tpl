<!--{if $shoppingResults|count>0}-->
<!--{foreach from=$shoppingResults key=key item=details}-->

<div class="" style="float:left;width:110px;height:175px;">
    <a href="<!--{$details.clickurl}-->" class="" title="" data-rurl="#" data="#" target="_blank"  style="text-decoration:none;">

        <div class="" style="" >

            <img src="<!--{$details.img}-->" alt="" style="margin-top:-18px;max-width: 100px;
    max-height: 100px;" height="100%" width="100%" class="thm">

        </div>

        <div class="" style="text-align:left;font-size:12px;font-weight:normal;width:100px" >
            <div style="height:36px;overflow:hidden;"><!--{$details.title}--></div>
            <div style="color:#006621;"><!--{$details.memcache}--></div>
            <div style="color:#777;" ><!--{$details.price}--></div>

        </div>
    </a>

</div>

<!--{/foreach}-->
<!--{/if}-->