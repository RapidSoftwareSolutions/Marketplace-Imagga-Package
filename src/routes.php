<?php
$routes = [
    'metadata',
    'tagImageByUrl',
    'tagImageById',
    'uploadImage',
    'getAllCategorizers',
    'getImageCategoriesByUrl',
    'getImageCategoriesById',
    'getCropOptionsByUrl',
    'getCropOptionsById',
    'getImageColorExtractionById',
    'getImageColorExtractionByUrl',
    'deleteImage'

];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
