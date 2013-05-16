<?php
/**
 * DokuWiki PayPal Express Checkout
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Martyn Eggleton <martyn.eggleton@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/infoutils.php');


/**
 * This is the base class for all syntax classes, providing some general stuff
 */
class helper_plugin_ppecdg extends DokuWiki_Plugin {
  
  public function __construct(){
    global $conf;
    
    $sHost = DOKU_URL;
    $aHost = parse_url($sHost);
    $this->_sHost = $aHost['host'].$aHost['path'];
  }
  
}
