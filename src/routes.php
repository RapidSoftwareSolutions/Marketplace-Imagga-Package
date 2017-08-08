<?php
$routes = [
    'metadata',
    'taggingImageByUrl',
    'taggingImageById',
    'uploadImage',
    'getAllCategorizers',
    'categorizationsImageByUrl',
    'categorizationsImageById',
    'croppingImageByUrl',
    'croppingImageById',
    'analyseColorImageById',
    'analyseColorImageByUrl',
    'deleteImage'

];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
