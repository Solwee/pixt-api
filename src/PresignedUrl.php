<?php

namespace Solwee\Pixt;

class PresignedUrl
{
    private string $url;
    private string $imageID;
    public function __construct(string $url, string $imageID)
    {
        $this->url = $url;
        $this->imageID = $imageID;
    }
    public function getImageID(): string
    {
        return $this->imageID;
    }
    public function getUrl(): string
    {
        return $this->url;
    }

}