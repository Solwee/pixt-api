# pixt-api

## Overview

The objective of the project is to develop a straightforward PHP client for the PixT API. 
PixT technology offers an easy method for image creators to certify their images, 
thereby enhancing their trustworthiness.


## Installation

To install latest version of `solwee/pixt-api` use [Composer](https://getcomposer.org).


## Documentation
`ClientInterface` is designed to handle operations related to image processing and retrieval. It includes methods for generating presigned URLs for image uploads, uploading data to these URLs, and retrieving image certificates.

### Methods

#### `getPresignedURL`

- **Description**: Generates a presigned URL for uploading an image.
- **Parameters**:
    - `$imageFileName` (`string`): The name of the image file for which the presigned URL will be generated.
- **Returns**: `PresignedUrl` - An object representing the presigned URL.

#### `putToPresignedURL`

- **Description**: Uploads data to a given presigned URL.
- **Parameters**:
    - `$presignedUrl` (`PresignedUrl`): The presigned URL to which the data will be uploaded.
    - `$data` (`string`): The data to be uploaded, typically the image file's content.
- **Returns**: `int` - The HTTP status code indicating the result of the upload operation.

#### `getImageCertificate`

- **Description**: Retrieves a certificate for a specified image.
- **Parameters**:
    - `$imageId` (`string`): The unique identifier of the image.
    - `$keywords` (`bool`, optional): A flag to include keywords in the certificate. Defaults to `false`.
- **Returns**: `ImageCertificate` - An object containing the image's certificate details.

### Usage Example

```php
$client = new Solwee\Pixt\Client(
  new \GuzzleHttp\Client(),
    "https://partner.pixt.42cloud.io",
    "<super secret token>",
);

// Get a presigned URL for an image upload
$presignedUrl = $client->getPresignedURL("example.jpg");

// Upload image data to the presigned URL
$imageData = file_get_contents("example.jpg");
$status = $client->putToPresignedURL($presignedUrl, $imageData);

// Retrieve the certificate for the image
$imageCertificate = $client->getImageCertificate("image123", true);
