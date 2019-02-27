<?php
namespace App\Frontend\Modules\Viewer;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ViewerController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Index - Retro-Poste');
  }
}