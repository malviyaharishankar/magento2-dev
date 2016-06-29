<?php
/**
 * Created by PhpStorm.
 * User: Harishankar.Malviya
 * Date: 6/28/2016
 * Time: 5:51 PM
 */
date_default_timezone_set(date_default_timezone_get());
ini_set('display_errors', 1);
error_reporting(E_ALL);
$request = new SoapClient(
    'http://magento2-dev.local/index.php/soap/default?wsdl&services=foggylineSliderSlideRepositoryV1',
    array(
        'soap_version' => SOAP_1_2,
        'stream_context' => stream_context_create(array(
                'http' => array(
                    'header' => 'Authorization: Bearer pk8h93nq9cevaw55bohkjbp0o7kpl4d3')
            )
        )
    )
);
$response = $request->foggylineSliderSlideRepositoryV1GetById(array('slideId' => 1));
var_dump($response);
exit;