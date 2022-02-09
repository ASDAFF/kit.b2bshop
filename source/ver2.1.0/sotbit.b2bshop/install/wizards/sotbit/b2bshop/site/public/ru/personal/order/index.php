<?
use Bitrix\Main\Loader;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Мои заказы");

if(!$USER->IsAuthorized())
{
	$APPLICATION->AuthForm('', false, false, 'N', false);
}
else
{
	?>
	<div id="title_personal">
		<div class="personal_block_title personal_block_title_reviews">
			<div class="col-sm-6">
				<h1 class="text">
					<?$APPLICATION->ShowTitle(false);?>
				</h1>
			</div>
			<div class="text_2">
				<?
				$currentPage = $APPLICATION->GetCurPage();
				$detailOrder = false;
				if(strpos($currentPage, 'detail/') !== false || strpos($currentPage, 'cancel/') !== false)
				{
					$detailOrder = true;
				}

				$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);

				if($nothing && $detailOrder)
				{
					?>
					<a href="<?=SITE_DIR?>personal/order/">В список заказов</a>
					<?php
				}
				else
				{
					if($nothing || isset($_REQUEST["filter_history"]))
					{?>
						<a href="<?=$currentPage?>?show_all=Y">Посмотреть все заказы</a>
					<?}
					if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y')
					{?>
						<a href="<?=$currentPage?>?filter_history=N">Посмотреть текущие заказы</a>
					<?}
					if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y')
					{?>
						<a href="<?=$currentPage?>?filter_history=Y">Посмотреть историю заказов</a>
					<?}
				}
				?>
			</div>
		</div>
		<div class="clear"></div>
	</div>

	<?php
	if(!Loader::includeModule('sotbit.b2bshop'))
	{
		return false;
	}

	$opt = new \Sotbit\B2BShop\Client\Shop\Opt();
	$menu = new \Sotbit\B2BShop\Client\Personal\Menu();

	?>
	<div class="personal-wrapper personal-order-wrapper personal-order-wrapper-fiz <?=($opt->hasAccess())?'personal-wrapper-access':''?>">
		<?php
		$Template = new \Sotbit\B2BShop\Client\Template\Main();
		$Template->includeBlock('template/personal/tabs.php');
		?>

		<div class="row border-profile border-profile-order border-profile-order-fiz">
			<?
			$Template->includeBlock('template/personal/leftblock.php');
			$APPLICATION->IncludeComponent(
				"bitrix:sale.personal.order",
				"ms_personal_order",
				array(
					"SEF_MODE" => "Y",
					"SEF_FOLDER" => SITE_DIR."personal/order/",
					"ORDERS_PER_PAGE" => "10",
					"PATH_TO_PAYMENT" => COption::GetOptionString("sotbit.b2bshop", "URL_PAYMENT", ""),
					"PATH_TO_BASKET" => COption::GetOptionString("sotbit.b2bshop", "URL_CART", ""),
					"SET_TITLE" => "Y",
					"SAVE_IN_SESSION" => "N",
					"NAV_TEMPLATE" => "catalog",
					"SHOW_ACCOUNT_NUMBER" => "Y",
					"PROP_1" => array(
					),
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"CACHE_GROUPS" => "Y",
					"CUSTOM_SELECT_PROPS" => array(
					),
					"HISTORIC_STATUSES" => array(
						0 => "F",
					),
					"STATUS_COLOR_N" => "gray",
					"STATUS_COLOR_P" => "yellow",
					"STATUS_COLOR_F" => "green",
					"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
					"IBLOCK_TYPE" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_TYPE", ""),
					"IBLOCK_ID" => COption::GetOptionString("sotbit.b2bshop", "IBLOCK_ID", ""),
					"OFFER_TREE_PROPS" => unserialize(COption::GetOptionString("sotbit.b2bshop", "OFFER_TREE_PROPS", "")),
					"OFFER_COLOR_PROP" => COption::GetOptionString("sotbit.b2bshop", "OFFER_COLOR_PROP", ""),
					"MANUFACTURER_ELEMENT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""),
					"MANUFACTURER_LIST_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MANUFACTURER_LIST_PROPS", ""),
					"PICTURE_FROM_OFFER" => COption::GetOptionString("sotbit.b2bshop", "PICTURE_FROM_OFFER", ""),
					"MORE_PHOTO_PRODUCT_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_PRODUCT_PROPS", ""),
					"MORE_PHOTO_OFFER_PROPS" => COption::GetOptionString("sotbit.b2bshop", "MORE_PHOTO_OFFER_PROPS", ""),
					"IMG_WIDTH" => "80",
					"IMG_HEIGHT" => "120",
					"ALLOW_INNER" => "Y",
					"ONLY_INNER_FULL" => "Y",
					"SEF_URL_TEMPLATES" => array(
						"list" => "index.php",
						"detail" => "detail/#ID#/",
						"cancel" => "cancel/#ID#/",
					)
				),
				false
			);?>
		</div>
	</div>
<?
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>