<?php

include_once "Html4PhpUser.php";

/**
 * @version 2015-01-04
 * @category PHP Framework
 * @package HTML4PHP
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT OR GPL
 * <pre>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice, this permission notice, and the public RSA key shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
  -----BEGIN RSA PUBLIC KEY----- ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDfpROYHVyYHe2yok8Ut5OEmNzNriV9QGdzzPm1vFJSf8Wp9iBY74xf5oYdMmUOOfLlZfcrXP6Dc3VXOlTU7P46t14s9CcoGR6As2EamV7q9sAh4Nkr6xZb4kNdy9Bd4SxY/I3kxEbTpbpPq2T5B68xJWVjf83SQI43eyjO2Hv3iA8iEyifeyAGNVX46X3uuCsBftXF5Ng1GCCp6fMeCXeY0p3qmOg7m6SMGAXY97hKakNHPN2+vDP2fCOfefFmZihP/0mQNNLu1VNfI3MKonyfiHI4k1WAbFP2ozWSGmzv3dhej3wguYmRYKsgkK3ay5QoZQSLDHnZXtkuO9rJbAuz -----END RSA PUBLIC KEY-----
 * </pre>
 */
class Html4PhpPage extends Html4PhpUser {

    private $docType = '<!DOCTYPE html>';
    public $newLine = "\n";
    private $head = array();
    private $header = array();
    private $body = array();
    private $footer = array();
    private $title = '';
    private $css = array();
    private $javascript = array();
    private $javascriptFooter = array();

    public function __construct($title) {
        $this->addDebug();

        parent::__construct($title);
        $this->title = $title;
    }

