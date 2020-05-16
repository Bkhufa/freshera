<?php

declare(strict_types=1);
use Phalcon\Security;
// use Phalcon\Mvc\Controller;

class UserController extends ControllerBase
{

    public function indexAction()
    {
       
    }

    public function loginpageAction()
    {
       
    }
    
    public function signuppageAction()
    {
       
    }

    public function loginAction()
    {
        if($this->request->isPost())
        { 
         $email    = $this->request->getPost('email');
         $password = $this->request->getPost('password');
         echo "</br>";
         $user = User::findFirst(     // Nyari user berdasar Email yang diinput
             [
                 'conditions' => 'email = :email:',
                 'bind'       => [
                     'email' => $email,
                 ],
             ]
         );
 
         if ($user) { //Memeriksa apakah user ada
            $check = $this
               ->security
               ->checkHash($password, $user->password); //Memeriksa apakah password sesuai

             if (true == $check) {  
                 //Password benar
                 $this->session->set('id', $user->id);
                 $this->session->set('name', $user->name);
                 $this->session->set('email', $user->email);
                 $this->session->set('phone', $user->phone);
                 $this->session->set('address', $user->address);
                 $this->session->set('is_admin', $user->is_admin);
                 
                 return $this->dispatcher->forward(array( 
                     'controller' => 'index',
                     'action' => 'index' 
                 )); 
                 echo "<div class='alert alert-success'> You're Logged in! </div>";
             }
             else {
                //Password salah
                echo "<div class='alert alert-danger'> Wrong password! </div>";
                header("refresh:2;url=/user/loginpage");
             }
         }
         else {
            //User tidak ada di database
            echo "<div class='alert alert-danger'> User doesn't exist, please sign up! </div>";
             header("refresh:2;url=/user/loginpage");
            //  $this->security->hash(rand());
         }
        }
     }

    public function logoutAction() { 
        //   $this->session->remove('auth');
        $this->session->destroy();
        return $this->dispatcher->forward(array( 
            'controller' => 'index', 'action' => 'index' 
        )); 
    }

    public function profileAction() 
    {
        $this->authorized();
    }

    public function editProfileAction()
    {
        $this->authorized();
    }

    public function editedProfileAction()
    {
        $this->authorized();
        $email = $this->session->get("email");
        $success = false;
        
        $exist = Users::findFirst(
            [
                'conditions' => 'email = :email:',
                'bind'       => [
                    'email' => $email,
                ],
            ]
        );
 
        if($exist)
        {
            $dataSent = $this->request->getPost();

            $security = new Security();
            
            $hashed = $security->hash($dataSent["password"]);
            $exist->name = $dataSent["name"];
            $exist->email = $dataSent["email"];
            $exist->password = $hashed;
            $exist->phone = $dataSent["phone"];
            $exist->address = $dataSent["address"];
            
            $success = $exist->update();

            $this->session->set('name', $exist->name);
            $this->session->set('email', $exist->email);
            $this->session->set('phone', $exist->phone);
            $this->session->set('address', $exist->address);
        }
        if($success)
        {
            echo "<div class='alert alert-success'> Profile Saved! </div>";
            header("refresh:2;url=/user/profile");
        } else 
        {
            echo "<div class='alert alert-danger'> Profile not saved! </div>";
            header("refresh:2;url=/user/editProfile");
        }
    }

    public function signupAction()
    {
        $user = new User();
        $email = $this->request->getPost('email');

        if($this->request->isPost())
        {
            $exist = User::findFirst(     
                [
                    'conditions' => 'email = :email:',
                    'bind'       => [
                        'email' => $email,
                    ],
                ]
            );
    
            if($exist)
            {
                // $this->view->message = "<div class='alert alert-danger'> Email already used, please use a new one! </div>";
                $success = false;
                header("refresh:2;url=/user/signuppage");
                echo "<div class='alert alert-danger'> Email already used, please use a new one! </div>";
                
            } else
            {
                $dataSent = $this->request->getPost();

                $security = new Security();
                
                $hashed = $security->hash($dataSent["password"]);
                $user->name = $dataSent["name"];
                $user->email = $dataSent["email"];
                $user->password = $hashed;
                $user->phone = $dataSent["phone"];
                $user->address = $dataSent["address"];
    
                $success = $user->save();
            }
        }
        if (!$success) {
            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo "<div class='alert alert-danger'>", $message->getMessage(), "</div>";
            }
            header("refresh:2;url=/user/signuppage");
        } else {
            echo "<div class='alert alert-success'> Sign up successful! </div>";
            header("refresh:2;url=/user/loginpage");
        }
    }

}