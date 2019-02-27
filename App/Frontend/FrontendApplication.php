<?php 

namespace App\Frontend;

use \OCFram\Application;

class FrontendApplication extends Application {
    public function __construct() {
        parent::__construct();
        
        $this->name = 'Frontend';
        $this->applicationPath = __DIR__;
    }
    
    public function run() {
        $controller = $this->getController();
        $controller->execute();
        
        $page = $controller->page();

        $this->httpResponse->setPage($page);
        $this->httpResponse->send($page->getGeneratedPage());
    }
}