<?php
namespace Entity;
 
use \OCFram\Entity;
 
class User extends Entity
{
  protected $id,
            $login,
            $pass,
            $mail,
            $creationDate;

  const INVALID_LOGIN = 1;
  const INVALID_PASS = 2;
  const INVALID_MAIL = 3;
 
  public function isValid()
  {
    return !(empty($this->login) || empty($this->pass) || empty($this->mail));
  }
 
  // SETTERS //
 
  public function setLogin($login)
  {
    if (!is_string($login) || empty($login))
    {
      $this->erreurs[] = self::INVALID_LOGIN;
    }
 
    $this->login = $login;
  }
 
  public function setPass($pass)
  {
    if (!is_string($pass) || empty($pass))
    {
      $this->erreurs[] = self::INVALID_PASS;
    }
 
    $this->pass = $pass;
  }

  public function setMail($mail)
  {
    if (!is_string($mail) || empty($mail))
    {
      $this->erreurs[] = self::INVALID_MAIL;
    }
 
    $this->mail = $mail;
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