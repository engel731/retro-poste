<?php
namespace Model;
 
use \OCFram\Manager;

use \Entity\Album;
use \Entity\User;
 
abstract class AlbumsManager extends Manager
{
  protected $user;

  /**
   * Méthode retournant une liste d'album demandée d'un utilisateur.
   * @param $debut int Le premier album à sélectionner
   * @param $limite int Le nombre d'album à sélectionner
   * @return array La liste des albums. Chaque entrée est une instance de Album.
   */
  abstract public function getListUserAlbums($debut = -1, $limite = -1);

  /**
   * Méthode retournant un album précise.
   * @param $id int L'identifiant de l'album à récupérer
   * @return album L'album demandé
   */
  abstract public function getUnique($id);
 
  /**
   * Méthode permettant de supprimer un album.
   * @param $id int L'identifiant de l'album à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de modifier un album.
   * @param $album Album l'album à modifier
   * @return void
   */
  abstract protected function modify(Album $album);

  /**
   * Méthode permettant d'ajouter un album.
   * @param $album Album L'album à ajouter
   * @return void
   */
  abstract protected function add(Album $album);
 
  /**
   * Méthode permettant d'enregistrer un album.
   * @param $album Album l'album à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(Album $album)
  {
    if ($album->isValid())
    {
      $album->isNew() ? $this->add($album) : $this->modify($album);
    }
    else
    {
      throw new \RuntimeException('L\'album doit être validée pour être enregistrée');
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

  public function album() { return $this->album; }
}