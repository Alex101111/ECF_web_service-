<?php

namespace App\Controller;
use PDOException;
use App\Model\User;
use App\Dao\UserDao;
class SignupController
{

  public function index()
  {
        
      $user_post = json_decode(file_get_contents('php://input'), true);
 echo json_last_error_msg();
      /** verify that the variables exist and are not null */
      if(isset($user_post['pseudo']) && isset($user_post['email']) && isset($user_post['pwd']) && isset($user_post['conf_pwd']))
      {
          

        if (empty(trim($user_post['pseudo']))){
            $error_message[] = "pseudo inexistant ! ";
        }
        
        if (empty(trim($user_post['email']))){
            $error_message[] = "email inexistant ! ";
        }
        if (empty(trim($user_post['pwd']))){
            $error_message[] = "pwd inexistant ! ";
        }
        if (empty(trim($user_post['conf_pwd']))){
            $error_message[] = "conf_pwd inexistant ! ";
        }
       
        if(empty(trim($user_post['pwd']))!==empty(trim($user_post['conf_pwd']))){
            $error_message[] = "pasword and pasword confirmation does not match !";
        }

      /**
     * verify that there are no error messages 
     */
       if(!isset($error_message)){
     
            $user = new User();
            $user ->setPseudo($user_post['pseudo'])
                 ->setEmail($user_post['email'])
                 ->setHashPwd($user_post['pwd']);

                 $userDao = new UserDao();
                 $userDao -> new($user);
                 header("Content-Type: application/json");
                 echo json_encode([
                     'id_user' => $user->getIdUser()
                 ]);

        }else{
            echo json_encode([
                "error_messages" =>array(
                    "danger" =>$error_message
                )
            ]);

     }
     }

  }

 




      
  
}