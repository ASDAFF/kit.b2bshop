$(document).ready(function(){  
    $(document).on("change", ".block-pagination select", function(){
        form = $(this).parents(".block-pagination").eq(0).parents("form").eq(0);
        ajaxID = form.find("[name=bxajaxid]").attr("id");
        ajaxValue = form.find("[name=bxajaxid]").attr("value");
        var obForm = top.BX(ajaxID).form;
        BX.ajax.submitComponentForm(obForm, 'comp_'+ajaxValue, false);
        BX.submit(obForm, "save", "Y", function(){
            //ajaxFunction();
        });
    });
});