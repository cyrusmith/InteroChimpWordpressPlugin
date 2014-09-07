<?php

require_once __DIR__ . '/vendor/mailchimp/mailchimp/src/Mailchimp.php';
require_once __DIR__ . '/vendor/mailchimp/mailchimp/src/Mailchimp/Lists.php';

class InteroChimpFormHandler
{

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        if (empty($this->apiKey)) {
            throw new Exception("API key not set");
        }

    }

    public function handle()
    {
        check_ajax_referer(INTEROCHIMP_NONCE, 'security');


        $email = $_REQUEST['email'];
        $name = $_REQUEST['name'];
        $listId = $_REQUEST['listId'];

        $error = null;
        if (empty($listId)) {
            echo json_encode(array(
                "status" => "FAIL",
                "errorCode" => 1,
                "error" => "List id is empty"
            ));
            exit;
        }

        if (empty($email)) {
            echo json_encode(array(
                "status" => "FAIL",
                "errorCode" => 1,
                "error" => "Email not set"
            ));
            exit;
        }

        if (!is_email($email)) {
            echo json_encode(array(
                "status" => "FAIL",
                "errorCode" => 2,
                "error" => "Email not valid"
            ));
            exit;
        }

        $mailchimp = new Mailchimp($this->apiKey);
        $listsApi = new Mailchimp_Lists($mailchimp);

        $mergeVars = array("name" => $name);

        $result = $listsApi->subscribe($listId, array(
            "email" => $email
        ), $mergeVars);

        echo json_encode(array(
            "status" => "OK",
            "response" => $result
        ));

        exit;

    }

    protected function subscribe()
    {

        $listId = "408281"; //FROM request
        $email = ""; //from requset
        /*$maichimp = new Mailchimp($this->apiKey);
        $lists = new Mailchimp_Lists($maichimp);
        $lists->subscribe($listId, $email);*/
    }

}