<?php

use PHPUnit\Framework\TestCase;
use Solwee\Pixt\Client;

class ClientTest extends TestCase
{
    private string $serverUrl = "https://partner.pixt.42cloud.io";
    private static string $bearerToken;

    public static function setUpBeforeClass(): void
    {
        self::$bearerToken = getenv("PIXT_BEARER_TOKEN");

        if(self::$bearerToken === false || self::$bearerToken === "") {
            throw new Exception("No `PIXT_BEARER_TOKEN` env variable set - it is needed for pixT auth.");
        }
    }

    public function testReal()
    {
        $imgData = file_get_contents("./tests/resources/test1.png");


        $client = new Client(
            new \GuzzleHttp\Client(),
            $this->serverUrl,
            self::$bearerToken
        );

        $presignedUrl = $client->getPresignedURL("test.jpg");

        $this->assertIsObject($presignedUrl, "Should be an object");
        $this->assertIsString($presignedUrl->getImageID(), "Should be a string");
        $this->assertIsString($presignedUrl->getUrl(), "Should be a string");


        $status = $client->putToPresignedURL($presignedUrl, $imgData);

        $this->assertEquals(200, $status, "Should be 200");


        $imageID = $presignedUrl->getImageID();


        $cert = $client->getImageCertificate($imageID, false);

        $this->assertIsObject($cert, "Should be an object");


    }

    public function testGetImageCertificate() {
        $client = new Client(
            new \GuzzleHttp\Client(),
            $this->serverUrl,
            self::$bearerToken
        );

        $cert = $client->getImageCertificate("4b067e61-8362-4986-bfde-1ec5dbd268a6", true);

        $this->assertIsObject($cert, "Should be an object");
    }
}
