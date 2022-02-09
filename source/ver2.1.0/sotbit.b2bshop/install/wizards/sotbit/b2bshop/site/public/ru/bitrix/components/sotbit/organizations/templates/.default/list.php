<?php 
use Bitrix\Main\Localization\Loc;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<div class="org-add-wrapper">
	<div class="org-add">
		<div class="org-add-inner">
			<a href="<?=$arResult['PATH_TO_ADD']?>"><?=Loc::getMessage('SPOL_ADD')?></a>
		</div>
	</div>
</div>

<?php

$APPLICATION->IncludeComponent( "bitrix:sale.personal.profile.list", "b2b_profile",
		array(
				"PATH_TO_DETAIL" => $arParams['PATH_TO_DETAIL'],
				"PATH_TO_DELETE" => $arParams['PATH'].$arParams['PATH_TO_DELETE'],
				"PER_PAGE" => 50,
				"SET_TITLE" => 'N',
				"GRID_HEADER" => array(
						array("id"=>"ID", "name"=>Loc::getMessage('SOTBIT_ORGANIZATIONS_ID'), "sort"=>"ID", "default"=>true, "editable"=>false),
						array("id"=>"NAME", "name"=>Loc::getMessage('SOTBIT_ORGANIZATIONS_NAME'), "sort"=>"NAME", "default"=>true, "editable"=>false),
						array("id"=>"DATE_UPDATE", "name"=>Loc::getMessage('SOTBIT_ORGANIZATIONS_DATE_UPDATE'), "sort"=>"DATE_UPDATE", "default"=>true, "editable"=>false),
						array("id"=>"PERSON_TYPE_NAME", "name"=>Loc::getMessage('SOTBIT_ORGANIZATIONS_PERSON_TYPE_NAME'), "sort"=>"PERSON_TYPE_ID", "default"=>true, "editable"=>true),
				),
		), $component );
?>