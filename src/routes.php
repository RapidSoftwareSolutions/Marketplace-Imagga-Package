<?php
$routes = [
    'metadata',
    'taggingForImageByUrl',
    'taggingForImageById',
    'uploadImage',
    'getAllCategorizers',
    'categorizationsForImageByUrl',
    'categorizationsForImageById',
    'croppingsForImageByUrl',
    'croppingsForImageById',
    'analyseColorForImageById',
    'analyseColorForImageByUrl',
    'deleteImage'

];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
