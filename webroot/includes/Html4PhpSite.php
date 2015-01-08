<?php
include_once 'Html4PhpUser.php';

/** 
 * @version 2015-01-04
 * @category PHP Framework
 * @package HTML4PHP
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT OR GPL
 * @copyright (c) microuser 2014, macro_user@outlook.com
 * <pre>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice, this permission notice, and the public RSA key shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-----BEGIN RSA PUBLIC KEY----- ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDfpROYHVyYHe2yok8Ut5OEmNzNriV9QGdzzPm1vFJSf8Wp9iBY74xf5oYdMmUOOfLlZfcrXP6Dc3VXOlTU7P46t14s9CcoGR6As2EamV7q9sAh4Nkr6xZb4kNdy9Bd4SxY/I3kxEbTpbpPq2T5B68xJWVjf83SQI43eyjO2Hv3iA8iEyifeyAGNVX46X3uuCsBftXF5Ng1GCCp6fMeCXeY0p3qmOg7m6SMGAXY97hKakNHPN2+vDP2fCOfefFmZihP/0mQNNLu1VNfI3MKonyfiHI4k1WAbFP2ozWSGmzv3dhej3wguYmRYKsgkK3ay5QoZQSLDHnZXtkuO9rJbAuz -----END RSA PUBLIC KEY-----
 * </pre>
 * </pre> */
class Html4PhpSite extends Html4PhpUser{


    public function __construct($title) {
       parent::__construct($title);
       if($this->getConfig('site','layout') === 'default'){
       $this->constructDefaultLayout();
       }
    }
    
    
    public function constructDefaultLayout() {
        
        $this->addCssLink($this->getConfig('server', 'relativeUrl') . 'resources/screen.css');
        $this->addCssLink($this->getConfig('server', 'relativeUrl') . 'resources/print.css');

        //Begin Table Sorter Includes
        $this->addCssLink($this->getConfig('server', 'relativeUrl') . 'resources/tablesorter/jq.css');
        $this->addCssLink($this->getConfig('server', 'relativeUrl') . 'resources/tablesorter/style.css');
        $this->addJavascriptLink($this->getConfig('server', 'relativeUrl')
                . 'resources/jquery.1.11.1.js');
        $this->addJavascriptLink($this->getConfig('server', 'relativeUrl')
                . 'resources/tablesorter/__jquery.tablesorter.min.js');
        $this->addJavascriptLink($this->getConfig('server', 'relativeUrl')
                . 'resources/tablesorter/chili-1.8b.js');
        $this->addJavascriptLink($this->getConfig('server', 'relativeUrl')
                . 'resources/tablesorter/docs.js');
        $this->addJavascriptLink($this->getConfig('server', 'relativeUrl')
                . 'resources/jquery-form-validator/form-validator/jquery.form-validator.min.js');

        $this->addCssLink($this->getConfig('server', 'relativeUrl')
                . 'resources/jqueryui/themes/ui-lightness/jquery-ui.css');
        $this->addCssLink($this->getConfig('server', 'relativeUrl')
                . 'resources/jqueryui/themes/ui-lightness/theme.css');

//        $this->addCssLink('/resources/jquery-ui-1.11.0-beta.2.custom/jquery-ui.css');
        //       $this->addCssLink('/resources/jquery-ui-1.11.0-beta.2.custom/jquery-ui.structure.css');

        $this->layoutTopNavSmall();
        $this->generateNavBar();
    }
    
    
    private function generateNavBar() {
        //Debug::add(DEBUG_FUNCTION_TRACE);
        $level1 = 'Home';
        $level2 = '';
        switch (htmlspecialchars($_SERVER['PHP_SELF'])) {
            case "/index.php":
                $level1 = "Home";
                $level2 = "Start";
                break;
            case "/KSPSolarWorkshop/index.php":
                $level1 = "KSPSolarWorkshop";
                $level2 = "Start";
                break;
            case "/KSPSolarWorkshop/powerLab.php":
                $level1 = "KSPSolarWorkshop";
                $level2 = "PowerLab";
                break;
            case "/KSPSolarWorkshop/landerLab.php":
                $level1 = "KSPSolarWorkshop";
                $level2 = "LanderLab";
                break;
            case "/KSPHitlist/index.php":
                $level1 = "KSPHitlist";
                $level2 = "Submit";
                break;
            //case "/register.php":
            //    $level1 = "Home";
            //    $level2 = "Register";
            //    break;
            //case "/keepalive/index.php":
            //    $level1 = "KeepAlive";
            //    $level2 = "Start";
            //    break;
            //case "/keepalive/register.php":
            //    $level1 = "KeepAlive";
            //    $level2 = "Register";
        }


        $this->layoutNavLevel1(array(
            "Home" => "/index.php"
            ,"KSPSolarWorkshop" => "/KSPSolarWorkshop/index.php"
            ,"KSPHitlist" => "/KSPHitlist/index.php"
            
           // , "KerbalSpaceProgram" => "/KerbalSpaceProgram/index.php"
                //,"Recipees"=>"recipees.php"
                )
                , $level1);

        if ($level1 == 'KSPSolarWorkshop') {
            $this->layoutNavLevel2(array(
                "Start" => "/KSPSolarWorkshop/index.php"
                ,"PowerLab" => "/KSPSolarWorkshop/powerLab.php"
                , "LanderLab" => "/KSPSolarWorkshop/landerLab.php"
                //, "Register" => "register.php"
                //, "About" => "servies.php"
                //, "Contact" => "account.php"
                )
                    , $level2);
          
            
        } if ($level1 == 'KSPHitlist') {
            $this->layoutNavLevel2(array(
                "Start" => "/KSPSolarWorkshop/index.php"
                ,"Submit" => "/KSPSolarWorkshop/submit.php"
                , "Retrieve" => "/KSPSolarWorkshop/view.php"
                //, "Register" => "register.php"
                //, "About" => "servies.php"
                //, "Contact" => "account.php"
                )
                    , $level2);
          
            
        } elseif ($level1 == 'Home') {
            $this->layoutNavLevel2(array(
                "Start" => "index.php"
                //, "About" => "servies.php"
                //, "Contact" => "account.php"
                )
                    , $level2);
        }
    }

