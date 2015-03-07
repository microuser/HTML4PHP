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
        $button1 = new Html4PHPUI_Button("Button innert");
        $button2 = new Html4PHPUI_Button("Button with Alert", "success", "alert('asdf');");
        return $button1.$button2;
        
    }
    
    
}
