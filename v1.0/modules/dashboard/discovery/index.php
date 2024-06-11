<?php
// require_once 'HTTP/Request2.php';
$request = new HTTP_Request2();
$request->setUrl('https://qy9gpw.api.infobip.com/whatsapp/1/message/template');
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setConfig(array(
    'follow_redirects' => TRUE
));
$request->setHeader(array(
    'Authorization' => 'App ********************************-********-****-****-****-********10f3',
    'Content-Type' => 'application/json',
    'Accept' => 'application/json'
));
$request->setBody('{"messages":[{"from":"447860099299","to":"254758330051","messageId":"ac621f47-e88d-4512-ac6d-b93a5faa0a9e","content":{"templateName":"message_test","templateData":{"body":{"placeholders":["Muslih"]}},"language":"en"}}]}');
try {
    $response = $request->send();
    if ($response->getStatus() == 200) {
        echo $response->getBody();
    }
    else {
        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
        $response->getReasonPhrase();
    }
}
catch(HTTP_Request2_Exception $e) {
    echo 'Error: ' . $e->getMessage();
}