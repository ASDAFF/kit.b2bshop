<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/update_client.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/update_client_partner.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/kit/b2bshop/WizardHelper.php");

class InstallDateWizards extends CWizardStep {
    function InitStep()
    {
        $this->SetStepID("init_wizards");
        $this->SetTitle(GetMessage("INSTALL_WIZARDS"));
        $this->SetNextStep("init_origami");
        $this->SetSubTitle(GetMessage("INSTALL_WIZARDS_SUB"));
        $this->SetNextCaption(GetMessage("INSTALL_WIZARDS_BUTTON"));

        $wizard =& $this->GetWizard();
        $wizard->solutionName = "kit.b2bshop";

        //WizardHelper::getInstance()->installOrigami();
        //die();
    }

    function ShowStep() {
        $wizard =& $this->GetWizard();
        parent::ShowStep();
        $this->content .= '<link rel="stylesheet" href="'.$wizard->GetPath().'/css/b2bshop.css">';
    }

    function OnPostForm()
    {
        if (CModule::IncludeModule('kit.b2bshop') === false) {
            RegisterModule('kit.b2bshop');
        }

        WizardHelper::getInstance()->installOrigami();
        WizardHelper::getInstance()->installB2bCabinet();
    }

}

class InstallOrigami extends CWizardStep
{

    function InitStep()
    {
        $wizard =& $this->GetWizard();
        $this->SetStepID("init_origami");
        $this->SetTitle(GetMessage("INSTALL_ORIGAMI"));
        $this->SetNextStep("init_b2b");
        $this->SetSubTitle(GetMessage("INSTALL_ORIGAMI"));
        $this->SetNextCaption(GetMessage("INSTALL_BUTTON"));
        //WizardHelper::getInstance()->installOrigami();
        //die();
    }

    function ShowStep() {
        $wizard =& $this->GetWizard();
        parent::ShowStep();
        $this->content .= '<link rel="stylesheet" href="'.$wizard->GetPath().'/css/b2bshop.css">';
    }

    function OnPostForm()
    {
        if ((isset($_SERVER['REQUEST_SCHEME']) AND $_SERVER['REQUEST_SCHEME'] === 'https') OR (isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] === 'on'))
            $protocol = 'https';
        else
            $protocol = 'http';


        header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . '/bitrix/admin/wizard_install.php?' . bitrix_sessid_get() . '&lang=' . LANGUAGE_ID . '&wizardName=kit:origami');
    }


}

class InstallB2bCabinet extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("init_b2b");
        $this->SetTitle(GetMessage("INSTALL_B2BCABINET"));
        $this->SetSubTitle(GetMessage("INSTALL_B2BCABINET"));
        $this->SetNextCaption(GetMessage("INSTALL_BUTTON_B2B"));

        $wizard =& $this->GetWizard();
    }

    function ShowStep() {
        $wizard =& $this->GetWizard();
        parent::ShowStep();
        $this->content .= '<link rel="stylesheet" href="'.$wizard->GetPath().'/css/b2bshop.css">';
    }
}

class ModulesStep extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("init_modules");
        $this->SetNextStep("data_install");
        $this->SetTitle(GetMessage("INSTALL_WIZARDS_MODULES"));
        $this->SetSubTitle(GetMessage("INSTALL_WIZARDS_MODULES_SUB"));
        $this->SetNextCaption(GetMessage("INSTALL_WIZARDS_MODULES_BUTTON"));

        $wizard =& $this->GetWizard();
    }

    function ShowStep() {
        $wizard =& $this->GetWizard();
        parent::ShowStep();
        $this->content .= '<link rel="stylesheet" href="'.$wizard->GetPath().'/css/b2bshop.css">';
    }
}
?>