    private function layoutTopNavSmall($html = '') {
        //Debug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->addHeaderDiv('<div class="topNavSmallContent">' . $html . $this->newLine . '</div><!-- endTopNavSmallContent-->' . $this->newLine, "topNavSmall");
    }

    private function layoutTopTitle($html, $link, $subtitle) {
        //Debug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html . ', $link=' . $link . ', $subTitle=' . $subtitle);
        $this->addHeaderDiv('<div class="topTitleContent">' . $this->newLine
                . '<a href="' . $link . '">' . $this->newLine
                . $html . $this->newLine
                . '</a>' . $this->newLine
                . '<span>' . $this->newLine
                . $subtitle . $this->newLine
                . '</span>' . $this->newLine
                . '</div><!-- end topTitleContent -->' . $this->newLine, 'topTitle');
    }

    private function layoutNavLevel1($menuKeyValuePair, $selectedName) {
        //Debug::add('$menuKeyValuePair=' . print_r($menuKeyValuePair, 1) . '$selectedName=' . $selectedName);
        $out = '<ul>' . $this->newLine;

        foreach ($menuKeyValuePair as $key => $value) {
            if ($selectedName == $key) {
                $out .= '<li class="selected">' . $this->newLine .
                        '<a href="' . $value . '">' . $this->newLine
                        . $key . $this->newLine
                        . '</a>' . $this->newLine
                        . '</li>' . $this->newLine;
            } else {
                $out .= '<li>' . $this->newLine
                        . '<a href="' . $value . '">' . $this->newLine
                        . $key . $this->newLine
                        . '</a>' . $this->newLine
                        . '</li>' . $this->newLine;
            }
        }
        $out .= '</ul>' . $this->newLine;
        $this->addHeaderDiv('<div class="navLevel1Content">' . $this->newLine
                . $out
                . $this->newLine . '</div><!-- endNavLevel1Content -->', 'navLevel1');
    }

    private function layoutNavLevel2($menuKeyValuePair, $selectedName) {
        //Debug::add('$menuKeyValuePair=' . print_r($menuKeyValuePair, 1) . '$selectedName=' . $selectedName);
        $out = '<ul>' . $this->newLine;

        foreach ($menuKeyValuePair as $key => $value) {
            if ($selectedName == $key) {
                $out .= '<li class="selected"><a href="' . $value . '">' . $key . '</a></li>' . $this->newLine;
            } else {
                $out .= '<li><a href="' . $value . '">' . $key . '</a></li>' . $this->newLine;
            }
        }

        $out .= '</ul>' . $this->newLine;




        $this->addHeaderDiv('<div class="navLevel2Content">' . $this->newLine
                . $out . $this->newLine
                . '</div><!-- endNavLevel2Content-->' . $this->newLine, 'navLevel2');
    }

}
