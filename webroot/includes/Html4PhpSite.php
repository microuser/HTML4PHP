<?php

include_once 'Html4PhpPage.php';
include_once 'Html4PhpValidator.php';

/**
 * @version 2015-01-12
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
class Html4PhpSite extends Html4PhpPage {

    private $resources = array();
    private $menu = array();
    private $menuTooltips = array();
    private $titleName;
    private $titleLink = 'index.php';
    private $topNav = '';
    private $validator = null;

    public function __construct($title) {
        parent::__construct($title);
        $this->validator = new Html4PhpValidator();
        $this->titleName = $title;

        include($this->getConfig('server', 'documentRoot') . 'layouts/' . $this->getConfig('site', 'layout') . '/resources.php');
        include($this->getConfig('server', 'documentRoot') . 'layouts/' . $this->getConfig('site', 'layout') . '/menu.php');
        include($this->getConfig('server', 'documentRoot') . 'layouts/' . $this->getConfig('site', 'layout') . '/menuTooltips.php');


        //TODO, call upon generate head.
        $this->constructLayout();
    }

    public function getValidator() {
        if ($this->validator === null) {
            $this->validator = new Html4PhpValidator();
        }
        return $this->validator;
    }

    public function constructLayout() {

        $relativeUrl = $this->getConfig('server', 'relativeUrl');
        if (isset($this->resources['js'])) {
            //This variable was set in webroot/layouts/default/resources.php
            foreach ($this->resources['js'] as $js) {
                $this->addJavascriptLink($relativeUrl . $js);
            }
        }

        if (isset($this->resources['css'])) {
            //This variable was set in webroot/layouts/default/resources.php
            foreach ($this->resources['css'] as $css) {
                $this->addCssLink($relativeUrl . $css);
            }
        }




        $this->generateLoginTopNavSmall();
        $this->layoutTopTitle($this->titleName, $this->titleLink, $this->topNav);
        $this->generateNavBar();
    }

    private function generateLoginTopNavSmall() {

        if (
                $this->getIsLoggedIn()
        ) {
            $this->layoutTopNavSmall("<a href=\"/login/logout.php\">Logout</a>");
        } else {
            $this->layoutTopNavSmall("<a href=\"/login/index.php\">Login</a>");
        }
    }

    /**
     * Generates the navbar from the given data in /webroot/layouts/default/menu.php
     * The idea of $self parameter is to allow MVC type location masking, in the future.
     * @param type $self
     */
    private function generateNavBar($self = null) {

        //use link to find where we are at.
        if ($self === null) {
            $self = htmlspecialchars($_SERVER['PHP_SELF']);
        }

        $selectedItemName = ''; //Home';
        $selectedSubItemName = 'Home';
        $itemMenu = array();
        $subItemMenu = array('Home' => '/index.php');
        if ($this->getIsLoggedIn()) {
            $loginMenu = array("Logout" => "/login/logout.php");
        } else {
            $loginMenu = array("Login" => "/login/index.php", "Register" => "/login/create.php");
        }
        if (isset($this->menu) && isset($this->menu['Home']) && isset($this->menu['Home'][1])) {
            $this->menu['Home'][1] = array_merge($this->menu['Home'][1], $loginMenu);
        }

        //Menu Items are in layout/default/menu.php
        foreach ($this->menu as $itemName => $subItems) {
            $itemLink = $subItems[0];
            $itemMenu[$itemName] = $itemLink;
            //If link matches level 1, it may not match subitems
            if ($itemLink === $self) {
                $selectedItemName = $itemName;
                $subItemMenu = $subItems[1];
            }
            //Find selected in list
            foreach ($subItems[1] as $subItemName => $subItemLink) {
                $subItemLink = explode("?", $subItemLink, 2)[0]; //Everything before the GET variables
                if ($subItemLink === $self) {
                    $selectedItemName = $itemName;
                    $selectedSubItemName = $subItemName;
                    $subItemMenu = $subItems[1];
                }
            }

            if ($selectedItemName === '' && isset($subItems[2])) {
                foreach ($subItems[2] as $hiddenSubItemLink) {
                    if ($hiddenSubItemLink === $self) {
                        $selectedItemName = $itemName;
                        $selectedSubItemName = $subItemName;
                        $subItemMenu = $subItems[1];
                    }
                }
            }
        }


        $this->layoutNavLevel1($itemMenu, $selectedItemName, $this->menuTooltips);
        if (isset($this->menu[$selectedItemName]) && isset($this->menu[$selectedItemName][1])) {
            if (isset($this->menuTooltips) && isset($this->menuTooltips[$selectedItemName]) && is_array($this->menuTooltips[$selectedItemName][1])) {
                $tooltips2 = $this->menuTooltips[$selectedItemName][1];
            } else {
                $tooltips2 = array();
            }
            $this->layoutNavLevel2($this->menu[$selectedItemName][1], $selectedSubItemName, $tooltips2);
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

    /**
     * Where Key is name, and value is link
     * @param type $menuKeyValuePair
     * @param type $selectedName
     */
    private function layoutNavLevel1($menuKeyValuePair, $selectedName, $tooltips = array()) {
        //Debug::add('$menuKeyValuePair=' . print_r($menuKeyValuePair, 1) . '$selectedName=' . $selectedName);
        $out = '<ul>' . $this->newLine;

        foreach ($menuKeyValuePair as $key => $value) {
            if (isset($tooltips[$key]) && isset($tooltips[$key][0]) && is_string($tooltips[$key][0])) {
                $tooltip = ' title="' . $tooltips[$key][0] . '"';
            } else {
                $tooltip = '';
            }
            if ($selectedName == $key) {
                $out .= '<li class="selected"' . $tooltip . '>' . $this->newLine .
                        '<a href="' . $value . '">' . $this->newLine
                        . $key . $this->newLine
                        . '</a>' . $this->newLine
                        . '</li>' . $this->newLine;
            } else {
                $out .= '<li' . $tooltip . '>' . $this->newLine
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

    private function layoutNavLevel2($menuKeyValuePair, $selectedName, $tooltips = array()) {
        //Debug::add('$menuKeyValuePair=' . print_r($menuKeyValuePair, 1) . '$selectedName=' . $selectedName);
        $out = '<ul>' . $this->newLine;

        foreach ($menuKeyValuePair as $key => $value) {
            if (isset($tooltips) && isset($tooltips[$key])) {
                $tooltip = ' title="' . $tooltips[$key] . '"';
            } else {
                $tooltip = '';
            }

            if ($selectedName == $key) {
                $out .= '<li class="selected"' . $tooltip . '><a href="' . $value . '">' . $key . '</a></li>' . $this->newLine;
            } else {
                $out .= '<li' . $tooltip . '><a href="' . $value . '">' . $key . '</a></li>' . $this->newLine;
            }
        }

        $out .= '</ul>' . $this->newLine;




        $this->addHeaderDiv('<div class="navLevel2Content">' . $this->newLine
                . $out . $this->newLine
                . '</div><!-- endNavLevel2Content-->' . $this->newLine, 'navLevel2');
    }

}
