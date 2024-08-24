
<?php

//Install Package 
//In Line 49 replace [project-id] with your project ID
//In Line 33, 35 and 36 change as per your requirements


//composer require google/apiclient
use Google\Client as GoogleClient;

// Replace with your FCM server key
        $credentialsFilePath = "path to your firebase.json";
  
        $client = new GoogleClient();

        $client->setAuthConfig($credentialsFilePath);

        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        $access_token = $token['access_token'];

        // Set up the HTTP headers
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "topic" => "shyam",
                "notification" => [
                    "title" => "New Notification",
                    "body" => "Notification Content",

                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "default"
                        ]
                    ]
                ]
            ]
        ];
        $payload = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/[project-id]/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);


        ?>