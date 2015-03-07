<?php

include_once('JqueryUIModel.php');
/**
 * Description of JqueryUIModel
 *
 * @author user
 */
class JqueryUIPage extends JqueryUIModel {
    
    public function __contruct($title = "JqueryUI Page"){
        parent::__construct($title);
        
    }
    
    public function generateJqueryUIPage(){
        $this->add($this->makeTabs());
        $this->add($this->makeButtons());
        return $this->generatePage();
    }

    public function __toString(){
        $this->generateJqueryUIPage();
    }
    
    
}
