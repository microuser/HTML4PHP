<?php

class Html4PhpUI_Tab{
    
    private $tabs = array();
    private $id;
    
    /**
     * 
     * @param type $id
     */
    public function __construct($id = null){
        if($id === null){
            $this->id = 'tabs'.  trim(explode(microtime()," ")[0]).rand(0, 9999999);
        }else{
            $this->id = $id;
        }
        
    }
    
    public function setTabs($array){
        $this->tabs = $array;
    }
    
    public function append($title, $content){
        $this->tabs[] = array($title, $content);
    }
    
    public function __toString(){
        return $this->generateHtml();
    }
    
    public function generateHtml(){
        $html = "<div id=".$this->id.">";
        $html .= '<ul>';
        $divContent = '';
        $iterator = 0;
        foreach($this->tabs as $titleContent){
            $iterator += 1;
            $html .= '<li>'
                    . '<a href="#'.$this->id.'-'.$iterator.'">'
                    .$titleContent[0]
                    .'</a>'
                    . '</li>';
            $divContent .= '<div id="'.$this->id.'-'.$iterator.'">';
            $divContent .= '<p>'.$titleContent[1].'</p>';
            $divContent .= '</div>';
        }
        $html .= '</ul>';
        $html .= $divContent;
        $html .= '</div>';
        $js = '<script>';
        $js .= '$(function() { $("#'.$this->id.'").tabs(); });';
        $js .= '</script>';
        
        return $html . $js;
    }
}