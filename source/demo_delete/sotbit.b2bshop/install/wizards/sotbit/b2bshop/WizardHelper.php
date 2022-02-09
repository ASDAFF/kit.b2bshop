<?php

class WizardHelper {
    protected static $_instance;

    private function __construct() {
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public function copy_folder($d1, $d2, $upd = true, $force = true) {
        if ( is_dir( $d1 ) ) {
            $d2 = $this->mkdir_safe( $d2, $force );
            if (!$d2) {$this->fs_log("!!fail $d2"); return;}
            $d = dir( $d1 );
            while ( false !== ( $entry = $d->read() ) ) {
                if ( $entry != '.' && $entry != '..' )
                    $this->copy_folder( "$d1/$entry", "$d2/$entry", $upd, $force );
            }
            $d->close();
        }
        else {
            $ok = $this->copy_safe( $d1, $d2, $upd );
            $ok = ($ok) ? "ok-- " : " -- ";
            $this->fs_log("{$ok}$d1");
        }
    } //function copy_folder

    public function mkdir_safe( $dir, $force ) {
        if (file_exists($dir)) {
            if (is_dir($dir)) return $dir;
            else if (!$force) return false;
            unlink($dir);
        }
        return (mkdir($dir, 0777, true)) ? $dir : false;
    } //function mkdir_safe

    public function copy_safe ($f1, $f2, $upd) {
        $time1 = filemtime($f1);
        if (file_exists($f2)) {
            $time2 = filemtime($f2);
            if ($time2 >= $time1 && $upd) return false;
        }
        $ok = copy($f1, $f2);
        if ($ok) touch($f2, $time1);
        return $ok;
    } //function copy_safe

    public function fs_log($str) {
        $log = fopen("./fs_log.txt", "a");
        $time = date("Y-m-d H:i:s");
        fwrite($log, "$str ($time)\n");
        fclose($log);
    }



    public function installModuleHands($module) {

        $obModule = CModule::CreateModuleObject($module);
        if(!is_object($obModule)) {
            return false;
        }

        if(!$obModule->IsInstalled()) {
            $obModule->InstallFiles();
            $obModule->InstallDB();
            $obModule->InstallEvents();
            RegisterModule($module);
            return true;
        }
    }

    public function installOrigami() {

        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
        $module = 'sotbit.origami';
        $moduleForCopy = 'origami';

        $modulesPathDir = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/";

        if(!file_exists($modulesPathDir)) {
            $strError = '';
            CUpdateClientPartner::LoadModuleNoDemand($module,$strError,'Y',false);
        }

        $this->installModuleHands($module);
//        $module_status = CModule::IncludeModuleEx($module);
//
//        if($module_status==2 || $module_status==0 || $module_status==3) {
//            $this->installModuleHands($module);
//        }

        $this->copy_folder($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/install/wizards/sotbit/".$moduleForCopy, $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/sotbit/".$moduleForCopy);

    }

    public function installB2bCabinet() {

        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
        $module = 'sotbit.b2bcabinet';
        $moduleForCopy = 'b2bcabinet';

        $modulesPathDir = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/";

        if(!file_exists($modulesPathDir)) {
            $strError = '';
            CUpdateClientPartner::LoadModuleNoDemand($module,$strError,'Y',false);
        }

//        $module_status = CModule::IncludeModuleEx($module);
//
//        if($module_status==2 || $module_status==0 || $module_status==3) {
//            $this->installModuleHands($module);
//        }

        $this->copy_folder($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module."/install/wizards/sotbit/".$moduleForCopy, $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/sotbit/".$moduleForCopy);

    }

}