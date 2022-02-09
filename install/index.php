<?php
use Bitrix\Main\EventManager;

IncludeModuleLangFile(__FILE__);

class kit_b2bshop extends CModule
{
    const MODULE_ID = 'kit.b2bshop';
    var $MODULE_ID = 'kit.b2bshop';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $_1550711909 = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = GetMessage('kit.b2bshop_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('kit.b2bshop_MODULE_DESC');
        $this->PARTNER_NAME = GetMessage('kit.b2bshop_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('kit.b2bshop_PARTNER_URI');
    }

    function InstallEvents()
    {
    }

    function UnInstallEvents()
    {
    }

    function DoInstall()
    {
        global $APPLICATION;
        RegisterModule(self::MODULE_ID);
    }

    function InstallFiles($_276120659 = array())
    {
        return true;
    }

    function InstallForm()
    {
        return true;
    }

    function InstallDB($_276120659 = array())
    {
        return true;
    }

    function InstallEmailEvent()
    {
        return true;
    }

    function InstallAgents()
    {
        return true;
    }

    function DoUninstall()
    {
        global $APPLICATION;
        UnRegisterModule(self::MODULE_ID);
    }

    function UnInstallDB($_276120659 = array())
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

    function UnInstallAgents()
    {
        return true;
    }
}