<?php

namespace Mantiq\Actions\Developers;

use Mantiq\Exceptions\ErrorException;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\Strings;

class ExecuteHTTPRequest extends Action
{
    public function getName()
    {
        return __('Execute HTTP Request', 'mantiq');
    }

    public function getDescription()
    {
        return __('Execute an HTTP request.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - Utilities', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'          => 'success',
                    'name'        => __('Operation state', 'mantiq'),
                    'description' => __('Whether the operation succeeded or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'code',
                    'name'        => __('Code', 'mantiq'),
                    'description' => __('The HTTP response code returned by the URL.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'message',
                    'name'        => __('Message', 'mantiq'),
                    'description' => __('The HTTP response message returned by the URL.', 'mantiq'),
                    'type'        => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'body',
                    'name'        => __('Body', 'mantiq'),
                    'description' => __('The HTTP response body returned by the URL.', 'mantiq'),
                    'type'        => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'headers',
                    'name'        => __('Headers', 'mantiq'),
                    'description' => __('The HTTP response headers returned by the URL.', 'mantiq'),
                    'type'        => DataType::map(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'cookies',
                    'name'        => __('Cookies', 'mantiq'),
                    'description' => __('The HTTP response cookies returned by the URL.', 'mantiq'),
                    'type'        => DataType::map(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'json',
                    'name'        => __('Parsed JSON response', 'mantiq'),
                    'description' => __('The HTTP response parsed as JSON.', 'mantiq'),
                    'type'        => DataType::map(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/developers/execute-http-request.php');
    }

    function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $headers = [];
        foreach ($invocation->getArgument('headers', []) as $headerIndex => $header) {
            if (empty($header['key'])) {
                continue;
            }

            $headers[$header['key']] = $invocation->getEvaluatedValue($header['value']);
        }


        $url = trim((string) $invocation->getEvaluatedArgumentWithoutEscaping('url', ''));

        $queryFragments = [];
        foreach ($invocation->getArgument('query', []) as $queryIndex => $query) {
            if (empty($query['key'])) {
                continue;
            }

            $queryFragments[] = build_query([$query['key'] => $invocation->getEvaluatedValue($query['value'])]);
        }

        if (!empty($queryFragments)) {
            $url .= (strpos($url, '?') !== false ? '' : '?').implode('&', $queryFragments);
        }

        $payload     = null;
        $payloadType = $invocation->getArgument('payload_type');

        if ($payloadType === 'form') {
            $payload = [];

            foreach ($invocation->getArgument('payload_form', []) as $formItemIndex => $formItem) {
                if (empty($formItem['key'])) {
                    continue;
                }

                $payload[$formItem['key']] = $invocation->getEvaluatedValue($formItem['value']);
            }
        }

        if ($payloadType === 'json') {
            $payload = $invocation->getEvaluatedArgument('payload_json', '{}');

            if (Strings::isJson($payload)) {
                $headers['Content-Type'] = 'application/json';
            }
        }

        if ($payloadType === 'raw') {
            $payload = $invocation->getEvaluatedArgument('payload_raw', '{}');
        }

        $userArguments = array_merge(
            [
                'url'       => $url,
                'method'    => $invocation->getArgument('method', 'get'),
                'blocking'  => $invocation->getArgument('blocking', true),
                'sslverify' => $invocation->getArgument('sslverify', true),
                'json'      => $invocation->getArgument('json', true),
                'headers'   => $headers,
                'body'      => $payload,
            ],
            $customArguments ?: []
        );

        $request = wp_remote_request($userArguments['url'], $userArguments);

        if ($request instanceof \WP_Error) {
            return [
                'success' => false,
                'error'   => new ErrorException($request->get_error_message()),
            ];
        }

        return [
            'success' => true,
            'code'    => $request['response']['code'],
            'message' => $request['response']['message'],
            'body'    => $request['body'],
            'headers' => $request['headers'],
            'cookies' => $request['cookies'],
            'json'    => $userArguments['json'] ? json_decode($request['body'], true) : null,
        ];
    }
}
