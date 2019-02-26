<?php

/**
 * @file plugins/generic/jurnalclub/JurnalClubPlugin.inc.php
 *
 * Copyright (c) 2019 Andhiefitria Rosmin 
 * Copyright (c) 2019 sintret@gmail.com
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class JurnalClubPlugin
 * @ingroup plugins_generic_jurnalclub
 *
 */
import('lib.pkp.classes.plugins.GenericPlugin');

class JurnalClubPlugin extends GenericPlugin {

    /**
     * Register the plugin, if enabled; note that this plugin
     * runs under both Journal and Site contexts.
     * @param $category string
     * @param $path string
     * @return boolean
     */
    function register($category, $path) {

        if (parent::register($category, $path)) {
            HookRegistry::register('Mail::send', array(&$this, 'callback'));

            $hooks = HookRegistry::getHooks();
            return true;
        }
        return false;
    }

    /**
     * Hook callback function for Email::send
     * @param $hookName string
     * @param $args array
     * @return boolean
     */
    function callback($hookName, $args) {

        $this->log($args[0], 'email');

        return false;
    }

    /**
     * Get the display name of this plugin
     * @return string
     */
    function getDisplayName() {
        return "Jurnal Club";
    }

    function getToken() {
        $myfile = fopen(__DIR__ . DIRECTORY_SEPARATOR . "token.txt", "r") or die("Unable to open file!");
        $token = fread($myfile, filesize(__DIR__ . DIRECTORY_SEPARATOR . "token.txt"));
        fclose($myfile);

        return $token;
    }

    /**
     * Get the description of this plugin
     * @return string
     */
    function getDescription() {
        return "Jurnal Club for OJS";
    }

    function log($text, $key = 'text') {

        $token = $this->getToken();
        if ($token) {
            $curl = curl_init();
            $to = "6281575068530";

            $post = [
                $key => $text,
                token => $token,
            ];

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://jurnal.club/api/ojs",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($post),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            return $response;
        }
    }
}

?>