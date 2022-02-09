$(document).ready(function(){
    $(document).on("change", ".smartfilter input, .smartfilter select", function(e){
        bxAjaxID = $(".smartfilter input[name=bxajaxid]").eq(0).val();
        if(bxAjaxID)
        {
            e.preventDefault();
            $(".smartfilter input[name=AJAX_CALL]").remove();
            param = $(".smartfilter").serialize();
            action = $(".smartfilter").attr("action");
            //param = getFilterParam(param);
            if(action.indexOf("?")>=0) url = action+"&"+param;
            else url = action+"?"+param;
            //url = action+param+"?bxajaxid="+bxAjaxID;
            BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
        }
    })

    $(document).on("submit", ".smartfilter", function(e){
        bxAjaxID = $(".smartfilter input[name=bxajaxid]").eq(0).val();
        if(bxAjaxID)
        {
            e.preventDefault();
            $(".smartfilter input[name=AJAX_CALL]").remove();
            param = $(".smartfilter").serialize();
            action = $(".smartfilter").attr("action");
            //param = getFilterParam(param);
            if(action.indexOf("?")>=0) url = action+"&"+param;
            else url = action+"?"+param;
            //url = action+param+"?bxajaxid="+bxAjaxID;
            BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
        }
    })

    function getFilterParam(param)
    {
        var filterPath = "f/";
        //arParam = param.split("&");

        $(".smartfilter .filter_block").each(function(){
            if($(this).find("input[type=checkbox]:checked").length>0)
            {
                _this = $(this).find("input[type=checkbox]:checked").eq(0);
                name = _this.attr("name").replace("[]", "");
                filterPath += name+"-";
                $(this).find("input[type=checkbox]:checked").each(function(i, v){
                    val = $(this).val()
                    if(i>0)filterPath += "-or-"+val;
                    else filterPath += val;
                    console.log("i="+i+"v="+v);
                })
                filterPath += "/";
            }
            console.log(filterPath);
        })

        return filterPath;
    }

})