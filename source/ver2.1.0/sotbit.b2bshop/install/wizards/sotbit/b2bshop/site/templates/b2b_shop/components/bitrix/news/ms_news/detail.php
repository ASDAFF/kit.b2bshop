<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="main_inner_title title_center">
	<h2 class="text">
		<? if($arParams["DISPLAY_PAGE_TITLE_TEXT"])
		{
			echo $arParams["DISPLAY_PAGE_TITLE_TEXT"];
		}
		else
		{
			echo $arResult["IBLOCK_NAME"];
		}

		if($arParams["DISPLAY_PAGE_TITLE_TEXT_SECOND"])
		{
			echo " <span>" . $arParams["DISPLAY_PAGE_TITLE_TEXT_SECOND"] . "</span>";
		} ?>
	</h2>
</div>

<div class="page_news">
	<div class="filter_news">
		<? $cur_page = $APPLICATION->GetCurPage(false);
		$arCur_page = explode("/", $cur_page);
		$CurDir = "/" . $arCur_page['1'] . "/" . $arCur_page['2'] . "/";
		foreach ($arResult["ALL_SECTION"] as $arSection): ?>
			<a class="link_section <? if($CurDir == $arSection["SECTION_PAGE_URL"]): ?>link_active<? endif; ?>"
			   href="<?= $arSection['SECTION_PAGE_URL'] ?>"><?= $arSection['NAME'] ?></a>
		<? endforeach; ?>
		<a class="link_section <? if($cur_page == $arResult["FOLDER"]): ?>link_active<? endif; ?>"
		   href="<?= $arResult["FOLDER"] ?>"><?= GetMessage('NEWS_CATEGORIES_ALL'); ?></a>
	</div>
	<div class="row">
		<div class="col-sm-18 col-lg-17 ">
			<div class="news_left_column">
				<? $ElementID = $APPLICATION->IncludeComponent(
					"bitrix:news.detail",
					"",
					[
						"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
						"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
						"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
						"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
						"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
						"META_KEYWORDS" => $arParams["META_KEYWORDS"],
						"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
						"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
						"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
						"SET_TITLE" => $arParams["SET_TITLE"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
						"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
						"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
						"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
						"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
						"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
						"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
						"CHECK_DATES" => $arParams["CHECK_DATES"],

						"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
						"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
						"IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
						"DETAIL_HEIGHT_IMG" => $arParams["DETAIL_HEIGHT_IMG"],
						"DETAIL_WIDTH_IMG" => $arParams["DETAIL_WIDTH_IMG"],
						"DETAIL_BACK_LIST_TEXT" => $arParams["DETAIL_BACK_LIST_TEXT"],
					],
					$component
				);

				if($arParams["USE_RATING"] == "Y" && $ElementID)
				{
					$APPLICATION->IncludeComponent(
						"bitrix:iblock.vote",
						"",
						[
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_ID" => $ElementID,
							"MAX_VOTE" => $arParams["MAX_VOTE"],
							"VOTE_NAMES" => $arParams["VOTE_NAMES"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
						],
						$component
					);
				}
				if($arParams["USE_CATEGORIES"] == "Y" && $ElementID)
				{
					global $arCategoryFilter;
					$obCache = new CPHPCache;
					$strCacheID = $componentPath . LANG . $arParams["IBLOCK_ID"] . $ElementID . $arParams["CATEGORY_CODE"];
					if($arParams["CACHE_TYPE"] == "N" || $arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N")
					{
						$CACHE_TIME = 0;
					}
					else
					{
						$CACHE_TIME = $arParams["CACHE_TIME"];
					}
					if($obCache->StartDataCache($CACHE_TIME, $strCacheID, $componentPath))
					{
						$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $ElementID, "sort", "asc", [
							"ACTIVE" => "Y",
							"CODE" => $arParams["CATEGORY_CODE"]
						]);
						$arCategoryFilter = [];
						while ($arProperty = $rsProperties->Fetch())
						{
							if(is_array($arProperty["VALUE"]) && count($arProperty["VALUE"]) > 0)
							{
								foreach ($arProperty["VALUE"] as $value)
									$arCategoryFilter[$value] = true;
							}
							elseif(!is_array($arProperty["VALUE"]) && strlen($arProperty["VALUE"]) > 0)
								$arCategoryFilter[$arProperty["VALUE"]] = true;
						}
						$obCache->EndDataCache($arCategoryFilter);
					}
					else
					{
						$arCategoryFilter = $obCache->GetVars();
					}
					if(count($arCategoryFilter) > 0)
					{
						$arCategoryFilter = [
							"PROPERTY_" . $arParams["CATEGORY_CODE"] => array_keys($arCategoryFilter),
							"!" . "ID" => $ElementID,
						];
						?>
						<hr/><h3><?= GetMessage("CATEGORIES") ?></h3>
						<?
						foreach ($arParams["CATEGORY_IBLOCK"] as $iblock_id)
						{
							$APPLICATION->IncludeComponent(
								"bitrix:news.list",
								$arParams["CATEGORY_THEME_" . $iblock_id],
								[
									"IBLOCK_ID" => $iblock_id,
									"NEWS_COUNT" => $arParams["CATEGORY_ITEMS_COUNT"],
									"SET_TITLE" => "N",
									"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
									"CACHE_TYPE" => $arParams["CACHE_TYPE"],
									"CACHE_TIME" => $arParams["CACHE_TIME"],
									"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
									"FILTER_NAME" => "arCategoryFilter",
									"CACHE_FILTER" => "Y",
									"DISPLAY_TOP_PAGER" => "N",
									"DISPLAY_BOTTOM_PAGER" => "N",
								],
								$component
							);
						}
					}
				}
				if($arParams["USE_REVIEW"] == "Y" && IsModuleInstalled("forum") && $ElementID): ?>
					<hr/>
					<? $APPLICATION->IncludeComponent(
						"bitrix:forum.topic.reviews",
						"",
						[
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
							"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
							"PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
							"FORUM_ID" => $arParams["FORUM_ID"],
							"URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
							"SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
							"DATE_TIME_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
							"ELEMENT_ID" => $ElementID,
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"POST_FIRST_MESSAGE" => $arParams["POST_FIRST_MESSAGE"],
							"URL_TEMPLATES_DETAIL" => $arParams["POST_FIRST_MESSAGE"] === "Y" ? $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"] : "",
						],
						$component
					); ?>
				<? endif ?>
				<div class="news-comments">
					<? $APPLICATION->IncludeComponent(
						"sotbit:reviews",
						"bootstrap",
						[
							"ADD_REVIEW_PLACE" => "1",
							"BUTTON_BACKGROUND" => "url('" . SITE_DIR . "bitrix/components/sotbit/reviews.comments.add/templates/bootstrap/images/button.jpg') left top no-repeat #dbbfb9",
							"CACHE_TIME" => "36000000",
							"CACHE_TYPE" => "A",
							"COMMENTS_TEXTBOX_MAXLENGTH" => "200",
							"DATE_FORMAT" => "d.m.Y H:i:s",
							"DEFAULT_RATING_ACTIVE" => "3",
							"FIRST_ACTIVE" => "2",
							"ID_ELEMENT" => $ElementID,
							"INIT_JQUERY" => "N",
							"MAX_RATING" => "5",
							"NOTICE_EMAIL" => "",
							"PRIMARY_COLOR" => "#a76e6e",
							"QUESTIONS_TEXTBOX_MAXLENGTH" => "200",
							"REVIEWS_TEXTBOX_MAXLENGTH" => "200",
							"SHOW_COMMENTS" => "Y",
							"SHOW_QUESTIONS" => "N",
							"SHOW_REVIEWS" => "N"
						]
					); ?>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-lg-offset-1">
			<div class="news_right_column">
				<? $APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"ms_popular",
					[
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"NEWS_COUNT" => $arParams["POPULAR_NEWS_COUNT"],
						"SORT_BY1" => $arParams["POPULAR_SORT_BY1"],
						"SORT_ORDER1" => $arParams["POPULAR_SORT_ORDER1"],
						"SORT_BY2" => $arParams["POPULAR_SORT_BY2"],
						"SORT_ORDER2" => $arParams["POPULAR_SORT_ORDER2"],
						"FIELD_CODE" => "",
						/*$arParams["LIST_FIELD_CODE"]*/
						"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
						"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
						"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
						"SET_TITLE" => "N",
						"SET_STATUS_404" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => 'N',
						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
						"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
						"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
						"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
						"FILTER_NAME" => $arParams["FILTER_NAME"],
						"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
						"CHECK_DATES" => $arParams["CHECK_DATES"],
						"LIST_GO_DETAIL_PAGE" => $arParams["POPULAR_GO_DETAIL_PAGE"],
						"POPULAR_TITLE" => $arParams["POPULAR_TITLE"],
						"DISPLAY_DATE" => $arParams["POPULAR_DISPLAY_DATE"],
						"DISPLAY_NAME" => 'Y',
						"POPULAR_DISPLAY_SECTION" => $arParams["POPULAR_DISPLAY_SECTION"],
						"DISPLAY_PICTURE" => $arParams["POPULAR_DISPLAY_PICTURE"],
						"POPULAR_HEIGHT_IMG" => $arParams["POPULAR_HEIGHT_IMG"],
						"POPULAR_WIDTH_IMG" => $arParams["POPULAR_WIDTH_IMG"],
						"DISPLAY_PREVIEW_TEXT" => $arParams["POPULAR_DISPLAY_PREVIEW_TEXT"],
						"PREVIEW_TRUNCATE_LEN" => $arParams["POPULAR_TRUNCATE_LEN"],

					],
					$component
				); ?>
			</div>
		</div>
	</div>
</div>