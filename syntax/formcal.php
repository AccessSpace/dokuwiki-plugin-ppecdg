<?php
/**
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Martyn Eggleton <martyn.eggleton@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
 * This inherits from the table syntax of the data plugin, because it's basically the
 * same, just different output
 */
class syntax_plugin_ppecdg_formcal extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * What about paragraphs?
     */
    function getPType(){
        return 'block';
    }

    /**
     * Where to sort in?
     */
    function getSort(){
        return 157;
    }

    
    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('----+ *ppecdgformcal(?: [ a-zA-Z0-9_]*)?-+\n.*?\n----+',
                                        $mode, 'plugin_ppecdg_formcal');
    }

    function handle($match, $state, $pos, &$handler){
        $start_date = date('Y-m-01');
        $length_months = 12;
        $groupby = false;
        $lines = explode("\n", $match);
        foreach ($lines as $num => $line) {
            // ignore comments
            $line = preg_replace('/(?<![&\\\\])#.*$/', '', $line);
            $line = str_replace('\\#','#',$line);
            $line = trim($line);
            if(empty($line)) continue;
            $line = preg_split('/\s*:\s*/', $line, 2);
            if (strtolower($line[0]) == 'start_date') {
                $start_date = $line[1];
                unset($lines[$num]);
            }
            elseif (strtolower($line[0]) == 'months') {
                $length_months = $line[1];
                unset($lines[$num]);
            }
        }
        $match = implode("\n", $lines);
        
        if(!empty($start_date)) {
            $data['start_date'] = $start_date;
        }
        
        if(!empty($length_months)) {
            $data['length_months'] = $length_months;
        }
        
        //echo "\n<br><pre>\ndata =" .var_export($data, TRUE)."</pre>";
        return $data;
    }

    /**
     * Create output
     */
    function render($format, &$R, $data) {
        global $ID;
        if(is_null($data)) return false;

        if($format == 'metadata') {
            // Remove metadata from previous plugin versions
            //$this->dtc->removeMeta($R);
        }

        if($format == 'xhtml') {
           
          
          $o1Day = new DateInterval('P1D');
          $oStartDate = new DateTime($data['start_date']);
          $oDate = new DateTime();
          
          $length_months = $data['length_months'];
          $aData = array();
          $R->doc .= "<br><div class='ppecdg-calform'><form action='".DOKU_BASE."lib/plugins/ppecdg/checkout.php' METHOD='POST'>
          Date <input name='date_value' class='data-calform-date' value='".$oDate->format('Y-m-d')."' />
          Price ";
          
          #$R->doc .= "<input name='item_amount' class='data-calform-price' value='".($oDate->format('z')+1)."' />";
          $iDate = $oDate->format('z')+1;
          
          $R->doc .= "<select name='item_amount' class='data-calform-price'>";
          for($i = 1; $i <= 365; $i++)
          {
          
            $R->doc .= "<option value='".$i."' ".($iDate===$i?' selected="true" ':'').">&pound;".$i."</option>";
          }
          
          $R->doc .= "</select>";
          
          $R->doc .= "<input type='hidden' name='item_name' class='data-calform-name' value='Sponsor A Day/".$oDate->format('Y-m-d')."' />
          <input type='image' name='paypal_submit' class='ppecdg-btn' id='calform".rand(1, 1000)."'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' alt='Pay with PayPal'/>
</form></div>";           
            return true;
        }
        return false;
    }

    
}
/* Local Variables: */
/* c-basic-offset: 4 */
/* End: */
