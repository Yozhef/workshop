<?php

namespace App\Infrastructure\Service\Mailer\Client;

use App\Infrastructure\Service\Mailer\Dto\SendEmailEnqueueRequest;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

readonly class EmailClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer,
        private string $baseUri
    ) {
    }

    public function sendEmailEnqueueRequest(SendEmailEnqueueRequest $sendEmailEnqueueRequest): void
    {
        try {
            $response = $this->httpClient->request(
                Request::METHOD_POST,
                $this->baseUri . '/api/v1/internal/email/enqueue',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'language' => $sendEmailEnqueueRequest->getLanguage(),
                    ],
                    'body' => $this->serializer->serialize($sendEmailEnqueueRequest, 'json'),
                ],
            );
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }

        if ($response->getStatusCode() !== Response::HTTP_NO_CONTENT) {
            throw new Exception('Error code response ' . $response->getStatusCode());
        }
    }
}
