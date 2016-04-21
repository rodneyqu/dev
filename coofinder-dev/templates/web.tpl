<!--{include file="header.tpl"}-->
<script>

    function reinitIframe() {
        var iframe = document.getElementById("myframe");
        iframe.height = "900px";
        try
        {
            var bHeight = iframe.contentWindow.document.body.scrollHeight;
            var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
            var height = Math.max(bHeight, dHeight);
            iframe.height = height+30;
            // iframe.height = bHeight+30;
        }
        catch (ex) {

        }
    }

</script>
<div id="dynamicContent" class="scx572" >
    <br>
    <div class='container-table scx402'>
        <div class='left scx428' style="min-width: 158px;">
            <div class=scx679></div>
        </div>
        <div class='middle scx361' style="width: 577px;">
            <iframe onload="Javascript:reinitIframe()" name="ifrmname" scrolling="no" id="myframe" src="" height="2000px" width="100%" frameborder="0" >
            </iframe>
            <div class='scx479 pagination_html' style='margin: 15px 0 20px 5px; text-align: center'>
            </div>
			<section>
				<ins class="adsbygoogle"
					 style="display:inline-block;width:728px;height:90px"
					 data-ad-client="ca-pub-3456478881457138"
					 data-ad-slot="6179530408"></ins>
			</section>

        </div>
        <div class='right scx273' >
        <div id='right-content' class='right-content scx326'>
            <div  class=scx843>
                <div class='section-title scx736 east-goodness'></div>
                <section id="advertiseWeb">
               <ins class="adsbygoogle"
					 style="display:inline-block;width:300px;height:600px"
					 data-ad-client="ca-pub-3456478881457138"
					 data-ad-slot="1749330801"></ins> 
		</section>
                <div id="right_shopping" style="width:350px;margin-top:25px;display: none;">
                </div>
                <table id="right_ads_html" class="goodness-list scx830  ads-table" >
                </table>
                </div>
        </div>
    </div>

</div>


<!--{include file="footer.tpl"}-->
