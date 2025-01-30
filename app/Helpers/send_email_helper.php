<?php

use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

function send_email_mailtrap(
    $to,
    $subject,
    $body_text,
    $attachment_os_fullpath = ''
)
{
    $apiKey = getenv('MAILTRAP_API_KEY');
        
    $mailtrap = MailtrapClient::initSendingEmails(
            apiKey: $apiKey,
            inboxId: getenv('MAILTRAP_INBOX_ID'),
            isSandbox: true,
    );

    $email = (new MailtrapEmail())
            ->from(new Address('noreply@test.dana.id', 'Mailtrap Test'))
            ->to(new Address($to))
            ->subject($subject)
            ->text($body_text);

    if($attachment_os_fullpath)
    {
        $email->attachFromPath($attachment_os_fullpath);
    }
        
    $response = $mailtrap->send($email);

    $response_data = ResponseHelper::toArray($response);

    return [
        'success' => $response_data['success'],
        'message_ids' => $response_data['message_ids'],
    ];

}