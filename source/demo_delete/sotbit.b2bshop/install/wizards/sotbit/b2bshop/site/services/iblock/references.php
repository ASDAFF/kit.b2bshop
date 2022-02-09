<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!IsModuleInstalled("highloadblock") && file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/highloadblock/"))
{
	$installFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/highloadblock/install/index.php";
	if (!file_exists($installFile))
		return false;

	include_once($installFile);

	$moduleIdTmp = str_replace(".", "_", "highloadblock");
	if (!class_exists($moduleIdTmp))
		return false;

	$module = new $moduleIdTmp;
	if (!$module->InstallDB())
		return false;
	$module->InstallEvents();
	if (!$module->InstallFiles())
		return false;
}

if (!CModule::IncludeModule("highloadblock"))
	return;


if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return; 
 
 
//массив создания справочников    
$arrCreateHL = array(
    'B2BSCOLOR' => array(
        'NAME' => 'B2BSCOLOR',
        'TABLE_NAME' => 'b2bshop_color_reference',    
    ),
    'B2BSRAZMER' => array(
        'NAME' => 'B2BSRAZMER',
        'TABLE_NAME' => 'b2bshop_ramzer_reference',    
    ),     
);  

$arrCreateHLitem = array(
    'B2BSCOLOR' => array(
        "MARENGO" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_MARENGO"),"UF_XML_ID" => "MARENGO","UF_DESCRIPTION" => "#4C5866"),
        "TEMNO_SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_TEMNO_SINIY"),"UF_XML_ID" => "TEMNO_SINIY","UF_DESCRIPTION" => "#002137"),
        "LNYANOY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_LNYANOY"),"UF_XML_ID" => "LNYANOY","UF_DESCRIPTION" => "#FAF0E6"),
        "BARVINOK_KRAYOLA" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BARVINOK_KRAYOLA"),"UF_XML_ID" => "BARVINOK_KRAYOLA","UF_DESCRIPTION" => "#C5D0E6"),
        "KRASNYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_KRASNYY"),"UF_XML_ID" => "KRASNYY","UF_DESCRIPTION" => "#FF0000"),
        "SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SINIY"),"UF_XML_ID" => "SINIY","UF_DESCRIPTION" => "#3c4469"),
        "SERYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SERYY"),"UF_XML_ID" => "SERYY","UF_DESCRIPTION" => "#9C9C9C"),
        "CHERNYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_CHERNYY"),"UF_XML_ID" => "CHERNYY","UF_DESCRIPTION" => "#000000"),
        "BLESTYASHCHIY_PURPURNO_SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BLESTYASHCHIY_PURPURNO_SINIY"),"UF_XML_ID" => "BLESTYASHCHIY_PURPURNO_SINIY","UF_DESCRIPTION" => "#62639B"),
        "ANTRATSITOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_ANTRATSITOVYY"),"UF_XML_ID" => "ANTRATSITOVYY","UF_DESCRIPTION" => "#464451"),
        "BEZHEVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BEZHEVYY"),"UF_XML_ID" => "BEZHEVYY","UF_DESCRIPTION" => "#ded7cf"),
        "GRAFITOVYY_SERYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_GRAFITOVYY_SERYY"),"UF_XML_ID" => "GRAFITOVYY_SERYY","UF_DESCRIPTION" => "#474A51"),
        "VASILKOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_VASILKOVYY"),"UF_XML_ID" => "VASILKOVYY","UF_DESCRIPTION" => "#6494ED"),
        "BELYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BELYY"),"UF_XML_ID" => "BELYY","UF_DESCRIPTION" => "#FFFFFF"),
        "ZELENOVATO_GOLUBOY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_ZELENOVATO_GOLUBOY"),"UF_XML_ID" => "ZELENOVATO_GOLUBOY","UF_DESCRIPTION" => "#0a484f"),
        "SEREBRISTO_SERYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SEREBRISTO_SERYY"),"UF_XML_ID" => "SEREBRISTO_SERYY","UF_DESCRIPTION" => "#8A9597"),
        "GRAFITNO_CHYERNYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_GRAFITNO_CHYERNYY"),"UF_XML_ID" => "GRAFITNO_CHYERNYY","UF_DESCRIPTION" => "#1C1C1C"),
        "KORICHNEVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_KORICHNEVYY"),"UF_XML_ID" => "KORICHNEVYY","UF_DESCRIPTION" => "#964B00"),
        "SVETLO_SERYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SVETLO_SERYY"),"UF_XML_ID" => "SVETLO_SERYY","UF_DESCRIPTION" => "#D7D7D7"),
        "SLONOVAYA_KOST" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SLONOVAYA_KOST"),"UF_XML_ID" => "SLONOVAYA_KOST","UF_DESCRIPTION" => "#FFFFF0"),
        "BARVINKOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BARVINKOVYY"),"UF_XML_ID" => "BARVINKOVYY","UF_DESCRIPTION" => "#CCCCFF"),
        "NEBESNO_SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_NEBESNO_SINIY"),"UF_XML_ID" => "NEBESNO_SINIY","UF_DESCRIPTION" => "#2271B3"),
        "CHERNILNO_SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_CHERNILNO_SINIY"),"UF_XML_ID" => "CHERNILNO_SINIY","UF_DESCRIPTION" => "#323f7b"),
        "LAZURNYY_KRAYOLA" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_LAZURNYY_KRAYOLA"),"UF_XML_ID" => "LAZURNYY_KRAYOLA","UF_DESCRIPTION" => "#1DACD6"),
        "ZELENYY_TEMNYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_ZELENYY_TEMNYY"),"UF_XML_ID" => "ZELENYY_TEMNYY","UF_DESCRIPTION" => "#203A27"),
        "BIRYUZOVO_GOLUBOY_KRAYOLA" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BIRYUZOVO_GOLUBOY_KRAYOLA"),"UF_XML_ID" => "BIRYUZOVO_GOLUBOY_KRAYOLA","UF_DESCRIPTION" => "#77DDE7"),
        "GLUBOKIY_ORANZHEVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_GLUBOKIY_ORANZHEVYY"),"UF_XML_ID" => "GLUBOKIY_ORANZHEVYY","UF_DESCRIPTION" => "#C34D0A"),
        "ZHELTYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_ZHELTYY"),"UF_XML_ID" => "ZHELTYY","UF_DESCRIPTION" => "#FFFF00"),
        "ROZOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_ROZOVYY"),"UF_XML_ID" => "ROZOVYY","UF_DESCRIPTION" => "#FFC0CB"),
        "SVETLO_FIOLETOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SVETLO_FIOLETOVYY"),"UF_XML_ID" => "SVETLO_FIOLETOVYY","UF_DESCRIPTION" => "#876C99"),
        "VINNO_KRASNYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_VINNO_KRASNYY"),"UF_XML_ID" => "VINNO_KRASNYY","UF_DESCRIPTION" => "#5E2129"),
        "KOBALTOVO_SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_KOBALTOVO_SINIY"),"UF_XML_ID" => "KOBALTOVO_SINIY","UF_DESCRIPTION" => "#1E213D"),
        "SAPFIROVO_SINIY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_SAPFIROVO_SINIY"),"UF_XML_ID" => "SAPFIROVO_SINIY","UF_DESCRIPTION" => "#1D1E33"),
        "BLEDNYY_FIOLETOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_BLEDNYY_FIOLETOVYY"),"UF_XML_ID" => "BLEDNYY_FIOLETOVYY","UF_DESCRIPTION" => "#957B8D"),
        "FIOLETOVYY" => array("UF_NAME" => GetMessage("HIGHLOAD_B2BSCOLOR_FIOLETOVYY"),"UF_XML_ID" => "FIOLETOVYY","UF_DESCRIPTION" => "#8B00FF"),          
    ),
    'B2BSRAZMER' => array(
        'L' => array('UF_NAME' => 'L', 'UF_XML_ID' => 'L'),
        'M' => array('UF_NAME' => 'M', 'UF_XML_ID' => 'M'),    
        'XS' => array('UF_NAME' => 'XS','UF_XML_ID' => 'XS'),   
        'S' => array('UF_NAME' => 'S','UF_XML_ID' => 'S'), 
        'XL' => array('UF_NAME' => 'XL','UF_XML_ID' => 'XL'),
        'XXL3' => array('UF_NAME' => 'XXL3','UF_XML_ID' => 'XXL3'),  
        'N37' => array('UF_NAME' => '37','UF_XML_ID' => 'N37'),  
        'N38' => array('UF_NAME' => '38','UF_XML_ID' => 'N38'),  
        'N40' => array('UF_NAME' => '40','UF_XML_ID' => 'N40'),  
        'N44' => array('UF_NAME' => '44','UF_XML_ID' => 'N44'), 
        'N42' => array('UF_NAME' => '42','UF_XML_ID' => 'N42'),    
        'N43' => array('UF_NAME' => '43','UF_XML_ID' => 'N43'),    
        'N39' => array('UF_NAME' => '39','UF_XML_ID' => 'N39'),    
        'N41' => array('UF_NAME' => '41','UF_XML_ID' => 'N41'),                                                                                                                            
    ),        
);
  
     
$dbHblock = Bitrix\Highloadblock\HighloadBlockTable::getList(array());
while($arHblock = $dbHblock->Fetch()) {
    if($arrCreateHL[$arHblock['NAME']]){ 
         $_SESSION["WIZARD_".$arHblock['NAME']."_HIGHBLOCK_ID"] = $arHblock['ID'];   
         unset($arrCreateHL[$arHblock['NAME']]);       
    }
}

