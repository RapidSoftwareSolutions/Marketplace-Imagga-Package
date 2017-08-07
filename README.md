[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/Imagga/functions?utm_source=RapidAPIGitHub_YandexFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)
# Imagga Package
The Imagga API is a set of image understanding and analysis technologies available as a web service that allows you to automate the process of analyzing, organizing and searching through large collections of unstructured images.
* Domain: [imagga.com](https://imagga.com)
* Credentials: key, secret

## How to get credentials: 
1. Register on [imagga.com](https://imagga.com)
2. After creation your account you will see api Secret and api Key 
 
## Imagga.taggingForImageById
By sending image content id to the getTaggingForImage endpoint you can get a list of many automatically suggested textual tags.

| Field             | Type      | Description
|-------------------|-----------|----------
| imageUrl          | List      | Image URL to perform auto-tagging on. You can provide up to 5 urls for processing by sending multiple url parameters.
| contentId         | List      | You can also directly send image files for auto-tagging by uploading them to our uploadImage endpoint and then providing the received content identifiers via this parameter.You can provide up to 5 id.
| showTagInformation| Select    | Whether to return some additional information about each of the tags or not.
| language          | List      | All list [here](https://docs.imagga.com/#multi-language-support).You can apply this parameter multiple times.
| limit             | Number    | Limits the number of tags in the result to the number you set.
| key               | credential| API key.
| secret            | credential| API secret.

## Imagga.taggingForImageByUrl
By sending image url to the getTaggingForImage endpoint you can get a list of many automatically suggested textual tags.

| Field             | Type      | Description
|-------------------|-----------|----------
| imageUrl          | List      | Image URL to perform auto-tagging on. You can provide up to 5 urls for processing by sending multiple url parameters.
| contentId         | List      | You can also directly send image files for auto-tagging by uploading them to our uploadImage endpoint and then providing the received content identifiers via this parameter.You can provide up to 5 id.
| showTagInformation| Select    | Whether to return some additional information about each of the tags or not.
| language          | list      | All list [here](https://docs.imagga.com/#multi-language-support).You can apply this parameter multiple times.
| limit             | Number    | Limits the number of tags in the result to the number you set.
| key               | credential| API key.
| secret            | credential| API secret.

## Imagga.getAllCategorizers
Get a list of all available categorizers for you.

| Field | Type      | Description
|-------|-----------|----------
| key   | credential| API key.
| secret| credential| API secret.

## Imagga.deleteImage
Delete an uploaded file.

| Field    | Type      | Description
|----------|-----------|----------
| key      | credential| API key.
| secret   | credential| API secret.
| contentId| String    | Image content id. Image content id.Obtained with uploadImage endpoits.

## Imagga.uploadeImage
Using the uploadeImage endpoint you can upload a file (image or video) for processing by one of the other Imagga API endpoint.

| Field   | Type      | Description
|---------|-----------|----------
| key     | credential| API key.
| secret  | credential| API secret.
| imageUrl| File      | Uploaded file.

## Imagga.categorizationsForImageByUrl
By sending image url and categorizerId from getAllCategoriez endpoint to the categorizationsForImage endpoint you can get a list of many categorizers.

| Field        | Type      | Description
|--------------|-----------|----------
| key          | credential| API key.
| secret       | credential| API secret.
| categorizerId| String    | The categorizer id.
| imageUrl     | List      | URL of an image to submit for categorization. You can provide up to 10 urls for processing by sending multiple url parameters.
| contentId    | List      | You can also directly send image files for categorization by uploading the images to our uploadImage endpoint.
| language     | List      | All list [here](https://docs.imagga.com/#multi-language-support).You can apply this parameter multiple times.

## Imagga.categorizationsForImageById
By sending image url and categorizerId from getAllCategoriez endpoint to the categorizationsForImage endpoint you can get a list of many categorizers.

| Field        | Type      | Description
|--------------|-----------|----------
| key          | credential| API key.
| secret       | credential| API secret.
| categorizerId| String    | The categorizer id.
| imageUrl     | List      | URL of an image to submit for categorization. You can provide up to 10 urls for processing by sending multiple url parameters.
| contentId    | List      | You can also directly send image files for categorization by uploading the images to our uploadImage endpoint.
| language     | List      | All list [here](https://docs.imagga.com/#multi-language-support).You can apply this parameter multiple times.

## Imagga.croppingsForImageByUrl
The technology behind this endpoint analyzes the pixel content of each given image url in order to find the most “visually important” areas in the image.

| Field         | Type      | Description
|---------------|-----------|----------
| key           | credential| API key.
| secret        | String    | API secret.
| imageUrl      | List      | A URL of the image to send for smart-cropping analysis. You can provide as many url parameters as you like in order to send multiple images for smart-cropping analysis.
| contentId     | List      | You can also directly send image files for smart-cropping analysis by uploading them to our /content endpoint and then providing the received content identifier via this parameter.
| resolutionPair| List      | Resolution pair in the form (width)x(height) where ‘x’ is just the small letter x. You can provide several resolutions just by providing several resolution parameters as with the urls.
| scaling       | Select    | Whether the cropping coordinates should exactly match the requested resolutions or just preserve their aspect ratios and let you resize the cropped image later.

## Imagga.croppingsForImageById
The technology behind this endpoint analyzes the pixel content of each given image content id in order to find the most “visually important” areas in the image.

| Field         | Type      | Description
|---------------|-----------|----------
| key           | credential| API key.
| secret        | String    | API secret.
| imageUrl      | List      | A URL of the image to send for smart-cropping analysis. You can provide as many url parameters as you like in order to send multiple images for smart-cropping analysis.
| contentId     | List      | You can also directly send image files for smart-cropping analysis by uploading them to our /content endpoint and then providing the received content identifier via this parameter.
| resolutionPair| List      | Resolution pair in the form (width)x(height) where ‘x’ is just the small letter x. You can provide several resolutions just by providing several resolution parameters as with the urls.
| scaling       | Select    | Whether the cropping coordinates should exactly match the requested resolutions or just preserve their aspect ratios and let you resize the cropped image later.

## Imagga.analyseColorForImageByUrl
Analyse and extract the predominant colors from one or several url images.

| Field               | Type      | Description
|---------------------|-----------|----------
| key                 | credential| API key.
| secret              | String    | API secret.
| imageUrl            | List      | Image URL to perform color extraction on. You can provide as many url parameters as you like in order to send multiple images for color extraction.
| contentId           | List      | You can also send actual image files for color extraction. This is achieved by uploading the images to our uploadImage endpoint.You can provide up to 10 ids.
| extractOverallColors| Select    | Specify whether the overall image colors should be extracted.
| extractObjectColors | Select    | pecify if the service should try to extract object and non-object (a.k.a. foreground and background) colors separately.

## Imagga.analyseColorForImageById
Analyse and extract the predominant colors from one or several images content id.

| Field               | Type      | Description
|---------------------|-----------|----------
| key                 | credential| API key.
| secret              | String    | API secret.
| imageUrl            | List      | Image URL to perform color extraction on. You can provide as many url parameters as you like in order to send multiple images for color extraction.
| contentId           | List      | You can also send actual image files for color extraction. This is achieved by uploading the images to our uploadImage endpoint.You can provide up to 10 ids.
| extractOverallColors| Select    | Specify whether the overall image colors should be extracted.
| extractObjectColors | Select    | pecify if the service should try to extract object and non-object (a.k.a. foreground and background) colors separately.

