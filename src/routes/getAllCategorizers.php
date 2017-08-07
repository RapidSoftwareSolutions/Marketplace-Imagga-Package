<?php

$app->post('/api/Imagga/getAllCategorizers', function ($request, $response) {
    ini_set('display_errors',1);

    $option = array(
        "key" => "key",
        "secret" => "secret"
    );
    $arrayType = array();


    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['key','secret']);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }


    $url = "https://api.imagga.com/v1/categorizers";

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

            $resp =  $client->request('GET', $url ,['auth' => [$userName,$pass] ] );
            if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
                $result['callback'] = 'success';
                $result['contextWrites']['to'] = array('result' => $resp->getBody()->getContents() );

           }

    } catch(\GuzzleHttp\Exception\ClientException $exception) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $exception->getResponse()->getBody()->getContents();
    }





    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);


});
