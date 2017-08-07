<?php

$app->post('/api/Imagga/analyseColorForImageByUrl', function ($request, $response) {
    ini_set('display_errors',1);

    $option = array(
        "key" => "key",
        "secret" => "secret",
        "imageUrl" => "url",
        "contentId" => "content",
        "extractOverallColors" => "extract_overall_colors",
        "extractObjectColors" => "extract_object_colors"
    );
    $arrayType = array();


    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['key','secret','imageUrl']);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }

    //form full url
    $url = "https://api.imagga.com/v1/colors?";


    if(!empty($postData['args']['imageUrl']))
    {
        $url .= '&url='.implode('&url=',$postData['args']['imageUrl']);
        unset($postData['args']['imageUrl']);
    }
    //adding content id in url
    if(!empty($postData['args']['contentId']))
    {
        $url .= '&content='.implode('&content=',$postData['args']['contentId']);
        unset($postData['args']['contentId']);
    }
    //change alias extractOverallColors
    if((!empty($postData['args']['extractOverallColors'])) && $postData['args']['extractOverallColors'] == 'On')
    {
        $postData['args']['extractOverallColors'] = 1;
    } else {
        $postData['args']['extractOverallColors'] = 0;
    }

    //change alias extractOverallColors
    if((!empty($postData['args']['extractObjectColors'])) && $postData['args']['extractObjectColors'] == 'On')
    {
        $postData['args']['extractObjectColors'] = 1;
    } else {
        $postData['args']['extractObjectColors'] = 0;
    }


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

    foreach($queryParam as $key => $value)
    {
        $url .= '&'.$key.'='.$value;
    }


    try {

        $api_credentials = array(
            'key' => $userName,
            'secret' => $pass
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_USERPWD, $api_credentials['key'].':'.$api_credentials['secret']);

        $curl = curl_exec($ch);
        curl_close($ch);

        $json_response = $curl;
        $result['callback'] = 'success';
        $result['contextWrites']['to'] = $json_response;;

    } catch(\GuzzleHttp\Exception\ClientException $exception) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $exception->getResponse()->getBody()->getContents();
    }





    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);


});
