<?php
namespace Solwee\Pixt;
use Solwee\Pixt\Exceptions\DataErrorException;

interface ClientInterface
{
    public function getPresignedURL(string $imageFileName): PresignedUrl;

    public function putToPresignedURL(PresignedUrl $presignedUrl, string $data): int;

    public function getImageCertificate(string $imageId, bool $keywords = false): ImageCertificate;
}