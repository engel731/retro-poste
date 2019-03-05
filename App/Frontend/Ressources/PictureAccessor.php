<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class PictureAccessor extends Accessor
{
  public function GET_Picture(HTTPRequest $request) {
    $manager = $this->managers->getManagerOf('Pictures');
    $data = $manager->getList();
    
    // Si aucune carte postale
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No pictures found.");
    }

    return $data->list_object_to_array();
  }

  public function GET_ShowPicture(HTTPRequest $request) {
    $manager = $this->managers->getManagerOf('Pictures');
    $data = $manager->getUnique($request->getData('idPicture'));
    
    // Si aucune carte postale
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No picture found.");
    }
    
    return $data->object_to_array();
  }

  public function GET_UserShowPicture(HTTPRequest $request) {
    $managers = array(
      'Pictures' => $this->managers->getManagerOf('Pictures'),
      'Users' => $this->managers->getManagerOf('Users')
    );
    
    $user = $managers['Users']->getUnique($request->getData('idUser'));
    
    // Si auncun utilisateur
    if(empty($user)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No user found.");
    }
    
    $managers['Pictures']->setUser($user);
    $data = $managers['Pictures']->getListUserImages();

    // Si aucune carte postale pour cet utilisateur
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No picture found.");
    }
    
    return $data->list_object_to_array();
  }

  public function GET_AlbumShowPicture(HTTPRequest $request) {
    $managers = array(
      'Pictures' => $this->managers->getManagerOf('Pictures'),
      'Albums' => $this->managers->getManagerOf('Albums')
    );
    
    $album = $managers['Albums']->getUnique($request->getData('idAlbum'));
    
    // Si auncun album
    if(empty($album)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No album found.");
    }
    
    $managers['Pictures']->setAlbum($album);
    $data = $managers['Pictures']->getListAlbumImages();

    // Si aucune carte postale pour cet utilisateur
    if(empty($data)) {
      $this->app->httpResponse()->addHeader('HTTP/1.0 404 Not Found');
      return array("message" => "No picture found.");
    }
    
    return $data->list_object_to_array();
  }
}