<?php

namespace Mantiq\Actions;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class SendEmail extends Action
{
    public function getName()
    {
        return __('Send email', 'mantiq');
    }

    public function getDescription()
    {
        return __('Send an email.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Emails', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'          => 'sent',
                    'name'        => __('Email sent', 'mantiq'),
                    'description' => __('Whether the email has been sent or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/send-email.php');
    }

    function invoke(ActionInvocationContext $invocation)
    {
        $from    = $invocation->getEvaluatedArgument('from');
        $to      = $invocation->getEvaluatedArgument('to');
        $cc      = $invocation->getEvaluatedArgument('cc');
        $bcc     = $invocation->getEvaluatedArgument('bcc');
        $replyTo = $invocation->getEvaluatedArgument('replyTo');
        $subject = $invocation->getEvaluatedArgument('subject');
        $body    = $invocation->getEvaluatedArgument('body');
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        if (!empty($from)) {
            $headers[] = "From: $from";
        }

        if (!empty($cc)) {
            $headers[] = "Cc: $cc";
        }

        if (!empty($bcc)) {
            $headers[] = "Bcc: $bcc";
        }

        if (!empty($replyTo)) {
            $headers[] = "Reply-To: $replyTo";
        }

        $userHeaders = $invocation->getArgument('headers', []);
        foreach ($userHeaders as $userHeaderIndex => $userHeader) {
            if (!empty($userHeader['name'])) {
                $headers[] = sprintf("%s: %s", $userHeader['name'], $userHeader['content']);
            }
        }

        $sent = wp_mail($to, $subject, $body, $headers);

        return [
            'sent'    => $sent,
            'to'      => $to,
            'subject' => $subject,
            'body'    => $body,
            'headers' => $headers,
        ];
    }
}
