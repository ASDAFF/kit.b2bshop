<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$MicroArticle = [];

$MicroArticle['NAME'] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_NAME", ""), $arResult);
$MicroArticle['ARTICLEBODY'] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_DESCRIPTION", ""), $arResult);
$MicroArticle['ABOUT'] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_KRATKOE_OPISANIE", ""), $arResult);
$MicroArticle['IMAGEURL'] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_IMAGE", ""), $arResult);
$MicroArticle['TYPE'] = COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE", "");
$MicroArticle['LEARNING_RESOURCE_TYPE'] = COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_MATERIAL", "");
$MicroArticle['IN_LANGUAGE'] = COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_LANGUAGE", "");
$MicroArticle['ARTICLE_SECTION'] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_RUBRIKA", "")), $arResult);
$MicroArticle['GENRE'] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_GANR", ""), $arResult);
$MicroArticle['AUTHOR_TYPE'] = COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_AUTHOR", "");
$MicroArticle['COMPONENT_TEMPLATE'] = ".default";
$MicroArticle['PARAM_RATING_SHOW'] = "N";
$MicroArticle['SHOW'] = "Y";


$keywords = [];
$keys = explode(',', B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_KEYWORDS", ""), $arResult));
foreach ($keys as $key)
	array_push($keywords, trim($key));
$MicroArticle['KEYWORDS'] = $keywords;

$ArticleTime = explode('.', $arResult['ACTIVE_FROM']);
for ($i = count($ArticleTime) - 1; $i >= 0; --$i)
{
	if($i == 0)
		$MicroArticleDate .= $ArticleTime[$i];
	else
		$MicroArticleDate .= $ArticleTime[$i] . '-';
}

$MicroArticle['DATA_PUBLISHED'] = $MicroArticleDate;
if(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE", "") == "ScholarlyArticle" || COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE", "") == "SMedicalScholarlyArticle")
{
	$MicroArticle["SOURCE_TYPE"] = COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE_SOURCE", "");
	$MicroArticle["SOURCE_TYPE_URL_URL"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE_URL_ORIG", ""), $arResult);
	$MicroArticle["SOURCE_TYPE_URL_TEXT"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE_TEXT_ORIG", ""), $arResult);
	$MicroArticle["REFERENCES_URLS"] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE_URL_TEXT_ORIG_ONLINE", "")), $arResult);
	$MicroArticle["REFERENCES_TEXTS"] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_TYPE_URL_TEXT_ORIG_OFFLINE", "")), $arResult);
}
switch (COption::GetOptionString("kit.b2bshop", "MICRO_ARTICLE_AUTHOR", ""))
{
	case "Text":
		$MicroArticle["AUTHOR_PERSON_TEXT"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_TEXT", ""), $arResult);
		break;
	case "Person":
		$MicroArticle["AUTHOR_PERSON_ADDITIONALNAME"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_OTCHESTVO", ""), $arResult);
		$MicroArticle["AUTHOR_PERSON_EMAIL"] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_EMAIL", "")), $arResult);
		$MicroArticle["AUTHOR_PERSON_FAMILYNAME"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_FAMILIYA", ""), $arResult);
		$MicroArticle["AUTHOR_PERSON_IMAGEURL"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_URL_PHOTO", ""), $arResult);
		$MicroArticle["AUTHOR_PERSON_JOBTITLE"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_DOLGNOST", ""), $arResult);
		$MicroArticle["AUTHOR_PERSON_NAME"] = B2BSKit::ExpandStringWithMacros(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_NAME", ""), $arResult);
		$MicroArticle["AUTHOR_PERSON_PHONE"] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_PHONE", "")), $arResult);
		$MicroArticle["AUTHOR_PERSON_URL"] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_URL_STRANIC", "")), $arResult);
		$MicroArticle["AUTHOR_PERSON_URL_SAMEAS"] = B2BSKit::ExpandStringWithMacros(unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_PERSON_URL_OF_STRANIC", "")), $arResult);
		break;
	case "Organization":
		$MicroArticle["AUTHOR_ORGANIZATION_ADDRESS"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_ADDRESS", "");
		$MicroArticle["AUTHOR_ORGANIZATION_COUNTRY"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_STRANA", "");
		$MicroArticle["AUTHOR_ORGANIZATION_DESCRIPTION"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_DESCRIPTION", "");
		$MicroArticle["AUTHOR_ORGANIZATION_LOCALITY"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_CITY", "");
		$MicroArticle["AUTHOR_ORGANIZATION_NAME"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_NAME", "");
		$MicroArticle["AUTHOR_ORGANIZATION_PHONE"] = unserialize(COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_PHONE", ""));
		$MicroArticle["AUTHOR_ORGANIZATION_POST_CODE"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_POSTCODE", "");
		$MicroArticle["AUTHOR_ORGANIZATION_REGION"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_REGION", "");
		$MicroArticle["AUTHOR_ORGANIZATION_SITE"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_SITE", "");
		$MicroArticle["AUTHOR_ORGANIZATION_TYPE_2"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_TYPE2", "");
		$MicroArticle["AUTHOR_ORGANIZATION_TYPE_3"] = COption::GetOptionString("kit.b2bshop", "MICRO_ORGANIZATION_TYPE3", "");
		break;
}

$APPLICATION->IncludeComponent(
	"coffeediz:schema.org.Article",
	"",
	$MicroArticle
);

?>

<div class="news_left_column">
	<h2 class="title">
		<? if(!empty($arResult["SECTION"]["PATH"]["0"]["NAME"]))
		{
			echo $arResult["SECTION"]["PATH"]["0"]["NAME"];
		}
		else
		{
			echo $arResult["IBLOCK"]["NAME"];
		} ?>
	</h2>

	<div class="news_detail">
		<? if(($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]) || $arResult['FIELDS']['SHOW_COUNTER']): ?>
			<div class="wrap_top_info">
				<? if($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
					<span class="date"><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></span>
				<? endif; ?>
				<? if($arResult['FIELDS']['SHOW_COUNTER']): ?>
					<span class="look"><?= GetMessage("NEWS_SHOW_COUNTER") ?>:
                        <span id="countShow" class="countShow">
                        <? $frame = $this->createFrame()->begin(""); ?>
						<?= $arResult['FIELDS']['SHOW_COUNTER'] ?>
						<? $frame->end(); ?>
                        </span>
                    </span>
				<? endif; ?>
			</div>
		<? endif; ?>


		<? if($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
			<h1 class="title"><?= $arResult["NAME"] ?></h1>
		<? endif; ?>

		<div class="wrap_text">
			<? if(isset($arResult["VIDEO"]) && is_array($arResult["VIDEO"]) && count($arResult["VIDEO"]) > 0): ?>
				<? foreach ($arResult["VIDEO"] as $Video): ?>
					<?= $Video ?>
				<? endforeach; ?>
			<? endif; ?>

			<? if($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])): ?>
				<img
						class="img-responsive detail_picture"
						src="<?= $arResult["DETAIL_PICTURE"]["RESIZE"]["SRC"] ?>"
						width="<?= $arResult["DETAIL_PICTURE"]["RESIZE"]["WIDTH"] ?>"
						height="<?= $arResult["DETAIL_PICTURE"]["RESIZE"]["HEIGHT"] ?>"
						alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
						title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>"
				/>
			<? endif ?>

			<? if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arResult["FIELDS"]["PREVIEW_TEXT"]): ?>
				<?= $arResult["FIELDS"]["PREVIEW_TEXT"];
				unset($arResult["FIELDS"]["PREVIEW_TEXT"]); ?>
			<? endif; ?>

			<? if($arResult["NAV_RESULT"]): ?>
				<? if($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><br/><? endif; ?>
				<? echo $arResult["NAV_TEXT"]; ?>
				<? if($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br/><?= $arResult["NAV_STRING"] ?><? endif; ?>
			<? elseif(strlen($arResult["DETAIL_TEXT"]) > 0): ?>
				<? echo $arResult["DETAIL_TEXT"]; ?>
			<? else: ?>
				<? echo $arResult["PREVIEW_TEXT"]; ?>
			<? endif ?>

			<? foreach ($arResult["FIELDS"] as $code => $value):
				if($code == "SHOW_COUNTER")
				{
					continue;
				};
				if('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
				{
					?><?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?
					if(!empty($value) && is_array($value))
					{
						?><img border="0" src="<?= $value["SRC"] ?>" width="<?= $value["WIDTH"] ?>"
						       height="<?= $value["HEIGHT"] ?>"><?
					}
				}
				else
				{
					?><?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?= $value; ?><?
				}
				?><br/>
			<?endforeach;

			foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>
				<? if($pid == "FIRST") {
					continue;
				}; ?>
				<?= $arProperty["NAME"] ?>:&nbsp;
				<? if(is_array($arProperty["DISPLAY_VALUE"])):?>
					<?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
				<? else:?>
					<?= $arProperty["DISPLAY_VALUE"]; ?>
				<? endif ?>
				<br/>
			<? endforeach; ?>

		</div>


		<div class="row">
			<div class="col-sm-12">
				<a class="go_list" href="<?= $arResult['SECTION_URL']; ?>">
					<span><? if(!empty($arParams["DETAIL_BACK_LIST_TEXT"])) {
							echo $arParams["DETAIL_BACK_LIST_TEXT"];
						} else {
							echo GetMessage('NEWS_BACK_LIST');
						}; ?></span>
				</a>
			</div>

			<div class="col-sm-12">
				<div class="prop_text">
					<? if($arResult["DISPLAY_PROPERTIES"]["FIRST"]): ?>
						<p><?= $arResult["DISPLAY_PROPERTIES"]["FIRST"]["NAME"]; ?>: <a
									href="<?= $arResult["DISPLAY_PROPERTIES"]["FIRST"]["VALUE"]; ?>" target="_blank"
									rel="nofollow"><?= $arResult["DISPLAY_PROPERTIES"]["FIRST"]["SITE"]; ?></a></p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	newsCountShow('<?=$arResult["AJAX_URL"]?>', '<?=$arResult["ID"]?>');
</script>