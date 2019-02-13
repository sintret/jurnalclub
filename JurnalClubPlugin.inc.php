<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class JurnalClubPlugin extends GenericPlugin {

    function register($category, $path) {
        if (parent::register($category, $path)) {

            HookRegistry::register('Mail::​send', array(&$this, 'callback'));
            HookRegistry::register('ReviewerAction::​confirmReview', array(&$this, 'callback'));
            HookRegistry::register('ReviewerAction::​recordRecommendation', array(&$this, 'callback'));
            HookRegistry::register('ReviewerAction::​postPeerReviewComment', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​notifyReviewer', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​cancelReview', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​remindReviewer', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​thankReviewer', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​unsuitableSubmission', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​notifyAuthor', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​notifyCopyeditor', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​thankCopyeditor', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​notifyAuthorCopyedit', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​thankFinalCopyedit', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​thankLayoutEditor', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​postPeerReviewComment', array(&$this, 'callback'));

            HookRegistry::register('SectionEditorAction::​postEditorDecisionCommen', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​emailEditorDecisionComment', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​blindCcReviewsToReviewers', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​postCopyeditComment', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​postLayoutComment', array(&$this, 'callback'));
            HookRegistry::register('SectionEditorAction::​postProofreadComment', array(&$this, 'callback'));
            HookRegistry::register('ArticleEmailLogDAO::​_returnLogEntryFromRow', array(&$this, 'callback'));
            HookRegistry::register('EmailTemplateDAO::​_returnBaseEmailTemplateFromRow', array(&$this, 'callback'));
            HookRegistry::register('EmailTemplateDAO::​_returnLocaleEmailTemplateFromRow', array(&$this, 'callback'));
            HookRegistry::register('EmailTemplateDAO::​_returnEmailTemplateFromRow', array(&$this, 'callback'));
            HookRegistry::register('AuthorAction::​completeAuthorCopyedit', array(&$this, 'callback'));
            HookRegistry::register('AuthorAction::​emailEditorDecisionComment', array(&$this, 'callback'));
            HookRegistry::register('AuthorAction::​postCopyeditComment', array(&$this, 'callback'));
            HookRegistry::register('AuthorAction::​postProofreadComment', array(&$this, 'callback'));

            HookRegistry::register('Action::​saveComment', array(&$this, 'callback'));
            HookRegistry::register('CopyeditorAction::​completeCopyedi', array(&$this, 'callback'));
            HookRegistry::register('CopyeditorAction::​completeFinalCopyedit', array(&$this, 'callback'));
            HookRegistry::register('CopyeditorAction::​postLayoutComment', array(&$this, 'callback'));
            HookRegistry::register('EditorAction::​assignEditor', array(&$this, 'callback'));
            HookRegistry::register('LayoutEditorAction::​completeLayoutEditing', array(&$this, 'callback'));

            HookRegistry::register('LayoutEditorAction::​postLayoutComment', array(&$this, 'callback'));
            HookRegistry::register('LayoutEditorAction::​postProofreadComment', array(&$this, 'callback'));
            HookRegistry::register('ProofreaderAction::​proofreadEmail', array(&$this, 'callback'));
            HookRegistry::register('ProofreaderAction::​postProofreadComment', array(&$this, 'callback'));
            HookRegistry::register('ProofreaderAction::​postLayoutComment', array(&$this, 'callback'));
       

            $this->sending($category . " " . $path);
            return true;
        }
        return false;
    }

    function getName() {
        return 'JurnalClub';
    }

    function getDisplayName() {
        return 'Jurnal Club';
    }

    function getDescription() {
        return 'Jurnal Club is Notification for OJS Multi chat platform';
    }

    /*
     * &$mail, &$recipients, &$subject, &$mailBody, &$headers, &$additionalParameters
     */

    function callback($hookName, $args) {

        //error_log("calllllllllllllllllback : " + print_r($args, true));
        $this->sending("hookname : " . $hookName);
        $this->sending("hookname : " .$hookName ." content : " . json_encode($args));

        return false;
    }

    public function sending($text) {

        error_log("calllllllllllllllllback : " + print_r($args, true));

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

}

?>