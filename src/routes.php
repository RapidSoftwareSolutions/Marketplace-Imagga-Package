<?php
$routes = [
    'metadata',
    'taggingImageByUrl',
    'taggingImageById',
    'uploadeImage',
    'getAllCategorizers',
    'categorizationsImageByUrl',
    'categorizationsImageById',
    'croppingsImageByUrl',
    'croppingsImageById',
    'analyseColorImageById',
    'analyseColorImageByUrl',
    'deleteImage'

];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
