<?php

include_once('ConfigModel.php');
/**
 * Description of configPage
 *
 * @author user
 */
class ConfigPage extends ConfigModel{
    public function __construct($title) {
        parent::__construct($title);
        $this->generateConfigArray();
    }
    
    
}
