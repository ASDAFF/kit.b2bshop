<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $USER; ?>
<?$this->initComponentTemplate(); ?>
<?$frame = $this->__template->createFrame()->begin();?>
<script type="text/javascript">
    $(function() {
        <?if($USER->IsAuthorized()):?>
        $(".gift-product-wrapper .subscribe_new").hide();
        <?else:?>
        $(".gift-product-wrapper .subscribe_product_form").hide();
        <?endif;?>
    });
</script>
<?$frame->beginStub();?>
<?$frame->end();?>