    public function addJavascriptLink($src) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$src=' . $src);
        $this->javascript[] = '<script type="text/javascript" src="' . $src . '"></script>' . $this->newLine;
    }

    public function addJavascriptCode($code) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$code=' . $code);
        $this->javascript[] = '<script type="text/javascript">' . $code . '</script>' . $this->newLine;
    }

    public function addJavascriptCodeFooter($code) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$code=' . $code);
        $this->javascriptFooter[] = '<script type="text/javascript">' . $code . '</script>' . $this->newLine;
    }

    public function addCssLink($href) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$href=' . $href);
        $this->css[] = '<link rel="stylesheet" type="text/css" href="' . $href . '">';
    }

    public function appendHead($html) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->head[] = $html;
    }

    public function appendHeader($html) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->header[] = $html;
    }

    public function appendFooter($html) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->footer[] = $html;
    }

    public function generateHead() {
        //TODO fix confusing terminology between HEAD (meta) and HEADER (style)
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $head = '';
        $this->appendHead('<title>' . $this->title . '</title>');
        $this->appendHead('<meta charset="UTF-8">');

        foreach ($this->javascript as $javascriptItem) {
            $this->appendHead($javascriptItem);
        }

        foreach ($this->css as $cssItem) {
            $this->appendHead($cssItem);
        }

        foreach ($this->head as $headItem) {
            $head .= $headItem . $this->newLine;
        }

        return $this->docType . '<html>' . $this->newLine
                . '<head>' . $this->newLine
                . $head . $this->newLine
                . '</head>' . $this->newLine
                . '<body>';
    }

    public function generateHeader() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        $out = '<!-- Begin Generate Header-->';

        foreach ($this->header as $headerItem) {
            $out .= $headerItem . $this->newLine;
        }

        $out .= '<!-- End Generate Header-->';
        return $out;
    }

    public function generateFooter() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        if (DEBUG & DEBUG_ECHO) {
            $this->appendFooter("<pre>" . $this->getDebugHtml() . "</pre>");
        }
        $out = '<footer>';

        if (DEBUG & (DEBUG_VERBOSE + DEBUG_ECHO)) {
            $out .= '<div><pre>$_REQUEST=' . print_r($_REQUEST, 1) . '</pre></div>';
        }
        $this->addDebug(DEBUG_VERBOSE + DEBUG_ERROR_LOG, '$_REQUEST=' . print_r($_REQUEST, 1));

        foreach ($this->javascriptFooter as $javascriptItem) {

            $this->appendFooter($javascriptItem);
        }

        foreach ($this->footer as $footerItem) {
            $out .= $footerItem . $this->newLine;
        }
        $out .= '</footer>' . $this->newLine;
        //Footer is within body element.
        $out .= '</body>';



        return $out;
    }

    public function generateBody() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);

        $out = ('<div class="main">');
        $out .= ('<div class="mainContent">');

        foreach ($this->body as $line => $bodyItem) {
            $out .= "\n<!--Begin body line $line -->\n" . $bodyItem . "\n<!-- End body line $line -->\n";
        }
        $out.='</div>' . "<!-- endMainContent-->\n"; //end mainContent
        $out .= '</div>' . "<!-- endMain-->\n"; //end main
        return $out . "\n";
    }

    public function generatePage() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);

        return $this->generateHead() . $this->generateHeader() . $this->generateBody() . $this->generateFooter() . "</html>";
    }

    public function echoGeneratedPage() {
        $this->addDebug(DEBUG_FUNCTION_TRACE);
        echo $this->generatePage();
    }

    private function appendBody($html) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->body[] = $html;
    }

    public function add($html) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->appendBody($html . $this->newLine);
        return $html;
    }

    public function addDiv($html, $class = '', $extraTag = '') {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html . ', $class=' . $class . ', $extraTag=' . $extraTag);
        $out = "\n" . '<!-- beginAddDiv-->'
                . "\n" . '<div';
        if ($class !== '' && is_string($class)) {
            $out .= ' ' . 'class="' . $class . '"';
        }
        if ($extraTag !== '' && is_string($extraTag)) {
            $out .= ' ' . $extraTag;
        }
        $out .= '>' . $this->newLine;
        $out .= $html . $this->newLine;
        $out .= '</div> <!-- endAddDiv-->' . $this->newLine;
        $this->appendBody($out);
    }

    public function addHeaderDiv($html, $class = '', $extraTag = '') {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$html=' . $html . ', $class=' . $class . ', $extraTag=' . $extraTag);
        $out = "\n" . '<!-- beginAddHeaderDiv-->'
                . "\n" . '<div';
        if ($class !== '' && is_string($class)) {
            $out .= ' ' . 'class="' . $class . '"';
        }
        if ($extraTag !== '' && is_string($extraTag)) {
            $out .= ' ' . $extraTag;
        }
        $out .= '>' . $this->newLine;
        $out .= $html . $this->newLine;
        $out .= '</div> <!-- endAddHeaderDiv-->' . $this->newLine;
        $this->appendHeader($out);
    }

    private function makeArrayOfArrayByRef(&$tbodyArray, &$theadArray = null) {

        if (!is_array($theadArray)) {
            $theadArray = array($theadArray);
        }

        $isValidArray = is_array($tbodyArray) && is_array($tbodyArray[0]);

        //If its not a valid array, look at the theadarray, find if its susposed to be vertical list to make it valid
        if (sizeof($theadArray) === 1 && is_array($tbodyArray) && !is_array($tbodyArray[0])) {
            foreach ($tbodyArray as $horizontalArray) {
                $verticalArray[] = array($horizontalArray);
            }
            $tbodyArray = $verticalArray;
            $isValidArray = true;
        }
        //If tbody is not a valid array, or even an array, it must be a single item
        if (!is_array($tbodyArray)) {
            $tbodyArray = array(array($tbodyArray));
            $isValidArray = true;
        }
        //if tbody is not a valid array, and it should be horizontal, then make it one
        if (!$isValidArray && sizeof($theadArray > 1)) {
            $tbodyArray = array($tbodyArray);
            $isValidArray = true;
        }
        return $isValidArray;
    }

    public function addTable($title = null, $theadArray = null, $tbodyArray = null, $tfootArray = null, $tableClass = 'tablesorter', $tableId = null) {
        $this->addDebug(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $treadArray=' . print_r($theadArray, 1) . ', $tbodyArray=' . print_r($tbodyArray, 1) . ', $tfootArray=' . print_r($tfootArray, 1) . ', $tableClass=' . $tableClass . ', $tableId=' . $tableId);
        //Consider allowing styling/javascript using the following pattern
        //$a = array();
        //$a['1,x'] = 'onclick="alert(\'YouClickedRow\');"';
        //$a['1,1'] = 'onclick="alert(\'YouClikcedCell\');"';

        $isValidArray = $this->makeArrayOfArrayByRef($tbodyArray, $theadArray);


        $tableList = array();

        //Build the THEAD
        //The THEAD tag will handle these attributes:
        //ALIGN
        //BGCOLOR
        //CHAR
        //CHAROFF
        //VALIGN
        $tableList[] = '<div class="tableContainer">';
        $tableList[] = '<div class="tableTitle">' . $title . '</div>';
        //$tableList[] = '<div class="tableData">';


        $tableTag = '<table';
        if ($tableClass != '') {
            $tableTag .= ' class="' . $tableClass . '"';
        }

        //if tableId is provded then use that
        if ($tableId != null && $tableId != '') {
            $tableTag .= ' id="' . $tableId . '"';
        } else {
            //if tableClass contains tablesorter and its not set then make dynamic
            if (strpos($tableClass, 'tablesorter') !== false) {
                $tableId = 'table' . microtime(true) * 10000 % 100000 . rand(0, 99999); //assumes page loads won't take more than a minute or so
                $tableTag .= ' id="' . $tableId . '"';
            }
        }

        if ($isValidArray && strpos($tableClass, 'tablesorter') !== false) {
            $this->addJavascriptCodeFooter("	$(function() {
		$('#" . $tableId . "').tablesorter({sortList:[[0,0]], widgets: ['zebra']});
	});");
        }


        $tableTag .= '>';

        $tableList[] = $tableTag;

        if ($theadArray != null && is_array($theadArray)) {
            $theadHtml = '<thead>';
            $theadHtml .= '<tr>';
            foreach ($theadArray as $theadCell) {
                $theadHtml .= '<th>' . $theadCell . '</th>';
            }
            $theadHtml .= '</tr>';
            $theadHtml .= '</thead>';
        }
        $tableList[] = $theadHtml;
        unset($theadHtml);

        $tableList[] = '<tbody>';

        //Build the TABLE body
        if ($isValidArray) {
            foreach ($tbodyArray as $tableRow) {

                $colSpan = 1;
                $tableList[] = '<tr>';
                foreach ($tableRow as $colNum => $tableCell) {
                    if ($tableCell === '&colspan') {
                        //Incriment colspan
                        $colSpan += 1;
                        //Delete the last entry
                        array_pop($tableList);

                        //rewrite last entry by accessing $tableRow[$colNum-$colSpan]
                        $tableList[] = '<td colspan = "' . $colSpan . '">' . $tableRow[$colNum - $colSpan + 1] . '</td>';
                    } else {
                        $tableList[] = '<td>' . $tableCell . '</td>';
                    }
                }
                $tableList[] = '</tr>';
            }
        }
        $tableList[] = '</tbody>';

        //Build the TFOOT
        //The THEAD tag will handle these attributes:
        //ALIGN
        //BGCOLOR
        //CHAR
        //CHAROFF
        //VALIGN
        $tfootHtml = '';
        if ($tfootArray != null && is_array($tfootArray)) {
            $tfootHtml .= '<tfoot>';
            $tfootHtml .= '<tr>';
            foreach ($tfootArray as $tfootCell) {
                $tfootHtml .= '<td>' . $tfootCell . '</td>';
            }
            $tfootHtml .= '</tr>';
            $tfootHtml .= '</tfoot>';
        }
        $tableList[] = $tfootHtml;
        unset($tfootHtml);


        $tableList[] = '</table>';

        $out = '';
        foreach ($tableList as $tableItem) {
            $out .= $tableItem . $this->newLine;
        }

        $out .= '</div>';
        $this->appendBody($out);
    }

}
