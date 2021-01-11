<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = '072aeadd8d614583add26a8f0a66fa11';
    private $api_key_secret = 'c07936d4ba9c8496b30bfe1bf6cd9149';

    public function send ($to_email, $to_name, $subject, $content)
    {

        $mj= new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
    
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "halit.cinici@live.fr",
                    'Name' => "La boutique française"
                ],
                'To' => [
                    [
                        'Email' => $to_email,
                        'Name' => $to_name
                    ]
                ],
                'TemplateID' => 2199735,
                'TemplateLanguage' => true,
                'Subject' => $subject,
                'Variables' => [
                    'content' => $content
                    
                ]
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();
        }
}