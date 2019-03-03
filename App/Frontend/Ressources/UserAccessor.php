<?php
namespace App\Frontend\Ressources;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class UserAccessor extends Accessor
{
  public function GET_User(HTTPRequest $request) {
    return array('user');
  }

  public function GET_ShowUser(HTTPRequest $request) {
    return array( 'id_user' => $request->getData('idUser'));
  }
}