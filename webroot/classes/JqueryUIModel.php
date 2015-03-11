<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpUI.php');

/**
 * Description of JqueryUIModel
 *
 * @author user
 */
class JqueryUIModel extends Html4PHPSite {

    public function __contruct($title = "JqueryUI Model") {
        parent::__construct($title);
    }

    public function makeTabs() {
        $tab = new Html4PhpUI_Tab();
        $tab->append("make12ColumDiv", $this->make12ColumnDivs());
        $tab->append("Buttons", $this->makeButtons());
        $tab->append("User Table", "");
        return $tab;
    }
    
    public function make12ColumnDivs(){
        return $this->makeDiv('<div class="col-1 rainbow">&nbsp</div>'
                .'<div class="col-1 rainbow">one</div>'
                .'<div id="text" class="col-1 rainbow">Two</div>'
                .'<div id="nothing" class="col-1 rainbow"></div>'
                .'<div class="col-1 rainbow"><p>paragraph</p></div>'
                .'<div class="col-1 rainbow"><span>span</span></div>'
                .'<div class="col-1 rainbow">&nbsp;</div>'
                .'<div class="col-1 rainbow">&nbsp;</div>'
                .'<div class="col-1 rainbow"><p>paragraph</p></div>'
                .'<div class="col-1 rainbow"><span>span</span></div>'
                .'<div class="col-1 rainbow">&nbsp;</div>'
                .'<div class="col-1 rainbow">&nbsp;</div>'
                );
    }

    public function makeButtons() {
        $button1 = new Html4PHPUI_Button("Button", "col-2","alert('asdf')");
        $button2 = new Html4PHPUI_Button("Success", "success col-2", "");
        $button3 = new Html4PHPUI_Button("Warning", "warning col-2", "");
        $button4 = new Html4PHPUI_Button("Primary", "primary col-2", "");
        $button5 = new Html4PHPUI_Button("Info", "info col-2", "");
        $button6 = new Html4PHPUI_Button("Info", "info col-2", "");
        
        $out  = $this->makeDiv($button1 . $button2 . $button3 . $button4 . $button5 . $button6);

        $out .= $this->makeDiv('', 'randomPixle', 'onClick="alert(\'\')"');

        $out .= $this->makeDiv(
                ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", "alert('asdf')"))
                . ( new Html4PHPUI_Button("Warning", "warning col-1", ""))
                . ( new Html4PHPUI_Button("Primary", "primary col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", ""))
                . ( new Html4PHPUI_Button("Warning", "warning col-1", ""))
                . ( new Html4PHPUI_Button("Primary", "primary col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
        );
        
                $out .= $this->makeDiv('<div class="col-1 rainbow">&nbsp</div>'
                .'<div class="col-1 rainbow">one</div>'
                .'<div id="text" class="col-1 rainbow">Two</div>'
                .'<div id="nothing" class="col-1 rainbow"></div>'
                .'<div class="col-1 rainbow"><p>paragraph</p></div>'
                .'<div class="col-1 rainbow"><span>span</span></div>'
                .'<div class="col-1 rainbow">&nbsp;</div>'
                .'<div class="col-1 rainbow">&nbsp;</div>'
                );

        $clickEvent = '';
        $id = null;
        $button11 = new Html4PHPUI_Button("link", 'col-3', '', null, "a", null, "/index.php");
        $button7 = new Html4PHPUI_Button("Success", "success col-3", $clickEvent, $id, "a", null, "/index.php");
        $button8 = new Html4PHPUI_Button("Warning", "warning col-3", $clickEvent, $id, "a", null, "/index.php");
        $button9 = new Html4PHPUI_Button("Primary", "primary col-3", $clickEvent, $id, "a", null, "/index.php");
        $out .= $this->makeDiv($button11 . $button7 . $button8 . $button9);

        $out .= $this->makeDiv(
                ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", "alert('asdf')"))
                . ( new Html4PHPUI_Button("Warning", "warning col-1", ""))
                . ( new Html4PHPUI_Button("Primary", "primary col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", ""))
                . ( new Html4PHPUI_Button("Warning", "warning col-1", ""))
                . ( new Html4PHPUI_Button("Primary", "primary col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
        );

        $out .= $this->makeDiv(
                ( new Html4PHPUI_Button("Button", "col-4"))
                . ( new Html4PHPUI_Button("Success", "success col-4", "alert('asdf')"))
                . ( new Html4PHPUI_Button("Warning", "warning col-4", ""))
        );
        $out .= $this->makeDiv(
                ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", "alert('asdf')"))
                . ( new Html4PHPUI_Button("Warning", "warning col-1", ""))
                . ( new Html4PHPUI_Button("Primary", "primary col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", ""))
                . ( new Html4PHPUI_Button("Warning", "warning col-1", ""))
                . ( new Html4PHPUI_Button("Primary", "primary col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
                . ( new Html4PHPUI_Button("Info", "info col-1", ""))
        );

        $out .= $this->makeDiv(
                ( new Html4PHPUI_Button("Button", "col-1"))
                . ( new Html4PHPUI_Button("Success", "success col-1", "alert('asdf')"))
                . ( new Html4PHPUI_Button("Warning", "warning col-5", ""))
                . ( new Html4PHPUI_Button("Success", "success col-5", ""))
        );

        $out .= $this->makeDiv(
                ( new Html4PHPUI_Button("Button", "col-6"))
                . ( new Html4PHPUI_Button("Success", "success col-6", "alert('asdf')"))
                ,'row'
        );
        
        $button16 = new Html4PHPUI_Button("input", null, $clickEvent, $id, "input");
        $button12 = new Html4PHPUI_Button("Success", "success", $clickEvent, $id, "input");
        $button13 = new Html4PHPUI_Button("Warning", "warning", $clickEvent, $id, "input");
        $button14 = new Html4PHPUI_Button("Primary", "primary", $clickEvent, $id, "input");
        $button15 = new Html4PHPUI_Button("Info", "info", $clickEvent, $id, "input");
        $out .= $this->makeDiv($button16 . $button12 . $button13 . $button14 . $button15);
        return $out;
    }

}
