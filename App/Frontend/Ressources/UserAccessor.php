<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class UserAccessor extends Accessor
{
  public function GET_User(HTTPRequest $request) {
    $manager = $this->managers->getManagerOf('Users');
    $dataResult = $manager->getList();
    $data = $dataResult->list_object_to_array();
    
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No users found.");
    }
    
    return $data;
  }

  public function GET_ShowUser(HTTPRequest $request) {
    $manager = $this->managers->getManagerOf('Users');
    $data = $manager->getUnique($request->getData('idUser'));
    
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No user found.");
    }
    
    return $data->object_to_array();
  }
}