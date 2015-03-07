<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpSite.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpUI.php');

/**
 * Description of JqueryUIModel
 *
 * @author user
 */
class JqueryUIModel extends Html4PHPSite {
    
    public function __contruct($title = "JqueryUI Model"){
        parent::__construct($title);
    }
    
    
    public function makeTabs(){
        $tab = new Html4PhpUI_Tab();
        $tab->append("Database Table","" );
        $tab->append("Random Table", "" );
        $tab->append("User Table", "");
        return $tab;
        
    }
    
    public function makeButtons(){
        $button1 = new Html4PHPUI_Button("Button", "col-2");
        $button2 = new Html4PHPUI_Button("Success", "success col-2", "");
        $button3 = new Html4PHPUI_Button("Warning", "warning col-2", "");
        $button4 = new Html4PHPUI_Button("Primary", "primary col-2", "");
        $button5 = new Html4PHPUI_Button("Info", "info col-2", "");
        $button6 = new Html4PHPUI_Button("Info", "info col-2", "");
        $this->addDiv($button1.$button2.$button3.$button4.$button5.$button6);
        
        $clickEvent = '';
        $id = null;
        $button6 = new Html4PHPUI_Button("link", null, '',null, "a", null, "/index.php");
        $button7 = new Html4PHPUI_Button("Success", "success", $clickEvent, $id, "a", null, "/index.php");
        $button8 = new Html4PHPUI_Button("Warning", "warning", $clickEvent, $id, "a", null, "/index.php");
        $button9 = new Html4PHPUI_Button("Primary", "primary", $clickEvent, $id, "a", null, "/index.php");
        $button10 = new Html4PHPUI_Button("Info","info", $clickEvent, $id, "a", null, "/index.php");
        $this->addDiv($button6.$button7.$button8.$button9.$button10);
        
        $button11 = new Html4PHPUI_Button("input", null, $clickEvent, $id, "input");
        $button12 = new Html4PHPUI_Button("Success", "success", $clickEvent, $id, "input");
        $button13 = new Html4PHPUI_Button("Warning", "warning", $clickEvent, $id, "input");
        $button14 = new Html4PHPUI_Button("Primary", "primary", $clickEvent, $id, "input");
        $button15 = new Html4PHPUI_Button("Info", "info", $clickEvent, $id, "input");
        $this->addDiv($button11.$button12.$button13.$button14.$button15);
    }
    
    
}
