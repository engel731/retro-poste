<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class AlbumAccessor extends Accessor
{
  public function GET_Album(HTTPRequest $request) {
    return array('test');
  }

  public function GET_ShowAlbum(HTTPRequest $request) {
    return array( 'id_album' => $request->getData('idAlbum'));
  }

  public function GET_UserShowAlbum(HTTPRequest $request) {
    return array('id_user' => $request->getData('idUser'));
  }
}