<?php
/**
 * Plugin Now: Inserts a timestamp.
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Martyn Eggleton <martyn.eggleton@gmail.com>
 */

// must be run within DokuWiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'syntax.php';

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_ppecdg_formlink extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }
    public function getPType() { return 'normal'; }
    public function getSort() { return 307; }
    
    public function connectTo($mode) {
      $this->Lexer->addSpecialPattern('\{\{ppecgdformlink>.*?\}\}',$mode,'plugin_ppecdg_formlink');
    }
    
    public function handle($match, $state, $pos, &$handler){
      $tags = trim(substr($match, 15, -2));
      
      preg_match("(date[:|=][a-zA-Z0-9\-\d\@\%\.]*)",$tags,$date);
      preg_match("(form[:|=][a-zA-Z0-9\_\-\ \d\@\%\.]*)",$tags,$form);
      
      $data = array(
      'date' => trim(substr($date[0],5)),
      'form' => cleanID(trim(substr($form[0],5))),
      );
      
      return $data;
    }


    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){
          $renderer->doc .= "<a href='#".$data['form']."' class='ppecdg_formlink'>more options <span class='hidden'>".$data['date']."</span></a>";
          return true;
        }
        return false;
    }
}

