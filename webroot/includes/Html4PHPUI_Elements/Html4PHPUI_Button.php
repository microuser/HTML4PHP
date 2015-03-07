<?php

/**
 * Description of Html4PHPUI_Button
 *
 * @author user
 */


class Html4PHPUI_Button{

    private $clickEvent;
    private $class;
    private $id;
    private $text;
    private $elementType;
    private $extraTag;
    private $href;

    /**
     * 
     * @param type $text
     * @param type $id
     * @param type $clickEvent
     * @param type $elementType
     * @param type $extraTag
     * @param type $href
     */
    public function __construct($text = 'Button', $class= '', $clickEvent = '',$id = null, $elementType = 'button', $extraTag = '', $href = "#") {
        $this->text = $text;
        $this->class = $class;
        if ($id === null) {
            $this->id = 'button' . trim(explode(microtime(), " ")[0]) . rand(0, 9999999);
        } else {
            $this->id = $id;
        }
        $this->clickEvent = $clickEvent;
        $this->elementType = $elementType;
        $this->extraTag = $extraTag;
        $this->href = $href;
    }
    
    public function __toString(){
        return $this->makeHtml();
    }

    public function makeHtml() {
        
        $classes = explode(" ", $this->class);
        if($classes == ''){
            $classes = $this->class;
        }
        $classScript = '';
        foreach($classes as $class){
            $classScript .= '.addClass('.$class.')';
        }
        
        $script = '
        <script>
            $(function() {
                $( "#' . $this->id . '" )
                .button()
                .click(function( event ) {
                    event.preventDefault();
                ' . $this->clickEvent . '
                })'.$classScript.'
                ;
            });
        </script>';
        $element = '';
        if ($this->elementType == 'button') {
            $element = '<button id="' . $this->id . '" class="'.$this->class.'" ' . $this->extraTag . '>' . $this->text . '</button>';
        } else if ($this->elementType == 'a') {
            $element = '<a id="' . $this->id . '" class="'.$this->class.'" href="' . $this->href . '" ' . $this->extraTag . '>' . $this->text . '</a>';
        } else if ($this->elementType == 'input') {
            $element = '<input type="submit" id="' . $this->id . '" class="'.$this->class.'" value="' . $this->text . '" ' . $this->extaTag . '>';
        }
        return $element . $script;
    }

}
