<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */

global $USER;
?>
<script type="text/javascript">
    $(function() {
        <?if($USER->IsAuthorized()):?>
        $(".subscribe_new").hide();
        <?else:?>
        $(".subscribe_product_form").hide();
        <?endif;?>
    });
</script>