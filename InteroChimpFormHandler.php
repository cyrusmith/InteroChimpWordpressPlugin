<?php

class InteroChimpFormHandler
{

    public function handle()
    {
        check_ajax_referer(INTEROCHIMP_NONCE, 'security');
        echo "handle!";
    }

    protected function subscribe()
    {
        echo "Hello subscr!";
    }

}