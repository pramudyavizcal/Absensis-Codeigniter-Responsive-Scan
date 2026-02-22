<?php

namespace App\Libraries\Whatsapp\Fonnte;

use App\Libraries\Whatsapp\Whatsapp;
use CodeIgniter\HTTP\CURLRequest;

class Fonnte implements Whatsapp
{
    private string $urlApi = 'https://api.fonnte.com/send';
    private CURLRequest $client;

    public function __construct(public ?string $token)
    {
        $this->client = \Config\Services::curlrequest();
    }

    public function getProvider(): string
    {
        return 'Fonnte';
    }

    public function getToken(): string
    {
        return $this->token ?? env('WHATSAPP_TOKEN');
    }

    /**
     * Send message to Fonnte API
     * @param array|string $messages
     * @return string
     */
    public function sendMessage(array|string $messages): string
    {
        $messages = isset($messages[0]) ? $messages : [$messages];
        $fonnteMessage = new FonnteBulkMessage($messages);
        $jsonMessage = $fonnteMessage->toJson();

        try {
            // Determine SSL verification based on environment
            $verifySsl = env('CI_ENVIRONMENT') === 'production' ? true : false;
            
            $response = $this->client->request('POST', $this->urlApi, [
                'headers' => [
                    'Authorization' => $this->getToken(),
                ],
                'form_params' => [
                    'data' => $jsonMessage,
                ],
                'timeout' => 30,
                'verify' => $verifySsl, // Auto handle berdasarkan environment
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            log_message('info', 'Fonnte HTTP Status: ' . $statusCode);
            log_message('info', 'Fonnte Raw Response: ' . $body);

            $responseStatus = json_decode($body, true);

            // VALIDASI RESPONSE NULL
            if ($responseStatus === null) {
                log_message('error', 'Fonnte JSON decode failed. Raw response: ' . $body);
                return 'Gagal parse response dari Fonnte API';
            }

            // CEK STATUS
            if (!isset($responseStatus['status'])) {
                log_message('error', 'Fonnte response missing status field: ' . json_encode($responseStatus));
                return 'Response format tidak valid dari Fonnte API';
            }

            $resultMessage = $responseStatus['reason'] ?? '';

            if ($responseStatus['status']) {
                $resultMessage = $responseStatus['detail'] ?? 'Sukses';
                log_message('info', 'Fonnte API Success: ' . $resultMessage);
            } else {
                log_message('warning', 'Fonnte API Failed: ' . $resultMessage);
            }

            return $resultMessage;

        } catch (\Exception $e) {
            log_message('error', 'Fonnte Exception: ' . $e->getMessage());
            log_message('error', 'Fonnte Exception Trace: ' . $e->getTraceAsString());
            return 'Error: ' . $e->getMessage();
        }
    }
}
