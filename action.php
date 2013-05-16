<?php
/**
 * cookieCuttr Plugin:   EU cookie law compatible.
 *
 * @author     Martyn Eggleton <martyn.eggleton@gmail.com>
 */

if(!defined('DOKU_INC')) die();


class action_plugin_ppecdg extends DokuWiki_Action_Plugin {

    /**
     * Register its handlers with the DokuWiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this,
                                   '_hookjs');
    }

    
    function _hookjs(&$event, $param) {
      
        $event->data['script'][] = array(
            'type'    => 'text/javascript',
            #'charset' => 'utf-8',
            '_data'   => '',
            'src'     => 'https://www.paypalobjects.com/js/external/dg.js');
       
        /*
        $event->data["script"][] = array (
            "type" => "text/javascript",
        #    "charset" => "utf-8",
            "_data" => "var dg = new PAYPAL.apps.DGFlow({trigger: 'paypal_submit',expType: 'instant'});",
          );
        */
    }
}
