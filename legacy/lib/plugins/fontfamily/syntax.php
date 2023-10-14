<?php
/**
 * fontfamily Plugin: control the font-family of your text
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      Thorsten Stratmann <thorsten.stratmann@web.de>
 * @link          http://wiki.splitbrain.org/plugin:fontfamily
 * @version    0.1
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_fontfamily extends DokuWiki_Syntax_Plugin {
 
    function getInfo(){  // return some info
        return array(
            'author' => 'Thorsten Stratmann',
            'email'  => 'thorsten.stratmann@web.de',
            'date'   => '2009-02-04',
            'name'   => 'fontfamily Plugin',
            'desc'   => 'With fontfamily you can control the typeface of your text
                         Syntax: <ff Value>Your Text</ff>',
            'url'    => 'http://wiki.splitbrain.org/plugin:fontfamily',
        );
    }
 
     // What kind of syntax are we?
    function getType(){ return 'formatting'; }
	
    // What kind of syntax do we allow (optional)
    function getAllowedTypes() {
        return array('formatting', 'substition', 'disabled');
    }
   
   // What about paragraphs? (optional)
   function getPType(){ return 'normal'; }
 
    // Where to sort in?
    function getSort(){ return 92; }
 
 
    // Connect pattern to lexer
    function connectTo($mode) {
      $this->Lexer->addEntryPattern('(?i)<ff(?: .+?)?>(?=.+</ff>)',$mode,'plugin_fontfamily');
    }
    function postConnect() {
      $this->Lexer->addExitPattern('(?i)</ff>','plugin_fontfamily');
    }
 
 
    // Handle the match
    function handle($match, $state, $pos, &$handler)
    {
        switch ($state) 
        {
          case DOKU_LEXER_ENTER : 
            preg_match("/(?i)<ff (.+?)>/", $match, $ff);   // get the fontfamily
           if ( $this->_isValid($ff[1]) ) return array($state, $ff[1]);
			break;
			case DOKU_LEXER_MATCHED :
			break;
			case DOKU_LEXER_UNMATCHED :
			return array($state, $match);
			break;
			case DOKU_LEXER_EXIT :
			break;
			case DOKU_LEXER_SPECIAL :
			break;
		}
		return array($state, "");
	}
 
    // Create output
    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){
          list($state, $ff) = $data;
          switch ($state) {
            case DOKU_LEXER_ENTER : 
              $renderer->doc .= "<span style=\"font-family: $ff\">";
              break;
            case DOKU_LEXER_MATCHED :
              break;
            case DOKU_LEXER_UNMATCHED :
              $renderer->doc .= $renderer->_xmlEntities($ff);
              break;
            case DOKU_LEXER_EXIT :
              $renderer->doc .= "</span>";
              break;
            case DOKU_LEXER_SPECIAL :
              break;
          }
          return true;
        }
        return false;
    }
    function _isValid($c) {
 
        $c = trim($c);
 
        $pattern = "/^(Times New Roman|Arial|Brush Script MT|Comic Sans MS|Georgia|Impact|Trebuchet|Verdana|Webdings])/x";
 
  //      if (preg_match($pattern, $c)) return true;
    return true;
    }
}
