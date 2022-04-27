<?php

namespace App\Dao;

use PDO;
use Core\AbstractDao;
use App\Model\User;

class UserDao extends AbstractDao
{
    /**
     * Récupère un utilisateur par son email si l'email existe dans la base de données,
     * sinon on récupèrera NULL
     *
     * @param string $email L'email de l'utilisateur
     * @return User|null Renvoi un utilisateur ou null
     */
    public function getByEmail(string $email): ?User
    {
        $sth = $this->dbh->prepare('SELECT * FROM user WHERE email = :email');
        $sth->execute([':email' => $email]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $u = new User();
        return $u->setIdUser($result['id_user'])
            ->setPseudo($result['pseudo'])
            ->setPwd($result['pwd'])
            ->setEmail($result['email'])
            ->setCreatedAt($result['created_at']);
    }

    /**
     * @return User[] returns a table of user object 
     */



     public function getAll(): Array 
     {
         $sth = $this->dbh->prepare("SELECT * FROM `user` ");
         $sth->execute();
         $result = $sth->fetchAll(PDO::FETCH_ASSOC);

         for($i=0;$i < count($result); $i++){
             $a = new User();
             $result[$i] = $a->setIdUser($result[$i]['id_user'])
                             ->setPseudo($result[$i]['pseudo'])
                             ->setEmail($result[$i]['email'])
                             ->setCreatedAt($result[$i]['created_at']);
         }
         return $result; 
     }

     /**
      * 
      *get a user from the database based on user id or returning null if the user does not exist
      *@param int id of the user is int
      *@return User|null it will return a user or null if not exist 

      */

      public function getById(int $id): ?User
      {
          $sth = $this->dbh->prepare("SELECT * FROM user WHERE id_user = :id_user");
          $sth->execute([':id_user' =>$id]);
          $result = $sth->fetch(PDO::FETCH_ASSOC);

          if(empty($result)) return null;
          $a = new User();

          return $a->setIdUser($result['id_user'])
                  ->setPseudo($result['pseudo'])
                  ->setEmail($result['email'])
                  ->setCreatedAt($result['created_at']);
      }



      /**
       * @param User $user is object of the user we add to database 
       */
   public function new(User $user): void
   {
       $sth = $this->dbh->prepare(
           "INSERT INTO 'user' (pseudo, email, pwd) 
           VALUES (:pseudo, :email, :pwd)");
           $sth->execute([
               ':pseudo' => $user->getPseudo(),
               ':email' =>$user->getEmail(),
               ':pwd' =>$user->getPwd()
       
           ]);
           $user->setIdUser($this->dbh->lastInsertId());
   }

/**
 * @param User $user is the object we edit
 */
  public function edit(User $user): void
  {
      $sth = $this->dbh->prepare(
          "UPDATE `user` SET pseudo = :pseudo, email = :email , pwd = :pwd WHERE id_user = :id_user "
      );
      $sth->execute([
          'id_user' =>$user->getIdUser(),
          ':pseudo' => $user->getPseudo(),
          ':email' => $user->getEmail(),
          ':pwd' =>$user->getPwd()
      ]);
  }


/**
 * delete user from database  
 * @param int @id of the user we want to delete 
 */
public function delete(int $id): void
{
    $sth = $this->dbh->prepare(" DELETE FROM `user` WHERE id_user = :id_user");
    $sth->execute([
     ':id_user' =>$id
    ]);
}


}
