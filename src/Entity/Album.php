<?php
namespace Entity;
 
use \OCFram\Entity;
 
class Album extends Entity
{
  protected $id,
            $title,
            $resum,
            $creationDate,
            $changeDate;

  const INVALID_TITLE = 1;
  const INVALID_RESUM = 2;

  public function isValid()
  {
    return !(empty($this->title) || empty($this->resum));
  }
 
  // SETTERS //
 
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
 
  public function setCreationDate(\DateTime $creationDate)
  {
    $this->creationDate = $creationDate;
  }

  public function setChangeDate(\DateTime $dateEdit)
  {
    $this->dateEdit = $dateEdit;
  }
 
  // GETTERS //
  
  public function id() { return $this->id; }
  public function title() { return $this->title; }
  public function resum() { return $this->resum; }
  public function creationDate() { return $this->creationDate; }
  public function changeDate() { return $this->changeDate; }
}