<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (! class_exists('StandalonePHPEnkoder')) {
    require_once PATH_THIRD.'Mx_obfuscator/helper/StandalonePHPEnkoder.php';
}

/**
 * MX Obfuscator Plugin class.
 *
 * @author         Max Lazar <max@eecms.dev>
 *
 * @see           http://eecms.dev/
 *
 * @license        http://opensource.org/licenses/MIT
 */

class Mx_obfuscator
{
    // --------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------

    /**
     * Package name.
     *
     * @var string
     */
    protected $package;

    /**
     * Plugin return data.
     *
     * @var string
     */
    public $return_data;

    /**
     * Plugin return data.
     *
     * @var string
     */
    public $settings = array(
    );

    /**
     * Site id shortcut.
     *
     * @var int
     */
    protected $site_id;


    // --------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @return string
     */
    public function __construct()
    {

        $data                  = ee()->TMPL->tagdata;
        $enkoder               = new StandalonePHPEnkoder();

        $encodeMailto          = ee()->TMPL->fetch_param('encodeMailto', 'yes');
        $encodePlaintextEmails = ee()->TMPL->fetch_param('encodePlaintextEmails', 'yes');

        $enkoder->enkode_msg = (!ee()->TMPL->fetch_param('encoded_msg')) ?$enkoder->enkode_msg : ee()->TMPL->fetch_param('encoded_msg');

        if ($encodeMailto == "yes" && $encodePlaintextEmails == 'yes') {
            $data       =  $enkoder->enkodeAllEmails($data);
        } elseif ($encodeMailto == "no") {
            $data       =  $enkoder->enkodePlaintextEmails($data);
        } else {
            $data       =  $enkoder->enkodeMailtos($data);
        }


        return $this->return_data = $data;
    }



    /**
     * Simple method to log a debug message to the EE Debug console.
     *
     * @param string $method
     * @param string $message
     */
    protected function logDebugMessage($method = '', $message = '')
    {
        ee()->TMPL->log_item('&nbsp;&nbsp;***&nbsp;&nbsp;'.$this->package." - $method debug: ".$message);
    }
}
// END CLASS

/* End of file pi.mx_obfuscator.php */
