<?php
namespace Model;
 
use \OCFram\IResult;

use \Entity\Picture;
use \Entity\Album;
use \Entity\User;
 
class PicturesManagerPDO extends PicturesManager
{
  // Lecture

  public function suggestion($keywords) {
    $sql[] = 'SELECT p.entity, p.title AS suggestion
    FROM r_picture p
    WHERE p.title LIKE :keywords OR p.resum LIKE :keywords
    LIMIT 5';
    
    $sql[] = 'SELECT a.entity, a.title AS suggestion
    FROM r_album a
    WHERE a.title LIKE :keywords OR a.resum LIKE :keywords
    LIMIT 5';

    $sql[] = 'SELECT u.entity, u.login AS suggestion
    FROM r_user u
    WHERE u.login LIKE :keywords
    LIMIT 5';

    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    $suggestion = array();
    
    for($i=0; $i < count($sql); $i++) {
      $requete = $this->dao->prepare($sql[$i]);
      $requete->bindParam(':keywords', $keywords);
      $requete->execute();
      
      while ($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
        $key = $row['entity'];
        
        if(!array_key_exists($key, $suggestion)) {
          $suggestion[$key] = array();
        }
        
        array_push($suggestion[$key], $row['suggestion']);
      }

      $requete->closeCursor();
    }

    return $suggestion;
  }

  public function search($keywords) {
    $sql = 'SELECT p.*
    FROM r_picture p
    LEFT JOIN r_album a ON p.id_album = a.id
    LEFT JOIN r_user u ON p.id_possessor = u.id
    WHERE MATCH(p.title, p.resum) AGAINST (? IN BOOLEAN MODE) 
    OR MATCH(a.title, a.resum) AGAINST (? IN BOOLEAN MODE)
    OR MATCH(u.login) AGAINST (? IN BOOLEAN MODE)';

    $requete = $this->dao->prepare($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Picture');
    
    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = '"'.$keywords.'*"';
   
    $requete->bindParam(1, $keywords);
    $requete->bindParam(2, $keywords);
    $requete->bindParam(3, $keywords);

    $requete->execute();

    $listePictures = $requete->fetchAll();
    
    foreach ($listePictures as $picture) {
      $picture->setCreationDate(new \DateTime($picture->creationDate()));
    }
 
    $requete->closeCursor();
    
    return new IResult($listePictures);
  }
  
  public function getListUserImages($debut = -1, $limite = -1) {
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
 
    return new IResult($listePictures);
  }

  public function getListAlbumImages($debut = -1, $limite = -1) {
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
 
    return new IResult($listePictures);
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
    $sql = 'SELECT * FROM r_picture';
 
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

    return new IResult($listePictures);
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
    $requete = $this->dao->prepare('INSERT INTO r_picture SET id_album=:album, id_possessor=:possessor, title=:title, resum=:resum, sha=:sha, extension=:ext, creation_date = NOW()');
 
    $requete->bindValue(':album', $picture->album());
    $requete->bindValue(':possessor', $picture->possessor());
    $requete->bindValue(':title', $picture->title());
    $requete->bindValue(':resum', $picture->resum());
    $requete->bindValue(':sha', $picture->shaImg());
    $requete->bindValue(':ext', $picture->extImg());
 
    $requete->execute();
  }
}