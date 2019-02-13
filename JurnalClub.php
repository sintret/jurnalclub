<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class JurnalClub extends GenericPlugin {

    function register($category, $path) {
        if (parent::register($category, $path)) {
            HookRegistry::register(
                    'Mail::​send', array(&$this, 'callback')
            );
            return true;
        }
        return false;
    }

    function getName() {
        return 'JurnalClub';
    }

    function getDisplayName() {
        return 'Jurnal Club chat platform';
    }

    function getDescription() {
        return 'Jurnal Club is Notification for OJS Multi chat platform';
    }

    /*
     * &$mail, &$recipients, &$subject, &$mailBody, &$headers, &$additionalParameters
     */

    function callback($hookName, $args) {
        
        error_log(print_r($args, true));


        $curl = curl_init();

        $token = "adcsPHFHGQZOoOplVD6sFYkMBc48zJIe3jE4uMhspLLQ0hnaeF";
        $to = "6281575068530";
        $text = json_encode($args);

        $post = [
            'token' => $token,
            'to' => $to,
            'text' => $text,
        ];


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://jurnalclub/api/send/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 704a7882-9b60-5b22-21a1-b0958b2a05b8"
            ),
        ));

        $response = curl_exec($curl);
        return false;
    }

}

?>