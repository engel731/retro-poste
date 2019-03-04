<?php
namespace Entity;
 
use \OCFram\Entity;
 
class Picture extends Entity
{
  protected $id,
            $album,
            $possessor,
            $title,
            $resum,
            $shaImg,
            $extImg,
            $creationDate;

  const INVALID_TITLE = 1;
  const INVALID_RESUM = 2;
  const INVALID_SHA_IMG = 3;
  const INVALID_EXT_IMG = 4;
 
  public function isValid()
  {
    return !(empty($this->shaImg) || empty($this->extImg));
  }
 
  // SETTERS //
  
  public function setAlbum($album)
  {
    $this->album = (int) $album;
  }

  public function setPossessor($possessor)
  {
    $this->possessor = (int) $possessor;
  }
 
  public function setTitle($title)
  {
    if (!is_string($title) || empty($titre))
    {
      $this->erreurs[] = self::INVALID_TITLE;
    }
 
    $this->title = $title;
  }
 
  public function setResum($resum)
  {
    if (!is_string($resum) || empty($resum))
    {
      $this->erreurs[] = self::INVALID_RESUM;
    }
 
    $this->resum = $resum;
  }

  public function setShaImg($sha)
  {
    if (!is_string($sha) || empty($sha))
    {
      $this->erreurs[] = self::INVALID_SHA_IMG;
    }

    $this->$sha = $sha;
  }

  public function setExtImg($ext) {
    if (!is_string($sha) || empty($sha))
    {
      $this->erreurs[] = self::INVALID_EXT_IMG;
    }
    
    $this->extImg = $ext;
  }
 
  public function setCreationDate(\DateTime $creationDate)
  {
    $this->creationDate = $creationDate;
  }
 
  // GETTERS //
  
  public function id() { return $this->id; }
  public function album() { return $this->album; }
  public function possessor() { return $this->possessor; }
  public function title() { return $this->title; }
  public function resum() { return $this->resum; }
  public function shaImg() { return $this->shaImg; }
  public function extImg() { return $this->extImg; }
  public function creationDate() { return $this->creationDate; }
}