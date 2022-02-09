$(document).ready(function ()
{
    $("form").submit(function ()
    {
        var regexp = "[A-Za-zА-Яа-яЁё]";
        if (regexp.test($("input[name='NAME']").val())) {

        }
        else {
        }
    });
});