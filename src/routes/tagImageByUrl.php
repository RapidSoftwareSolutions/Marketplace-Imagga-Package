<?php

    $app->post('/api/Imagga/tagImageByUrl', function ($request, $response) {


        $option = array(
            "key" => "key",
            "secret" => "secret",
            "imageUrl" => "url",
            "language" => "language",
            "showTagInfo" => "verbose",
            "limit" => 'limit'
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


        $url = "https://api.imagga.com/v1/tagging?";
        //adding images in url
        if(!empty($postData['args']['imageUrl']))
        {
            $url .= '&url='.implode('&url=',$postData['args']['imageUrl']);
            unset($postData['args']['imageUrl']);
        }
        //adding language in url
        if(!empty($postData['args']['language']))
        {
            $url .= '&language='.implode('&language=',$postData['args']['language']);
            unset($postData['args']['language']);
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




        //change alias verbose
        if((!empty($queryParam['verbose'])) && $queryParam['verbose'] == 'On')
        {
            $queryParam['verbose'] = 1;
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
                $result['callback'] = 'success';
                $result['contextWrites']['to'] = array('result' => $resp->getBody()->getContents() );

            } else {
                $result['callback'] = 'error';
                $result['contextWrites']['to']['status_code'] = 'API_ERROR';
                $result['contextWrites']['to']['status_msg'] = json_decode($resp->getBody()->getContents());
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




        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);


});
