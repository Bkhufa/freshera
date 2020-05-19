<?php

declare(strict_types=1);
use Phalcon\Security;
use Phalcon\Http\Request;
// use Phalcon\Flash\Session as FlashSession;
// use Phalcon\Mvc\Controller;

class UserController extends ControllerBase
{

    public function indexAction()
    {
       
    }

    public function loginpageAction()
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
                    $this->flashSession->success("Login Success");
                    return $this->response->redirect('/');
                }
                else {
                    //Password salah
                    $this->flashSession->error("Wrong password!");
                    return $this->response->redirect('/user/loginpage');
                }
            }
            else {
                //User tidak ada di database
                $this->flashSession->error("User doesn't exist, please sign up!");
                return $this->response->redirect('user/loginpage');
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
        $this->loggedin();
    }

    public function editProfileAction()
    {
        $this->loggedin();
    }

    public function editedProfileAction()
    {
        $this->loggedin();
        $email = $this->session->get("email");
        $success = false;
        
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
            $this->flashSession->success("Profil tersimpan!");
            return $this->response->redirect('user/profile');
        } else 
        {
            $this->flashSession->error("Profil tidak diperbarui!");
            return $this->response->redirect('user/editProfile');
        }
    }
    public function signuppageAction()
    {
       
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
                $this->flashSession->error("Email telah digunakan, gunakan email baru!");
                return $this->response->redirect('user/signuppage');
                
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
                $user->is_admin = 0;
    
                $success = $user->save();
            }
        }
        if (!$success) {
            $messages = $user->getMessages();
            
            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);
            return $this->response->redirect('user/signuppage');
        } else {
            $this->flashSession->success("Sign up berhasil!");
            return $this->response->redirect('user/loginpage');
        }
    }

    public function aturUserAction()
    {
        $this->authorized();
        $this->view->users = User::find([
            'conditions' => 'is_admin is null',
        ]);
    }

    public function editUserAction($id)
    {
        $this->authorized();
        $success = false;
        $dataSent = $this->request->getPost();

        $user = new User;
        $exist = User::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
        ]);
 
        if($exist)
        {
            $exist->name = $dataSent["name"];
            $exist->email = $dataSent["email"];
            $exist->phone = $dataSent["phone"];
            $exist->address = $dataSent["address"];

            $success = $exist->update();
        }
        if($success)
        {
            $this->flashSession->success("Data user berhasil diedit!");
            return $this->response->redirect('user/aturuser');
        } else 
        {
            // $messages = $user->getMessages();

            // $msg = "";
            // foreach ($messages as $message) {
            //     $msg = $msg." ".$message.".";
            // }
            $this->flashSession->error("Data user gagal diedit!");
                return $this->response->redirect('user/aturuser');
        }
    }

    public function hapusUserAction($id)
    {
        $this->authorized();
        $exist = User::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
        ]);

        $user = new User;
        if ($exist !== false) 
        {
            if ($exist->delete() === false) {
                $this->flashSession->error("Data user gagal dihapus");
                return $this->response->redirect('user/aturuser');
            } else {
                $this->flashSession->success("Data user berhasil dihapus!");
                return $this->response->redirect('user/aturuser');
            }
        } 
        if (!$exist)
        {
            if ($user->is_admin = null)
                $is_admin = null;
            if ($user->is_admin != null)
                $is_admin = 1;
            if ($user !== false) {
                if ($user->delete() === false) {
                    $this->flashSession->error("Data user gagal dihapus!");
                    if ($is_admin = null)
                    return $this->response->redirect('user/aturuser');
                    if ($is_admin != null)
                    return $this->response->redirect('user/aturpegawai');
                } else {
                    $this->flashSession->success("Data user berhasil dihapus!");
                    if ($is_admin = null)
                    return $this->response->redirect('user/aturuser');
                    if ($is_admin != null)
                    return $this->response->redirect('user/aturpegawai');
                }
            }
        }
    }

    public function aturPegawaiAction()
    {
        $this->authorized();
        $this->view->users = User::find([
            'conditions' => 'is_admin is not null',
        ]);
    }

    public function tambahPegawaiAction()
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
                return $this->response->redirect('user/aturuser');
                $this->flashSession->error("Email telah digunakan, gunakan email baru!");
                
            } else
            {
                $dataSent = $this->request->getPost();

                $security = new Security();
                
                $hashed = $security->hash("admin");
                $user->name = $dataSent["name"];
                $user->email = $dataSent["email"];
                $user->password = $hashed;
                $user->phone = $dataSent["phone"];
                $user->address = $dataSent["address"];
                $user->is_admin = $dataSent["kategori"];
    
                $success = $user->save();
            }
        }
        if (!$success) {
            $messages = $user->getMessages();

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);
            
            return $this->response->redirect('user/aturpegawai');
        } else {
            $this->flashSession->success("Pegawai baru berhasil ditambahkan!");
            return $this->response->redirect('user/aturpegawai');
        }
    }

}