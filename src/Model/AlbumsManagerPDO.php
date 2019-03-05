<?php
namespace Model;
 
use \Entity\Album;
use \OCFram\IResult;

class AlbumsManagerPDO extends AlbumsManager
{
  // Lecture
  
  public function getListUserAlbums($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM r_album WHERE book = '.$this->user->id();
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Album');
 
    $listeAlbum = $requete->fetchAll();
 
    foreach ($listeAlbum as $album)
    {
      $album->setCreationDate(new \DateTime($album->creationDate()));
      $album->setChangeDate(new \DateTime($album->changeDate()));
    }
 
    $requete->closeCursor();
 
    return new IResult($listeAlbum);
  }

  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM r_album WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
 
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Album');
 
    if ($album = $requete->fetch())
    {
      $album->setCreationDate(new \DateTime($album->creationDate()));
      $album->setChangeDate(new \DateTime($album->changeDate()));
 
      return $album;
    }
 
    return null;
  }

  // Ecriture

  public function delete($id) {
    $this->dao->exec('DELETE FROM r_album WHERE id = '.(int) $id);
  }

  protected function modify(Album $album) {
    $requete = $this->dao->prepare('UPDATE r_album SET title = :title, resum = :resum, change-date = NOW() WHERE id = :id');
 
    $requete->bindValue(':title', $album->title());
    $requete->bindValue(':resum', $album->resum());
    $requete->bindValue(':id', $album->id(), \PDO::PARAM_INT);
 
    $requete->execute();
  }

  protected function add(Album $album) {
    $requete = $this->dao->prepare('INSERT INTO r_album SET title = :title, resum = :resum, creation-date = NOW(), change-date = NOW()');
 
    $requete->bindValue(':title', $album->book());
    $requete->bindValue(':resum', $album->titre());
 
    $requete->execute();
  }
}