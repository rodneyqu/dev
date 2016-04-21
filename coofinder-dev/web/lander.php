<html><head>
    <script type="text/javascript">
        document.domain = 'raaz.io';
        var p = {};
        try{
            if (parent.window.location.search)
            {
                var prms = parent.window.location.search.slice(1).split("&");
                for (var i = 0; i < prms.length; i++)
                {
                    var tmp = prms[i].split("=");
                    p[tmp[0]] = unescape(tmp[1]);
                }

                window.localStorage['ssp'] =  JSON.stringify(p);
            }else{
                setLocationSearch();
            }
        }catch (e){
            setLocationSearch();
        }


        function setLocationSearch(){
            if( window.location.search ){
                var prms = window.location.search.slice(1).split("&");
               for (var i = 0; i < prms.length; i++)
                {
                    var tmp = prms[i].split("=");
                    p[tmp[0]] = unescape(tmp[1]);
                }
                window.localStorage['ssp'] =  JSON.stringify(p);
            }
        }

    </script>

</head>
    <body>
    
</body></html>