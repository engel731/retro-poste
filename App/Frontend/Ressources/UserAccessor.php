<?php
namespace App\Frontend\Services;

use \OCFram\APIFram\Accessor;
use \OCFram\HTTPRequest;

class UserAccessor extends Accessor
{
  public function GET_User(HTTPRequest $request) {
    return array();
  }

  public function GET_UserShow(HTTPRequest $request) {
    return array( 'id_user' => $request->getData('id'));
  }

  public function GET_UserPicture(HTTPRequest $request) {
    return array();
  }
}