<?php 

namespace App\Frontend;

use \OCFram\APIFram\Api;

class FrontendApi extends Api {
    public function __construct() {
        parent::__construct();
        
        $this->name = 'Frontend';
        $this->applicationPath = __DIR__;
    }

    public function run() {
        $this->httpResponse->addHeader('Content-Type: application/json');
        
        $controller = $this->getController();
        $data = $controller->execute();

        $this->httpResponse->send(json_encode($data));
    }
}