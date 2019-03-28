<?php
namespace Model;

use \OCFram\IResult;

use \Entity\User;
 
class UsersManagerPDO extends UsersManager
{
    // Lecture

    public function getUnique($id) {
        $requete = $this->dao->prepare('SELECT * FROM r_user WHERE id = :id');
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();
    
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\User');
    
        if ($user = $requete->fetch())
        {
            $user->setCreationDate(new \DateTime($user->creationDate()));
            return $user;
        }
    
        return null;
    }

    public function getList($debut = -1, $limite = -1) {
        $sql = 'SELECT * FROM r_user';
 
        if ($debut != -1 || $limite != -1)
        {
            $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }
    
        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\User');
    
        $listeUsers = $requete->fetchAll();
    
        foreach ($listeUsers as $user)
        {
            $user->setCreationDate(new \DateTime($user->creationDate()));
        }
    
        $requete->closeCursor();
    
        return new IResult($listeUsers);
    }

    // Ecriture
    
    public function delete($id) {
        $this->dao->exec('DELETE FROM r_user WHERE id = '.(int) $id);
    }

    protected function modify(User $user) {
        $requete = $this->dao->prepare('UPDATE r_user SET login = :login, pass = :pass, mail = :mail WHERE id = :id');
 
        $requete->bindValue(':login', $user->login());
        $requete->bindValue(':pass', $user->pass());
        $requete->bindValue(':mail', $user->mail());
        $requete->bindValue(':id', $user->id(), \PDO::PARAM_INT);
    
        $requete->execute();
    }

    protected function add(User $user) {
        $requete = $this->dao->prepare('INSERT INTO r_user SET login = :login, pass = :pass, mail = :mail, creation_date = NOW()');
 
        $requete->bindValue(':login', $user->login());
        $requete->bindValue(':pass', $user->pass());
        $requete->bindValue(':mail', $user->mail());
    
        $requete->execute();
    }
}