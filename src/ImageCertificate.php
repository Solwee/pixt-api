<?php

namespace Solwee\Pixt;

class ImageCertificate
{

    private string $certificateUrl;
    private string $hash;
    private string $urlSmallRes;
    private array $aiLabels;

    public function __construct(string $certificateUrl, string $hash, string $urlSmallRes, array $aiLabels = [])
    {

        $this->certificateUrl = $certificateUrl;
        $this->hash = $hash;
        $this->urlSmallRes = $urlSmallRes;
        $this->aiLabels = $aiLabels;
    }

    public function getCertificateUrl(): string
    {
        return $this->certificateUrl;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getUrlSmallRes(): string
    {
        return $this->urlSmallRes;
    }

    public function getAiLabels(): array
    {
        return $this->aiLabels;
    }


}