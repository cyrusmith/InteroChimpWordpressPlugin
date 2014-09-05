<?php

require_once __DIR__.'/vendor/mailchimp/mailchimp/src/Mailchimp.php';
require_once __DIR__.'/vendor/mailchimp/mailchimp/src/Mailchimp/Lists.php';

class InteroChimpFormHandler
{

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function handle()
    {
        check_ajax_referer(INTEROCHIMP_NONCE, 'security');
        var_dump($_REQUEST);
        echo "handle!";
    }

    protected function subscribe()
    {

        $listId = "408281";//FROM request
        $email = "";//from requset
        /*$maichimp = new Mailchimp($this->apiKey);
        $lists = new Mailchimp_Lists($maichimp);
        $lists->subscribe($listId, $email);*/
    }

}