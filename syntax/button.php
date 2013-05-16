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
class syntax_plugin_ppecdg_button extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }
    public function getPType() { return 'normal'; }
    public function getSort() { return 307; }
    
    public function connectTo($mode) {
      $this->Lexer->addSpecialPattern('\{\{ppecgd>.*?\}\}',$mode,'plugin_ppecdg_button');
    }
    
    public function handle($match, $state, $pos, &$handler){
      $tags = trim(substr($match, 9, -2));
      // parse geotag content
      preg_match("(amount[:|=][a-zA-Z\d\@\%\.]*)",$tags,$amount);
      preg_match("(name[:|=][a-zA-Z\@\%\:\/\s\w'-]*)",$tags,$name);
      #preg_match("(pageid[:|=][a-zA-Z\@\%\:\s\w'-]*)",$tags,$pageid);
      preg_match("(id[:|=][a-zA-Z\@\%\:\s\w'-]*)",$tags,$btnid);
      preg_match("(cal[:|=]true)",$tags,$cal);
      //echo "\n<br><pre>\ncal =" .var_export($cal, TRUE)."</pre>";
      
      $data = array(
      'item_amount' => trim(substr($amount[0],7)),
      'item_name'   => trim(substr($name[0],5)),
      #'pageid' => trim(substr($pageid[0],7)),
      'btnclass'    => 'ppecdg-btn',
      );
      if(count($cal[0]))
      {
        $data['btnclass'] = 'cal-ppecdg-btn';
      }
      
      if(count($btnid[0]))
      {
        $data['btnid'] = trim(substr($btnid[0],3));
      }
      else
      {
         $data['btnid'] = str_replace(array('/',':',' '),'_',$data['item_name']);
      }
      
      //echo "\n<br><pre>\ndata =" .var_export($data, TRUE)."</pre>";
      
      return $data;
    }


    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){
          $renderer->doc .= "<form action='".DOKU_BASE."lib/plugins/ppecdg/checkout.php' METHOD='POST'>
          <input type='hidden' name='item_name' value='".$data['item_name']."' />
          <input type='hidden' name='item_amount' value='".$data['item_amount']."' />
        	<input type='image' name='paypal_submit' class='".$data['btnclass']."' id='".$data['btnid']."'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' alt='Pay with PayPal'/></form>";
          return true;
        }
        return false;
    }
}

