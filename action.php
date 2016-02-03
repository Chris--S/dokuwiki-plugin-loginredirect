<?php
/**
 * Action Plugin:   Redirect login, for use with external auth methods
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christopher Smith <chris@jalakai.co.uk>  
 * @date       2006-12-12
 * @date       2013-02-14
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

/**
 * All DokuWiki action plugins need to inherit from this class
 */
class action_plugin_loginredirect extends DokuWiki_Action_Plugin {

    /*
     * plugin should use this method to register its handlers with the dokuwiki's event controller
     */
    function register(Doku_Event_Handler $controller) {
      $controller->register_hook('ACTION_ACT_PREPROCESS','BEFORE', $this, 'handle_loginredirect');
    }

    function handle_loginredirect(&$event, $param) {
      if ($event->data === 'login') {
        $this->do_redirect($this->getConf('url'));
      } else if ($event->data === 'logout') {
        $this->do_redirect($this->getConf('logout_url'));
      }
    }

    function do_redirect($url) {
      global $ID;

      if (empty($url)) return;

      $return_key = $this->getConf('return_key');
      $query_string = $return_key ? '?'.$return_key.'='.wl($ID) : '';

      header("Location: {$url}{$query_string}");
      exit();
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :
