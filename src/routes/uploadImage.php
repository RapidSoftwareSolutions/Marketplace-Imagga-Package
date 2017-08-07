<?php

$app->post('/api/Imagga/uploadImage', function ($request, $response) {
    ini_set('display_errors',1);

    $option = array(
        "key" => "key",
        "secret" => "secret",
        "imageUrl" => "image"
    );
    $arrayType = array();


    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['key','secret','imagePath']);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }


    $url = "https://api.imagga.com/v1/content";
    //Change alias and formatted array
    foreach($option as $alias => $value)
    {

        if(!empty($postData['args'][$alias]))
        {

            if(isset($arrayType[$alias]))
            {
                $postData['args'][$alias] = implode($arrayType[$alias],$postData['args'][$alias]);
            }

            $queryParam[$value] = $postData['args'][$alias];
        }
    }



    $userName = $queryParam['key'];
    unset($queryParam['key']);
    $pass = $queryParam['secret'];
    unset($queryParam['secret']);
    $client = $this->httpClient;



    try {

    $api_credentials = array(
        'key' => $userName,
        'secret' => $pass
    );

    $file_path = $queryParam['image'];


        $resp = $client->post('http://api.imagga.com/v1/content', ['auth' => [$userName,$pass],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen( $file_path, 'r')
                ]
            ]
        ]);
        $responseBody = $resp->getBody();
        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
            if(empty($result['contextWrites']['to'])) {
                $result['contextWrites']['to']['status_msg'] = "Api return no results";
            }
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);
        }



     } catch(\GuzzleHttp\Exception\ClientException $exception) {
         $result['callback'] = 'error';
         $result['contextWrites']['to']['status_code'] = 'API_ERROR';
         $result['contextWrites']['to']['status_msg'] = $exception->getResponse()->getBody()->getContents();
     }





      return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);


});