foreach($arrCreateHL as $key => $data) {
    $Iblock = '';
    $result = Bitrix\Highloadblock\HighloadBlockTable::add($data);
    $Iblock = $result->getId();
    // создадим пользовательские свойства
    $arFieldsName = array(
        'UF_NAME' => array("Y", "string"),
        'UF_XML_ID' => array("Y", "string"),
        'UF_LINK' => array("N", "string"),
        'UF_DESCRIPTION' => array("N", "string"),
        'UF_FULL_DESCRIPTION' => array("N", "string"),
        'UF_SORT' => array("N", "integer"),
        'UF_FILE' => array("N", "file"),
        'UF_DEF' => array("N", "boolean"),
    );
    $obUserField = new CUserTypeEntity();
    $sort = 100;
    $arUserFields = array();
    foreach($arFieldsName as $fieldName => $fieldValue)
    {
        
        $arUserField = array(
            "ENTITY_ID" => "HLBLOCK_".$Iblock,
            "FIELD_NAME" => $fieldName,
            "USER_TYPE_ID" => $fieldValue[1],
            "XML_ID" => $fieldName,
            "SORT" => $sort,
            "MULTIPLE" => "N",
            "MANDATORY" => $fieldValue[0],
            "SHOW_FILTER" => "N",
            "SHOW_IN_LIST" => "Y",
            "EDIT_IN_LIST" => "Y",
            "IS_SEARCHABLE" => "N",
            "SETTINGS" => array(),
        );
        $obUserField->Add($arUserField);         
        $sort += 100;
    } 
    $arrCreateHL[$key]['HLIBLOCK'] = $Iblock;
    $_SESSION["WIZARD_".$key."_HIGHBLOCK_ID"] = $Iblock;    
   
} 
  
foreach($arrCreateHL as $data) {
    
    global $USER_FIELD_MANAGER;
    // заполним инфоблок элементами
    if($arrCreateHLitem[$data['NAME']] && $data['HLIBLOCK']){
        $hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($data['HLIBLOCK'])->fetch();
        $hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);

        $entity_data_class = $hlentity->getDataClass();        
        foreach($arrCreateHLitem[$data['NAME']] as $keyItem=>$valueItem){   
                
            if(empty($valueItem['UF_SORT'])){
                $valueItem['UF_SORT'] = '100';                
            }
            $USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$data['HLIBLOCK'], $valueItem);
            $USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$data['HLIBLOCK'], null, $valueItem);

            $result = $entity_data_class::add($valueItem);       
            
        }    
    }        
}


?>