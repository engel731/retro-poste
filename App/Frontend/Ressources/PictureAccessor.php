<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class PictureAccessor extends Accessor
{
  public function GET_Picture(HTTPRequest $request) {
    return array('pictures');
  }

  public function GET_ShowPicture(HTTPRequest $request) {
    return array('id_carte_postale' => $request->getData('idPicture'));
  }

  public function GET_UserShowPicture(HTTPRequest $request) {
    return array('id_user' => $request->getData('idUser'));
  }
}