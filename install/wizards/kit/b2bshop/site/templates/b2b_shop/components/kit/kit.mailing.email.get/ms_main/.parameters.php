<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();


$arTemplateParameters = array(

       "PANEL_TEXT" => array(
            "NAME" => GetMessage("PANEL_TEXT"),
            "TYPE" => "STRING",
            "PARENT" => "GROUPS_VISUAL",           
            "DEFAULT" => GetMessage('PANEL_TEXT_DEFAULT'),
            "SIZE" => '100'
        ),
        "EMAIL_SEND_END" => array(
            "NAME" => GetMessage("EMAIL_SEND_END"),
            "TYPE" => "STRING",
            "DEFAULT" => GetMessage("EMAIL_SEND_END_DEFAULT"),
            "PARENT" => "GROUPS_VISUAL",
        ),                
        "DISPLAY_IF_ADMIN" => array(
            "NAME" => GetMessage("REGISTER_DISPLAY_IF_ADMIN"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "PARENT" => "GROUPS_DOPOLN",
        ),  
        "DISPLAY_NO_AUTH" => array(
            "NAME" => GetMessage("DISPLAY_NO_AUTH"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "GROUPS_DOPOLN",
        ),                 
        

);


?>