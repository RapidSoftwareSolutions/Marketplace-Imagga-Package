<?php

$app->post('/api/Imagga/analyseColorImageById', function ($request, $response) {
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
    $validateRes = $checkRequest->validate($request, ['key','secret','contentId']);
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



        $resp =  $client->request('GET', $url ,['auth' => [$userName,$pass] ] );



        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {

            $dataBody = $resp->getBody()->getContents();
            $check = json_decode($dataBody);
            if(!empty($check->unsuccessful))
            {
                $result['callback'] = 'error';
                $result['contextWrites']['to']['status_code'] = 'API_ERROR';
                $result['contextWrites']['to']['status_msg'] = $dataBody;
            } else {
                $result['callback'] = 'success';
                $result['contextWrites']['to'] = array('result' =>$dataBody );
            }



        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = $resp->getBody()->getContents();
        }
    } catch (\GuzzleHttp\Exception\ClientException $exception) {
        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;
    } catch (GuzzleHttp\Exception\ServerException $exception) {
        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;
    } catch (GuzzleHttp\Exception\ConnectException $exception) {
        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';
    }
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);



});
