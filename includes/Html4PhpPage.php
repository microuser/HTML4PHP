<?php

include_once "Html4PhpUser.php";
/**
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
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

    public function __construct($title) {
        Html4PhpDebug::add();
        parent::__construct($title);
        $this->title = $title;
    }

    public function addJavascriptLink($src) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$src=' . $src);
        $this->javascript[] = '<script type="text/javascript" src="' . $src . '"></script>' . $this->newLine;
    }

    public function addJavascriptCode($code) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$code=' . $code);
        $this->javascript[] = '<script type="text/javascript">' . $code . '</script>' . $this->newLine;
    }

    public function addCssLink($href) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$href=' . $href);
        $this->css[] = '<link rel="stylesheet" type="text/css" href="' . $href . '">';
    }

    public function appendHead($html) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->head[] = $html;
    }

    public function appendHeader($html) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->header[] = $html;
    }

    public function appendFooter($html) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->footer[] = $html;
    }

    public function generateHead() {
        //TODO fix confusing terminology between HEAD (meta) and HEADER (style)
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
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
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        $out = '<!-- Begin Generate Header-->';

        foreach ($this->header as $headerItem) {
            $out .= $headerItem . $this->newLine;
        }

        $out .= '<!-- End Generate Header-->';
        return $out;
    }

    public function generateFooter() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        if (DEBUG & DEBUG_ECHO) {
            $this->appendFooter(Html4PhpDebugFooter());
        }
        $out = '<footer>';

        if (DEBUG & (DEBUG_VERBOSE + DEBUG_ECHO)) {
            $out .= '<div><pre>$_REQUEST=' . print_r($_REQUEST, 1) . '</pre></div>';
        }
        Html4PhpDebug::add(DEBUG_VERBOSE + DEBUG_ERROR_LOG, '$_REQUEST=' . print_r($_REQUEST, 1));

        foreach ($this->footer as $footerItem) {
            $out .= $footerItem . $this->newLine;
        }
        $out .= '</footer>' . $this->newLine;
        //Footer is within body element.
        $out .= '</body>';
        return $out;
    }

    public function generateBody() {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);

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
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        if(isset($html4PhpConfig)){
            //Prevent credentials from becomming exposed
            unset($html4PhpConfig);
        }
        return $this->generateHead() . $this->generateHeader() . $this->generateBody() . $this->generateFooter() . "</html>";
    }
    
    public function echoGeneratedPage(){
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE);
        echo $this->generatePage();
    }

    private function appendBody($html) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->body[] = $html;
    }

    public function add($html) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html);
        $this->appendBody($html . $this->newLine);
        return $html;
    }

    public function addDiv($html, $class = '', $extraTag = '') {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html . ', $class=' . $class . ', $extraTag=' . $extraTag);
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
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$html=' . $html . ', $class=' . $class . ', $extraTag=' . $extraTag);
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

    public function addTable($title = null, $theadArray = null, $tbodyArray = null, $tfootArray = null, $tableClass = 'tablesorter', $tableId = null) {
        Html4PhpDebug::add(DEBUG_FUNCTION_TRACE, '$title=' . $title . ', $treadArray=' . print_r($theadArray, 1) . ', $tbodyArray=' . print_r($tbodyArray, 1) . ', $tfootArray=' . print_r($tfootArray, 1) . ', $tableClass=' . $tableClass . ', $tableId=' . $tableId);
        //Consider allowing styling/javascript using the following pattern
        //$a = array();
        //$a['1,x'] = 'onclick="alert(\'YouClickedRow\');"';
        //$a['1,1'] = 'onclick="alert(\'YouClikcedCell\');"';

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

        if (strpos($tableClass, 'tablesorter') !== false) {
            $this->addJavascriptCode("	$(function() {
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
