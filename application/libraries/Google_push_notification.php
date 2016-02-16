<?php

class Google_push_notification {

    private $push_url = 'https://android.googleapis.com/gcm/send';
    private $headers = array('Content-Type: application/json');

    public function __construct($authorization_key) {
        $this->headers[] = 'Authorization: key=' . $authorization_key;
    }

    public function send($registatoin_ids, $data) {

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $data,
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->push_url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}