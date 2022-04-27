<?php	
namespace App\Controller;

use PDOException;
use App\Model\User;
use App\Dao\UserDao;

class UserController
{
    public function index()
    {
        try{
            $userDao = new UserDao();
            $users = $userDao->getAll();
            for($i = 0 ; $i < count($users); $i++)
            {
                $users[$i] = $users[$i]->toArray();

            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($users);
        }catch(PDOException $e){
            
        }
    }

    public function show()
    {
        $id_user = json_decode(file_get_contents('php://input'),true);
        $userDao = new UserDao();
        $user = $userDao->getById($id_user['id_user']);

        if(!is_null($user)){
            $user = $user->toArray();
        }else{
            header("Content-Type: application/json");
            echo json_encode("null");
        }
        header("Content-Type: application/json");
        echo json_encode($user);
    }



    public function edit(){

        $user_input = json_decode(file_get_contents('php://input'), true);

         /** verify that the variables exist and are not null */
         if(isset($user_input['id_user']) && isset($user_input['pseudo']) && isset($user_input['email']) & isset($user_input['pwd'])
         & isset($user_input['new_pwd']) & isset($user_input['conf_new_pwd'])){

            if(empty(trim($user_input['pseudo']))){
                $error_message[] = 'pseudo inexistant';
            }
            if(empty(trim($user_input['email']))){
                $error_message[] = 'email inexistant';
            }
            if(empty(trim($user_input['pwd']))){
                $error_message[] = 'pwd inexistant';
            }
            if(empty(trim($user_input['new_pwd']))){
                $error_message[] = 'new_pwd inexistant';
            }
            if(empty(trim($user_input['conf_new_pwd']))){
                $error_message[] = 'conf_new_pwd inexistant';
            }

            if($user_input['new_pwd'] !== ($user_input['conf_new_pwd'])){
                $error_message[] = "password and confirmation does not match ! ";
            }
      
            if(!isset($error_message)){
             $user = new User();
      
             $user->setIdUser($user_input['id_user']);
             $user->setPseudo($user_input['pseudo']);
             $user->setEmail($user_input['email']);
             $user->setHashPwd($user_input['pwd']);
             $userDao = new UserDao();
             $userDao ->edit($user);

                 
            }else{
                echo json_encode([
                    "error_messages" =>array(
                        "danger" =>$error_message
                    )
                ]);
            }
        }
    }


    public function delete(){

        $user_id = json_decode(file_get_contents('php://input'), true);

         $userDao = new UserDao();

   $userDao->delete($user_id['id_user']);
  }
    


}