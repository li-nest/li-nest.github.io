<?php
/**
 * Add Note capability to dokuwiki
 *
 * <note>This is note</note>
 * <note classic>This is note</note>
 * <note important>This is an important note</note>
 * <note warning>This is a big warning</note>
 * <note tip>This is a tip</note>
 *
 * by Olivier Cortès <olive@deep-ocean.net>
 * under the terms of the GNU GPL v2.
 *
 * Originaly derived from the work of :
 * Stephane Chamberland <stephane.chamberland@ec.gc.ca> (Side Notes PlugIn)
 * Carl-Christian Salvesen <calle@ioslo.net> (Graphviz plugin)
 *
 * Contributions by Eric Hameleers <alien [at] slackware [dot] com> :
 *   use <div> instead of <table>,
 *   contain the images and stylesheet inside the plugin,
 *   permit nesting of notes,
 *
 * Contributed by Christopher Smith <chris [at] jalakai [dot] co [dot] uk>
 *   fix some parsing problems and a security hole.
 *   make note types case independent
 *   simplify code reading
 *   modernise the plugin for changes/fixes/improvements to the underlying Dokuwiki plugin class,
 *   improve efficiency.
 *
 * @license    GNU_GPL_v2
 * @author     Olivier Cortes <olive@deep-ocean.net>
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');


class syntax_plugin_note extends DokuWiki_Syntax_Plugin {
 
    var $notes = array(
        'noteimportant' => array('important', 'importante'),
        'notewarning'   => array('warning','bloquante','critique'),
        'notetip'       => array('tip','tuyau','idée'),
        'noteclassic'   => array('','classic','classique')
      );
      
    var $default = 'noteclassic';
  
    function getInfo(){
        return array(
            'author' => 'Olivier Cortès / Eric Hameleers / Christopher Smith',
            'email'  => 'olive@deep-ocean.net',
            'date'   => '2006-03-29',
            'name'   => 'Note Plugin',
            'desc'   => 'Add Note/Important/Tip/Warning Capability (DIV+CSS box)',
            'url'    => 'http://wiki.splitbrain.org/plugin:note',
        );
    }
 
 
    function getType(){ return 'container'; }
    function getPType(){ return 'normal'; }
    function getAllowedTypes() { 
        return array('container','substition','protected','disabled','formatting','paragraphs');
    }
    function getSort(){ return 195; }

    // override default accepts() method to allow nesting 
    // - ie, to get the plugin accepts its own entry syntax
    function accepts($mode) {
      if ($mode == substr(get_class($this), 7)) return true;
        return parent::accepts($mode);
      }

    function connectTo($mode) {
        $this->Lexer->addEntryPattern('<note.*?>(?=.*?</note>)',$mode,'plugin_note');
    }
    function postConnect() {
        $this->Lexer->addExitPattern('</note>','plugin_note');
    }
 
    function handle($match, $state, $pos, &$handler){

        switch ($state) {

          case DOKU_LEXER_ENTER : 
            $note = strtolower(trim(substr($match,5,-1)));
 
            foreach( $this->notes as $class => $names ) {
              if (in_array($note, $names))
                return array($state, $class);
            }            
            
            return array($state, $this->default);          
 
          case DOKU_LEXER_UNMATCHED :
            return array($state, $match);
        
          default:
            return array($state);
        }
    }
 
    function render($mode, &$renderer, $indata) {

        if($mode == 'xhtml'){

          list($state, $data) = $indata;

          switch ($state) {
            case DOKU_LEXER_ENTER :
              $renderer->doc .= '</p><div class="'.$data.'">';
              break;
  
            case DOKU_LEXER_UNMATCHED :
              $renderer->doc .= $renderer->_xmlEntities($data);
              break;
  
            case DOKU_LEXER_EXIT :
              $renderer->doc .= "\n</div><p>";
              break;
          }
          return true;
        }
        
        // unsupported $mode
        return false;
    } 
}
 
//Setup VIM: ex: et ts=4 enc=utf-8 :
?>
