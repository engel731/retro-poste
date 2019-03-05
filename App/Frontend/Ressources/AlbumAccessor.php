<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class AlbumAccessor extends Accessor
{
  public function GET_Album(HTTPRequest $request) {
    $manager = $this->managers->getManagerOf('Albums');
    $data = $manager->getList();
    
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No users found.");
    }
    
    return $data->list_object_to_array();
  }

  public function GET_ShowAlbum(HTTPRequest $request) {
    $manager = $this->managers->getManagerOf('Albums');
    $data = $manager->getUnique($request->getData('idAlbum'));
    
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No user found.");
    }
    
    return $data->object_to_array();
  }

  public function GET_UserShowAlbum(HTTPRequest $request) {
    $managers = array(
      'Albums' => $this->managers->getManagerOf('Albums'),
      'Users' => $this->managers->getManagerOf('Users')
    );
    
    $user = $managers['Users']->getUnique($request->getData('idUser'));
    
    if(empty($user)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No user found.");
    }
    
    $managers['Albums']->setUser($user);
    $data = $managers['Albums']->getListUserAlbum();

    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No picture found.");
    }
    
    return $data->list_object_to_array();
  }
}