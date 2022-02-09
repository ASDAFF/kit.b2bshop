<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("sns.tools1c") || !CModule::IncludeModule("iblock"))
    return;     
    
if(COption::GetOptionString("kit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;
    
    
//��������� ��������� ��� 1� ������������
//START


$snstools1cSet = array(
    // ������ ��������
    'CHEXBOX_GOODS_PROPERTIES'=>'Y',
    'GOODS_PROPERTIES_IBLOCK'=>'b2bs_references',
    'GOODS_PROPERTIES_ONE_CAN'=>'CML2_MANUFACTURER',
    'GOODS_PROPERTIES_MUST_NOT'=>'CML2_ARTICLE,CML2_TRAITS',
    'SELECT_NONE_ADD'=>serialize(array('PREVIEW_TEXT')),
    'SELECT_NONE_UPDATE'=>serialize(array('PREVIEW_TEXT')),    
    // �������� �����������
    'CATALOG_ARTICLE'=>'CML2_ARTICLE',
    'OFFERS_ARTICLE'=>'CML2_ARTICLE',
    'OFFERS_ATTRIBUTES'=>'CML2_ATTRIBUTES',
    'OFFERS_MORE_PHOTO'=>'MORE_PHOTO',
    'CATALOG_MORE_PHOTO'=>'MORE_PHOTO',
    'CHEXBOX_OFFERS_PROPERTIES_HIGHLOAD'=>'Y',
    // �������� �������� �����������
    'CHEXBOX_OFFERS_MORE_PHOTO' => 'Y',
    'OFFERS_MORE_PHOTO_RAZDEL' => '_'    
);  
foreach($snstools1cSet as $key=>$value){
    COption::SetOptionString("sns.tools1c", $key, $value);        
}
//END    
    
//������� ������
//START
//�������� �������
$ctalog_proper = array();
$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array('IBLOCK_ID' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"]));
while ($prop_fields = $properties->GetNext())
{
    $ctalog_proper[$prop_fields['CODE']] = $prop_fields;     
} 
 
//�������� ��������� ����������� 
$offer_proper = array();
$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array('IBLOCK_ID' => $_SESSION["WIZARD_OFFERS_IBLOCK_ID"]));
while ($prop_fields = $properties->GetNext())
{
    $offer_proper[$prop_fields['CODE']] = $prop_fields;     
} 
//END 
    
           
//������� ������������� � 1� �����������
//START
$CODE_BRAND_NEW = 'PROIZVODITEL_ATTR_E';
$CODE_BRAND_OLD = 'CML2_MANUFACTURER';
$addProper = array(
    'PROPERTY_ID' => $ctalog_proper[$CODE_BRAND_NEW]['ID'],
    'PROPERTY_IBLOCK' => $_SESSION["WIZARD_CATALOG_IBLOCK_ID"],
    'PROPERTY_TYPE' => 'E',    
    'FOR_PROPERTY_ID' => $ctalog_proper[$CODE_BRAND_OLD]['ID'],
    'TYPE' => 'GOODS_DIRECTORY',
    'NAME_1C' => $ctalog_proper[$CODE_BRAND_OLD]['NAME'], 
);

$db1cProp = CSnsToolsProperty::GetList(array(),$addProper);
if(!$res1cProp = $db1cProp->Fetch()){
    CSnsToolsProperty::Add($addProper);        
}
$addIblock = array(
    'IBLOCK_ID' => $_SESSION["WIZARD_BRAND_IBLOCK_ID"],
    'FOR_PROPERTY_ID' => $ctalog_proper[$CODE_BRAND_NEW]['ID'],
    'TYPE' => 'GOODS_DIRECTORY'
);
$db1cProp = CSnsToolsIblock::GetList(array(),$addIblock);
if(!$res1cProp = $db1cProp->Fetch()){
    CSnsToolsIblock::Add($addIblock);        
}
//END

//������� �������������� �������� ����������� � ����� � highload �������
//START
$arrCreateHL = array(
    'B2BSCOLOR' => array(
        'NAME' => 'B2BSCOLOR',
        'TABLE_NAME' => 'b2bshop_color_reference',
        'CODE_BRAND_NEW' => 'COLOR',
        'CODE_BRAND_OLD' => 'CML2_ATTRIBUTES'   
    ),
    'B2BSRAZMER' => array(
        'NAME' => 'B2BSRAZMER',
        'TABLE_NAME' => 'b2bshop_ramzer_reference',  
        'CODE_BRAND_NEW' => 'RAZMER',
        'CODE_BRAND_OLD' => 'CML2_ATTRIBUTES'           
    ),     
); 


//������� id highloas ������
//START
/*
if (!CModule::IncludeModule("highloadblock"))
    return;
    
$dbHblock = Bitrix\Highloadblock\HighloadBlockTable::getList(array());
while($arHblock = $dbHblock->Fetch()) {
    if($arrCreateHL[$arHblock['NAME']]){ 
        if(empty($_SESSION["WIZARD_".$arHblock['NAME']."_HIGHBLOCK_ID"])){
            $_SESSION["WIZARD_".$arHblock['NAME']."_HIGHBLOCK_ID"] = $arHblock['ID'];               
        }
        unset($arrCreateHL[$arHblock['NAME']]);       
    }
} */
//END



foreach($arrCreateHL as $key=>$value){
    $CODE_BRAND_NEW = $value['CODE_BRAND_NEW'];
    $CODE_BRAND_OLD = $value['CODE_BRAND_OLD'];
    $addProper = array(
        'PROPERTY_ID' => $offer_proper[$CODE_BRAND_NEW]['ID'],
        'PROPERTY_IBLOCK' => $_SESSION["WIZARD_OFFERS_IBLOCK_ID"],
        'PROPERTY_TYPE' => 'S:directory',    
        'FOR_PROPERTY_ID' => $offer_proper[$CODE_BRAND_OLD]['ID'],
        'TYPE' => 'OFFERS_ATTRIBUTES',
        'NAME_1C' => $offer_proper[$CODE_BRAND_NEW]['NAME'],
        'PROPERTY_HIGHLOAD_TABLE' => $value['TABLE_NAME'] 
    );

    $db1cProp = CSnsToolsProperty::GetList(array(),$addProper);
    if(!$res1cProp = $db1cProp->Fetch()){
        CSnsToolsProperty::Add($addProper);        
    }
    $addIblock = array(
        'IBLOCK_ID' => $_SESSION["WIZARD_".$key."_HIGHBLOCK_ID"],
        'FOR_PROPERTY_ID' => $offer_proper[$CODE_BRAND_NEW]['ID'],
        'TYPE' => 'OFFERS_ATTRIBUTES',
        'IBLOCK_TYPE'=>'HIGHLOAD'
    );
    $db1cProp = CSnsToolsIblock::GetList(array(),$addIblock);
    if(!$res1cProp = $db1cProp->Fetch()){
        CSnsToolsIblock::Add($addIblock);        
    }   
                
}

//END        
?>