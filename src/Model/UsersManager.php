<?php
namespace Model;
 
use \OCFram\Manager;

use \Entity\User;
 
abstract class UsersManager extends Manager
{
  /**
   * Méthode retournant un utilisateur précise.
   * @param $id int L'identifiant de l'utilisateur à récupérer
   * @return user L'utilisateur demandé
   */
  abstract public function getUnique($id);
  
  /**
   * Méthode retournant une liste d'utilisateur demandé.
   * @param $debut int Le première utilisateur à sélectionner
   * @param $limite int Le nombre d'utilisateur à sélectionner
   * @return array La liste des utilisateur. Chaque entrée est une instance de User.
   */
  abstract public function getList($debut = -1, $limite = -1);
 
  /**
   * Méthode permettant de supprimer un utilisateur.
   * @param $id int L'identifiant de l'utilisateur à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant de modifier un utilisateur.
   * @param $user User l'utilisateur à modifier
   * @return void
   */
  abstract protected function modify(User $user);

  /**
   * Méthode permettant d'ajouter un utilisateur.
   * @param $user User L'utilisateur à ajouter
   * @return void
   */
  abstract protected function add(User $user);
 
  /**
   * Méthode permettant d'enregistrer un utilisateur.
   * @param $user User l'utilisateur à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(User $user)
  {
    if ($user->isValid())
    {
      $user->isNew() ? $this->add($user) : $this->modify($user);
    }
    else
    {
      throw new \RuntimeException('L\'utilisateur doit être validée pour être enregistrée');
    }
  }
}