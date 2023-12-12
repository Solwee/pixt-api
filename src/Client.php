<?php
namespace Solwee\Pixt;
use Solwee\Pixt\Exceptions\DataErrorException;

class Client
{
    private \GuzzleHttp\Client $client;
    private string $serverUrl;
    private string $bearerToken;

    public function __construct(
        \GuzzleHttp\Client $client,
        string $serverUrl,
        string $bearerToken
    )
    {
        $this->client = $client;
        $this->serverUrl = $serverUrl;
        $this->bearerToken = $bearerToken;
    }

    public function getPresignedURL(string $imageFileName): PresignedUrl
    {

        $response = $this->client->request('POST', sprintf('%s/images/presigned-url', $this->serverUrl), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->bearerToken)
            ], 'json' => [
                'title' => $imageFileName,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);


        if(isset($data['data']['url'])) {
            $url = $data['data']['url'];
        }
        else {
            throw new DataErrorException('No URL found');
        }

        if(isset($data['data']['imageId'])) {
            $imageID = $data['data']['imageId'];
        }
        else {
            throw new DataErrorException('No image ID found');
        }

        return new PresignedUrl($url, $imageID);

    }

    public function putToPresignedURL(PresignedUrl $presignedUrl, string $data): int
    {

        $response = $this->client->request('PUT', $presignedUrl->getUrl(), [
            'headers' => [
                'Content-Type' => 'text/plain',
            ], 'body' => $data
        ]);

        return $response->getStatusCode();

    }

    public function getImageCertificate(string $imageId, bool $keywords = false): ImageCertificate
    {
        $keywordsStr = $keywords ? 'true' : 'false';

        $response = $this->client->request('GET', sprintf('%s/images/certificate/%s?keywords=%s', $this->serverUrl, $imageId, $keywordsStr), [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => sprintf('Bearer %s', $this->bearerToken)
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $aiLabels = [];
            if(isset($data['data']['rekognition']['iaLabels'])) {
                foreach ($data['data']['rekognition']['iaLabels'] as $label) {
                    $aiLabels[] = $label['label'];
                }
            }

            if(!isset($data['data']['certificateUrl'])) {
                throw new DataErrorException('No certificate URL found');
            }

            if(!isset($data['data']['hash'])) {
                throw new DataErrorException('No hash found');
            }

            if(!isset($data['data']['urlSmallRes'])) {
                throw new DataErrorException('No small res URL found');
            }


            return new ImageCertificate($data['data']['certificateUrl'], $data['data']['hash'], $data['data']['urlSmallRes'], $aiLabels);


    }


}