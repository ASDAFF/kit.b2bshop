<?
IncludeModuleLangFile(__FILE__);  
Class B2BSSotbitParent
{
    public static $deleteID = 0;
    public static $filterPath = "";
    public static $pageURL = "";
    
    function DeleteBasket()
    {
        if(check_bitrix_sessid() && isset($_REQUEST["ajax_delete_basket"]))
        {
            CModule::IncludeModule("sale");
            if(CSaleBasket::Delete($_REQUEST["ajax_delete_basket"]))
            {
                self::$deleteID = 1;
            }else self::$deleteID = 0;
        }

    }
    
    public function CatalogSmartFilter()
    {
        if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
        {                 
			if(!B2BSSotbit::getDemo()) return false;
            CModule::IncludeModule("main");
            global $APPLICATION;
            $filterName = "filter";
            $paramsToDelete = array("set_filter", "del_filter", "ajax", "bxajaxid", "AJAX_CALL", "mode");

            $firstPage = $APPLICATION->GetCurPageParam(false, $paramsToDelete); 
            self::$pageURL = preg_replace("/index\.php(.)*/", "", $APPLICATION->GetCurPage(false));   
            self::$filterPath = preg_replace("/(.)*\/filter\//", "", self::$pageURL);  
            $param = $APPLICATION->GetCurParam();         
            
            if(strpos(self::$pageURL, "/".$filterName."/")!==false)
            {
                $dirURL = preg_replace("/\/filter\/(.)*/", "", self::$pageURL);
                $dirURL .= "/index.php";    
                self::$pageURL .= $param?("?".$param):"";
                self::$pageURL = CHTTP::urlDeleteParams(self::$pageURL, $paramsToDelete, array("delete_system_params" => true));
                $APPLICATION->SetCurPage($dirURL, $param);
            } else {
                self::$filterPath = false;
                self::$pageURL = $firstPage;
            }                         
        }
    }
    
    function OnEndBufferContentHandler(&$content)
    {
        global $msIsFilter;
        /*Fix error for Firefox*/
       if(1 && strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') && isset($msIsFilter) && $msIsFilter && (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true))
       {
            $content = str_replace("top.BX.ajax.history.init(window.AJAX_PAGE_STATE);", "top.BX.ajax.history.init(window.AJAX_PAGE_STATE);window.AJAX_PAGE_STATE.getState = function(){var state = {
            'node': '#sotbit',
            'title': '',
            'data': ''
        };
        ;return state}", $content);
       }
    }
}
?>