$(function(){
    var alChk_num =0;
    var alChk = setInterval(function(){

        if( $("#scx93245").length || alChk_num == 300){
            if( da == 1 ){
                console.log( "alChk_num:"+alChk_num );
            }
            clearInterval(alChk);
            getFromB();
        }

        alChk_num = alChk_num + 10;
    }, 10);
});

function getFromB(){
    if( $("#scx93245").length > 0 ){
        var ssp = $("#scx93245").attr("data-uid");
        var eui = $("#scx93245").attr("data-eui");
        var kw = $("#scx93245").attr("data-kw");
    }else{
        var ssp = $("#default_ssp").attr("data-ssp");
        var eui = '';
        var kw = '';
    }

    if( $("input[name='tp']").length > 0 ){
        var tp = $("input[name='tp']").val();
    }else{
        var tp = 'web';
    }
    
    var url = "/b.php";
    var params = {
        kwd : $("#ad-params").attr('data-kwd'),
        stype : $("#ad-params").attr('data-stype'),
        da : $("#ad-params").attr('data-da'),
        mob : 0,
        ssp : ssp,
        ref_url : ref_url,
        eui : eui,
        kw : kw,
        tp : tp
    };

    $.post(
        url,
        params,
        function(html){
            $("#safesearch-body").show();
            $("#dynamicContent").show();
            $(".img_class").show();
            $('#img_content').flexImages({rowHeight: 165, container:'.img_div', truncate:0});
            var k = $("#searchbox_textfield").val();
            $("#searchbox_textfield").val("").focus().val(k);
            if(html.status == 200){
                if( html.north_ads_html != '' ){
                    $("#north_ads_html").html(html.north_ads_html);
                    $(".north-ads").show();
                }
                if( html.south_ads_html != '' ){
                    $("#south_ads_html").html(html.south_ads_html);
                    $(".south-ads").show();
                }
                if( html.right_ads_html != '' ){
                    $("#right_ads_html").html(html.right_ads_html);
                    $(".right-ads").show();
                }
                
                if(html.img_ads_html != ''){
                    var img_ads_html = '<span style="position: absolute;right: 20px;color: #8C8C8C !important;">Ads</span>';
                    img_ads_html += html.img_ads_html;
                    img_ads_html += '<div style="clear: both;"></div>';
                    $(".img_ads").html(img_ads_html).show();
                }
               
                
                if( html.shopping_north_ads_html != '' ){
                    var  shopping_north_ads = html.shopping_north_ads_html;
                    shopping_north_ads += '<div style="clear: both;"></div>';
                    $(".shopping_north_ads").html(shopping_north_ads).show();         
                }
            }
        },
        "json"
    );
}