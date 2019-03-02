<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class PictureAccessor extends Accessor
{
  public function GET_Picture(HTTPRequest $request) {
    return array();
  }

  public function GET_ShowPicture(HTTPRequest $request) {
    return array('id_carte_postale' => $request->getData('id'));
  }

  public function GET_UserShowPicture(HTTPRequest $request) {
    return array();
  }
}