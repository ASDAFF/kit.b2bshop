<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>


<div class="block_contacts_title hidden-xs">
    <div class="row">
        <div class="col-sm-12 col-sm-push-12">
            <?if($arParams["FEEDBACK_LEFT_COLUMN"] != "Y"):?>
            <div class="block_office_title"><?=GetMessage("ASK_QUESTION")?></div>
            <?endif;?>
        </div><!--end col-sm-12 -->

        <div class="col-sm-12 col-sm-pull-12">
            <div class="block_office_title"><?=GetMessage("OUR_CONTACTS")?></div>
        </div><!--end col-sm-12 -->

    </div> <!--end row-->
</div>
<div class="block_contacts">
    <div class="row">

        <div class="col-sm-12 col-sm-push-12">
            <?if($arParams["FEEDBACK_LEFT_COLUMN"] != "Y"):?>
            <div class="block_office_title visible-xs"><?=GetMessage("ASK_QUESTION")?></div>
            <div class="block_feedback">
                <div class="row">
                    <div class="col-sm-24">
                        <?$APPLICATION->IncludeComponent(
                            "kit:main.feedback",
                            "ms_feedback",
                            Array(
                                "USE_CAPTCHA" => $arParams["FEEDBACK_USE_CAPTCHA"],
                                "OK_TEXT" =>  $arParams["FEEDBACK_OK_TEXT"],
                                "EMAIL_TO" => $arParams["FEEDBACK_EMAIL_TO"],
                                "REQUIRED_FIELDS" => array("NAME", "EMAIL", "MESSAGE",'CONFIDENTIAL'),
                                "EVENT_MESSAGE_ID" => $arParams["FEEDBACK_EVENT_MESSAGE_ID"]
                            ),
                            $component
                            );
                        ?>

                    </div>
                </div>
            </div>
            <?endif;?>
            <div class="block_office_title visible-xs"><?=GetMessage("OUR_CONTACTS")?></div>
            <?if($arParams["MAP_NOT_SHOW"] != "Y"):?>
            <div class="block_map">
                <div class="map_point">
                    <?$APPLICATION->IncludeComponent("bitrix:map.yandex.view", "ms_contacts", Array(
                        "INIT_MAP_TYPE" => $arParams["INIT_MAP_TYPE"],    // ��������� ��� �����
                            "MAP_DATA" => "a:3:{s:10:\"yandex_lat\";s:7:\"55.7383\";s:10:\"yandex_lon\";s:7:\"37.5946\";s:12:\"yandex_scale\";i:".$arParams['MAP_SCALE'].";}",    // ������, ��������� �� �����
                            "MAP_WIDTH" => $arParams["MAP_WIDTH"],
                            "MAP_HEIGHT" => $arParams["MAP_HEIGHT"],
                            "CONTROLS" => $arParams["MAP_CONTROLS"],
                            "OPTIONS" => $arParams["MAP_OPTIONS"],
                            "MAP_ID" => $arParams["MAP_ID"],
                            "IBLOCK_ID_PLACEMARKS" => $arParams["IBLOCK_ID"],
                            "MAP_PROPERTY_PLACEMARKS" => $arParams["MAP_PROPERTY_PLACEMARKS"],
                            "MAP_PROPERTY_ICON" => $arParams["MAP_PROPERTY_ICON"],
                            "MAP_PROPERTY_TITLE" => $arParams["MAP_PROPERTY_TITLE"],
                            "MAP_PROPERTY_TEXT" => $arParams["MAP_PROPERTY_TEXT"],
                            "MAP_PLACE_CORDINATES" => $arParams["MAP_PLACE_CORDINATES"],
                            "MAP_YANDEX_LAN" => $arParams["MAP_YANDEX_LAN"],
                            "MAP_YANDEX_LON" => $arParams["MAP_YANDEX_LON"],
                            "SORT_BY1"    =>    $arParams["SORT_BY1"],
                            "SORT_ORDER1"    =>    $arParams["SORT_ORDER1"],
                            "SORT_BY2"    =>    $arParams["SORT_BY2"],
                            "SORT_ORDER2"    =>    $arParams["SORT_ORDER2"],
                        ),
                        $component
                    );?>
                </div>
            </div>
            <?endif;?>
        </div><!--end col-sm-12 -->


        <div class="col-sm-12 col-sm-pull-12">
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "",
                Array(
                	"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                    "IBLOCK_TYPE"    =>    $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID"    =>    $arParams["IBLOCK_ID"],
                    "NEWS_COUNT"    =>    $arParams["NEWS_COUNT"],
                    "SORT_BY1"    =>    $arParams["SORT_BY1"],
                    "SORT_ORDER1"    =>    $arParams["SORT_ORDER1"],
                    "SORT_BY2"    =>    $arParams["SORT_BY2"],
                    "SORT_ORDER2"    =>    $arParams["SORT_ORDER2"],
                    "FIELD_CODE"    =>    $arParams["LIST_FIELD_CODE"],
                    "PROPERTY_CODE"    =>    $arParams["LIST_PROPERTY_CODE"],
                    "DETAIL_URL"    =>    $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "DISPLAY_PANEL"    =>    $arParams["DISPLAY_PANEL"],
                    "SET_TITLE"    =>    $arParams["SET_TITLE"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN"    =>    $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "CACHE_TYPE"    =>    $arParams["CACHE_TYPE"],
                    "CACHE_TIME"    =>    $arParams["CACHE_TIME"],
                    "CACHE_FILTER"    =>    $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "DISPLAY_TOP_PAGER"    =>    $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER"    =>    $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE"    =>    $arParams["PAGER_TITLE"],
                    "PAGER_TEMPLATE"    =>    $arParams["PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALWAYS"    =>    $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_DESC_NUMBERING"    =>    $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME"    =>    $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "DISPLAY_DATE"    =>    $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME"    =>    "Y",
                    "DISPLAY_PICTURE"    =>    $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT"    =>    $arParams["DISPLAY_PREVIEW_TEXT"],
                    "PREVIEW_TRUNCATE_LEN"    =>    $arParams["PREVIEW_TRUNCATE_LEN"],
                    "ACTIVE_DATE_FORMAT"    =>    $arParams["LIST_ACTIVE_DATE_FORMAT"],
                    "USE_PERMISSIONS"    =>    $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS"    =>    $arParams["GROUP_PERMISSIONS"],
                    "FILTER_NAME"    =>    $arParams["FILTER_NAME"],
                    "HIDE_LINK_WHEN_NO_DETAIL"    =>    $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES"    =>    $arParams["CHECK_DATES"],
                    "MAP_ID" =>  $arParams["MAP_ID"],
                    "MAP_NOT_SHOW" => $arParams["MAP_NOT_SHOW"],
                    "MAP_PROPERTY_PLACEMARKS" => $arParams["MAP_PROPERTY_PLACEMARKS"],
                ),
                $component
            );?>

            <?if($arParams["FEEDBACK_LEFT_COLUMN"] == "Y"):?>
            <div class="block_office_title"><?=GetMessage("ASK_QUESTION")?></div>
            <div class="block_feedback">
                <div class="row">
                    <div class="col-sm-24">
                        <?$APPLICATION->IncludeComponent(
                            "kit:main.feedback",
                            "ms_feedback",
                            Array(
                                "USE_CAPTCHA" => $arParams["FEEDBACK_USE_CAPTCHA"],
                                "OK_TEXT" =>  $arParams["FEEDBACK_OK_TEXT"],
                                "EMAIL_TO" => $arParams["FEEDBACK_EMAIL_TO"],
                                "REQUIRED_FIELDS" => array("NAME", "EMAIL", "MESSAGE"),
                                "EVENT_MESSAGE_ID" => $arParams["FEEDBACK_EVENT_MESSAGE_ID"]
                            ),
                            $component
                            );
                        ?>

                    </div>
                </div>
            </div>
            <?endif;?>

        </div><!--end col-sm-12 -->


    </div> <!--end row-->
</div>