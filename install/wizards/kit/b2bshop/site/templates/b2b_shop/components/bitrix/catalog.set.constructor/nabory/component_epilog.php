<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;

$loadCurrency = Loader::includeModule('currency');


?>
<script type="text/javascript">
	//BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
</script>