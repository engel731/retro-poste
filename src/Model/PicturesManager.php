<?php
namespace Model;
 
use \OCFram\Manager;

use \Entity\Picture;
use \Entity\Album;
use \Entity\User;
 
abstract class PicturesManager extends Manager
{
  protected $album;
  protected $user;

  /**
   * Méthode retournant les images d'un utilisateur.
   * @param $user int L'identifiant de l'utilisateur possesseur des images à récupérer
   * @return array la liste des images. Chaque entrée est une instance de Picture.
   */
  abstract public function getListUserImages($user);

  /**
   * Méthode retournant les images d'un album.
   * @param $album int L'identifiant d'un album contenant les images à récupérer
   * @return array la liste des images. Chaque entrée est une instance de Picture.
   */
  abstract public function getListAlbumImages($album);

  /**
   * Méthode retournant une image précise.
   * @param $id int L'identifiant de l'image à récupérer
   * @return picture L'image demandée
   */
  abstract public function getUnique($id);

   /**
   * Méthode retournant une liste d'image demandée.
   * @param $debut int La première image à sélectionner
   * @param $limite int Le nombre d'image à sélectionner
   * @return array La liste des images. Chaque entrée est une instance de Picture.
   */
  abstract public function getList($debut = -1, $limite = -1);
 
  /**
   * Méthode permettant de supprimer une image.
   * @param $id int L'identifiant de l'image à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de modifier une image.
   * @param $picture picture l'image à modifier
   * @return void
   */
  abstract protected function modify(Picture $picture);

  /**
   * Méthode permettant d'ajouter une image.
   * @param $picture picture L'image à ajouter
   * @return void
   */
  abstract protected function add(Picture $picture);
 
  /**
   * Méthode permettant d'enregistrer une image.
   * @param $picture picture l'image à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(Picture $picture)
  {
    if ($picture->isValid())
    {
      $picture->isNew() ? $this->add($picture) : $this->modify($picture);
    }
    else
    {
      throw new \RuntimeException('L\'image doit être validée pour être enregistrée');
    }
  }

  // Accesseur
  
  public function setAlbum(Album $album)
  {
    if(empty($album)) 
    {
      throw new \InvalidArgumentException('L\'album demandé est invalide');
    }

    $this->album = $album;
  }

  public function setUser(User $user)
  {
    if(empty($user)) 
    {
      throw new \InvalidArgumentException('L\'utilisateur demandé est invalide');
    }

    $this->user = $user;
  }

  public function album() { return $this->album; }
  public function user() { return $this->user; }
}