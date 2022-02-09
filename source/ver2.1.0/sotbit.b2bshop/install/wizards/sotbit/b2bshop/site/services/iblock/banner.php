<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock"))
    return;

if(COption::GetOptionString("sotbit.b2bshop", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;

WizardServices::IncludeServiceLang("banner.php", 'ru');    
    
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/ru/ms_banner.xml"; 
$iblockCode = "banner_".WIZARD_SITE_ID;
$iblockType = "b2bs_content"; 

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
$IBLOCK_BANNER_ID = false; 
if ($arIBlock = $rsIBlock->Fetch())
{
    $IBLOCK_BANNER_ID = $arIBlock["ID"]; 
    if (WIZARD_INSTALL_DEMO_DATA)
    {
        CIBlock::Delete($arIBlock["ID"]); 
        $IBLOCK_BANNER_ID = false; 
    }
}

if($IBLOCK_BANNER_ID == false)
{
    $permissions = Array(
            "1" => "X",
            "2" => "R"
        );
    $dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
    if($arGroup = $dbGroup -> Fetch())
    {
        $permissions[$arGroup["ID"]] = 'W';
    };
    $IBLOCK_BANNER_ID = WizardServices::ImportIBlockFromXML(
        $iblockXMLFile,
        "banner",
        $iblockType,
        WIZARD_SITE_ID,
        $permissions
    );

    if ($IBLOCK_BANNER_ID < 1)
        return;
    
    
    //������� ������ � ��������
    //START
    $arSel = Array("ID", "NAME",'PROPERTY_LINK');
    $arFil = Array(
        "IBLOCK_ID"=>$IBLOCK_BANNER_ID,
        "!PROPERTY_LINK" => false
    );
    $db = CIBlockElement::GetList(Array(), $arFil, false, false, $arSel);
    while($res = $db->Fetch())
    {
        $res['PROPERTY_LINK_VALUE'] = substr($res['PROPERTY_LINK_VALUE'], 1, 4000);
        $res['PROPERTY_LINK_VALUE'] = WIZARD_SITE_DIR.$res['PROPERTY_LINK_VALUE'];
        CIBlockElement::SetPropertyValueCode($res['ID'],'LINK',$res['PROPERTY_LINK_VALUE']);
    } 
    //END     
    
    //IBlock fields
    $iblock = new CIBlock;
    $arFields = Array(
        "ACTIVE" => "Y",
        "FIELDS" => array ( 
            'IBLOCK_SECTION' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'ACTIVE' => array (
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => 'Y', 
            ), 
            'ACTIVE_FROM' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '=today', 
            ), 
            'ACTIVE_TO' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'SORT' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'NAME' => array(
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => '', 
            ), 
            'PREVIEW_PICTURE' => array( 
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => array(
                    'FROM_DETAIL' => 'N', 
                    'SCALE' => 'N', 
                    'WIDTH' => '', 
                    'HEIGHT' => '', 
                    'IGNORE_ERRORS' => 'N', 
                    'METHOD' => 'resample', 
                    'COMPRESSION' => 95, 
                    'DELETE_WITH_DETAIL' => 'N', 
                    'UPDATE_WITH_DETAIL' => 'N', 
                ), 
            ), 
            'PREVIEW_TEXT_TYPE' => array(
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => 'text', 
            ), 
            'PREVIEW_TEXT' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'DETAIL_PICTURE' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => array(
                    'SCALE' => 'N', 
                    'WIDTH' => '', 
                    'HEIGHT' => '', 
                    'IGNORE_ERRORS' => 'N', 
                    'METHOD' => 'resample', 
                    'COMPRESSION' => 95, 
                ), 
            ), 
            'DETAIL_TEXT_TYPE' => array(
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => 'text', 
            ), 
            'DETAIL_TEXT' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'XML_ID' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'CODE' => array(
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => array(
                    'UNIQUE' => 'Y', 
                    'TRANSLITERATION' => 'Y', 
                    'TRANS_LEN' => 100, 
                    'TRANS_CASE' => 'L', 
                    'TRANS_SPACE' => '_', 
                    'TRANS_OTHER' => '_', 
                    'TRANS_EAT' => 'Y', 
                    'USE_GOOGLE' => 'Y', 
                ), 
            ), 
            'TAGS' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '',
            ), 
            'SECTION_NAME' => array(
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => '', 
            ), 
            'SECTION_PICTURE' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => array(
                    'FROM_DETAIL' => 'N', 
                    'SCALE' => 'N', 
                    'WIDTH' => '', 
                    'HEIGHT' => '', 
                    'IGNORE_ERRORS' => 'N', 
                    'METHOD' => 'resample', 
                    'COMPRESSION' => 95, 
                    'DELETE_WITH_DETAIL' => 'N', 
                    'UPDATE_WITH_DETAIL' => 'N', 
                ), 
            ), 
            'SECTION_DESCRIPTION_TYPE' => array(
                'IS_REQUIRED' => 'Y', 
                'DEFAULT_VALUE' => 'text', 
            ), 
            'SECTION_DESCRIPTION' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => '', 
            ), 
            'SECTION_DETAIL_PICTURE' => array(
                'IS_REQUIRED' => 'N', 
                'DEFAULT_VALUE' => array(
                    'SCALE' => 'N', 
                    'WIDTH' => '', 
                    'HEIGHT' => '', 
                    'IGNORE_ERRORS' => 'N', 
                    'METHOD' => 'resample', 
                    'COMPRESSION' => 95, 
                ), 
            ), 
            'SECTION_XML_ID' => array(
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '', 
            ), 
            'SECTION_CODE' => array(
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => array(
                    'UNIQUE' => 'N', 
                    'TRANSLITERATION' => 'N', 
                    'TRANS_LEN' => 100, 
                    'TRANS_CASE' => 'L', 
                    'TRANS_SPACE' => '_', 
                    'TRANS_OTHER' => '_', 
                    'TRANS_EAT' => 'Y', 
                    'USE_GOOGLE' => 'N', 
                ), 
            ), 
        ),
        "CODE" => "banner", 
        "XML_ID" => $iblockCode,
        //"NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME")
    );
    $iblock->Update($IBLOCK_BANNER_ID, $arFields);
    $_SESSION["WIZARD_BANNER_IBLOCK_ID"] = $IBLOCK_BANNER_ID;
    
    $AddProperty = \Bitrix\Iblock\PropertyTable::add( array(
    		'NAME' => 'Заголовок дополнительной области',
    		'IBLOCK_ID' => $IBLOCK_BANNER_ID,
    		'CODE' => 'BANNER_DOP_SECTION_TITLE',
    		'PROPERTY_TYPE' => 'S'
    ) );
    
    $AddProperty = \Bitrix\Iblock\PropertyTable::add( array(
    		'NAME' => 'Дополнительная область',
    		'IBLOCK_ID' => $IBLOCK_BANNER_ID,
    		'CODE' => 'BANNER_DOP_SECTION',
    		'PROPERTY_TYPE' => 'S',
    		'USER_TYPE'=>'HTML'
    ) );
    
    //������� ����
    //START
    $arrProper = array();
    $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("IBLOCK_ID"=>$IBLOCK_BANNER_ID));
    while($prop_fields = $properties->GetNext())
    {
        $arrProper[$prop_fields['CODE']] = $prop_fields;
    }  
    $tabs_string = GetMessage('TABS_BANNER', array(
        '#PROP_TYPE#' => $arrProper['TYPE']['ID'],
        '#PROP_LINK#' => $arrProper['LINK']['ID'], 
        '#PROP_SECTION#' => $arrProper['SECTION']['ID'], 
        '#PROP_ELEMENT#' => $arrProper['ELEMENT']['ID'],
        '#PROP_BANNER_ADD_TEXT#' => $arrProper['BANNER_ADD_TEXT']['ID'],
        '#PROP_BANNER_LEFT_TITLE#' => $arrProper['BANNER_LEFT_TITLE']['ID'],
        '#PROP_BANNER_LEFT_TEXT#' => $arrProper['BANNER_LEFT_TEXT']['ID'],  
        '#PROP_ELEMENT_FOR_MENU#' => $arrProper['ELEMENT_FOR_MENU']['ID'],                                      
    		'#PROP_BANNER_DOP_SECTION_TITLE#' => $arrProper['BANNER_DOP_SECTION_TITLE']['ID'],
    		'#PROP_BANNER_DOP_SECTION#' => $arrProper['BANNER_DOP_SECTION']['ID'],
    ));
    $arOptions = array(
        array(
            'c' => 'form',
            'n' => 'form_element_'.$IBLOCK_BANNER_ID,
            'd' => 'Y',
            'v' => array(
                'tabs' => $tabs_string,
            ),
        )
    );
    CUserOptions::SetOptionsFromArray($arOptions);    
    //END
    
}
else
{
    $arSites = array(); 
    $db_res = CIBlock::GetSite($IBLOCK_BANNER_ID);
    while ($res = $db_res->Fetch())
        $arSites[] = $res["LID"]; 
    if (!in_array(WIZARD_SITE_ID, $arSites))
    {
        $arSites[] = WIZARD_SITE_ID;
        $iblock = new CIBlock;
        $iblock->Update($IBLOCK_BANNER_ID, array("LID" => $arSites));
        $_SESSION["WIZARD_BANNER_IBLOCK_ID"] = $IBLOCK_BANNER_ID;
    }
}

CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID.'/header.php' , array("BANNER_IBLOCK_ID" => $IBLOCK_BANNER_ID)); 

    
    
if($IBLOCK_BANNER_ID){
    COption::SetOptionString("sotbit.b2bshop",'BANNER_IBLOCK_TYPE',$iblockType);      
    COption::SetOptionString("sotbit.b2bshop",'BANNER_IBLOCK_ID',$IBLOCK_BANNER_ID);    
    
    //�������� ����� � ����������
    //START
    $CATALOG_PROPER = array("SECTION","ELEMENT","ELEMENT_FOR_MENU");
    foreach($CATALOG_PROPER as $proper_code){
        $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("CODE"=>$proper_code, "IBLOCK_ID"=>$IBLOCK_BANNER_ID));
        while($prop_fields = $properties->GetNext())
        {
            $ibp = new CIBlockProperty;
            $ibp->Update($prop_fields['ID'], array("LINK_IBLOCK_ID"=>$_SESSION["WIZARD_CATALOG_IBLOCK_ID"]));
        }          
    }         
    //END
  
}     
  
  
    
/*
$dbSite = CSite::GetByID(WIZARD_SITE_ID);
if($arSite = $dbSite -> Fetch())
    $lang = $arSite["LANGUAGE_ID"];
if(strlen($lang) <= 0)
    $lang = "ru";
    
WizardServices::IncludeServiceLang("news.php", $lang);
CUserOptions::SetOption("form", "form_element_".$iblockID, array ('tabs' => 'edit1--#--'.GetMessage("WZD_OPTION_NEWS_1").'--,--ACTIVE--#--'.GetMessage("WZD_OPTION_NEWS_2").'--,--ACTIVE_FROM--#--'.GetMessage("WZD_OPTION_NEWS_3").'--,--NAME--#--'.GetMessage("WZD_OPTION_NEWS_5").'--,--CODE--#--'.GetMessage("WZD_OPTION_NEWS_6").'--,--PREVIEW_TEXT--#--'.GetMessage("WZD_OPTION_NEWS_8").'--,--DETAIL_TEXT--#--'.GetMessage("WZD_OPTION_NEWS_10").'--;--', ));

CUserOptions::SetOption("list", "tbl_iblock_list_".md5($iblockType.".".$iblockID), array ( 'columns' => 'NAME,ACTIVE,DATE_ACTIVE_FROM', 'by' => 'timestamp_x', 'order' => 'desc', 'page_size' => '20', ));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/news/index.php", array("IBLOCK_TYPE_CONTENT_NEWS"=>$iblockType, "IBLOCK_ID_CONTENT_NEWS" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/news.php", array("IBLOCK_TYPE_CONTENT_NEWS"=>$iblockType, "IBLOCK_ID_CONTENT_NEWS" => $iblockID));
if($wizard->GetVar('siteLogoSet', true)){
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", array("IBLOCK_TYPE_CONTENT_NEWS"=>$iblockType, "IBLOCK_ID_CONTENT_NEWS" => $iblockID));
}
*/

?>