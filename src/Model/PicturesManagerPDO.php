<?php
namespace Model;
 
use \Entity\Picture;
use \Entity\Album;
use \Entity\User;
 
class PicturesManagerPDO extends PicturesManager
{
  // Lecture
  
  public function getListUserImages($user) {
    $sql = 'SELECT * FROM r_picture WHERE id_possessor = '.$this->user->id();
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Picture');
 
    $listePictures = $requete->fetchAll();
 
    foreach ($listePictures as $picture)
    {
        $picture->setCreationDate(new \DateTime($picture->creationDate()));
    }
 
    $requete->closeCursor();
 
    return $listePictures;
  }

  public function getListAlbumImages($album) {
    $sql = 'SELECT * FROM r_picture WHERE id_album = '.$this->album->id();
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Picture');
 
    $listePictures = $requete->fetchAll();
 
    foreach ($listePictures as $picture)
    {
        $picture->setCreationDate(new \DateTime($picture->creationDate()));
    }
 
    $requete->closeCursor();
 
    return $listePictures;
  }
 
  public function getUnique($id) {
    $requete = $this->dao->prepare('SELECT * FROM r_picture WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Picture');

    if ($picture = $requete->fetch())
    {
        $picture->setCreationDate(new \DateTime($picture->creationDate()));
        return $picture;
    }

    return null;
  }

  public function getList($debut = -1, $limite = -1) {
    $sql = 'SELECT * FROM r_picture WHERE';
 
    if ($debut != -1 || $limite != -1)
    {
        $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Picture');

    $listePictures = $requete->fetchAll();

    foreach ($listePictures as $picture)
    {
        $picture->setCreationDate(new \DateTime($picture->creationDate()));
    }

    $requete->closeCursor();

    return $listePictures;
  }

  // Ecriture
 
  public function delete($id) {
    $this->dao->exec('DELETE FROM r_picture WHERE id = '.(int) $id);
  }

  protected function modify(Picture $picture) {
    $requete = $this->dao->prepare('UPDATE r_picture SET id_album=:album, id_possessor=:possessor, title=:title, resum=:resum, sha=:sha, extension:ext WHERE id = :id');
 
    $requete->bindValue(':album', $picture->album());
    $requete->bindValue(':possessor', $picture->possessor());
    $requete->bindValue(':title', $picture->title());
    $requete->bindValue(':resum', $picture->resum());
    $requete->bindValue(':sha', $picture->shaImg());
    $requete->bindValue(':ext', $picture->extImg());
    $requete->bindValue(':id', $user->id(), \PDO::PARAM_INT);

    $requete->execute();
  }

  protected function add(Picture $picture) {
    $requete = $this->dao->prepare('INSERT INTO r_picture SET id_album=:album, id_possessor=:possessor, title=:title, resum=:resum, sha=:sha, extension=:ext, creation-date = NOW()');
 
    $requete->bindValue(':album', $picture->album());
    $requete->bindValue(':possessor', $picture->possessor());
    $requete->bindValue(':title', $picture->title());
    $requete->bindValue(':resum', $picture->resum());
    $requete->bindValue(':sha', $picture->shaImg());
    $requete->bindValue(':ext', $picture->extImg());
 
    $requete->execute();
  }
}