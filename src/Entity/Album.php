<?php
namespace Entity;
 
use \OCFram\Entity;
 
class Album extends Entity
{
  protected $id,
            $title,
            $resum,
            $creation_date,
            $change_date;

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
    $this->creation_date = $creationDate;
  }

  public function setChangeDate(\DateTime $dateEdit)
  {
    $this->change_date = $dateEdit;
  }
 
  // GETTERS //
  
  public function id() { return $this->id; }
  public function title() { return $this->title; }
  public function resum() { return $this->resum; }
  public function creationDate() { return $this->creation_date; }
  public function changeDate() { return $this->change_date; }
}