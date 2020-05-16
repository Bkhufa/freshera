<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function authorized()
    {
        if (!$this->isAdmin()) {
            // Aku gabisa bikin flash message disiniiiii
            echo "<div class='alert alert-danger'> Anda tidak memiliki akses admin! </div>";
            return $this->response->redirect('user/loginpage');
        }
    }

    public function loggedin()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->redirect('user/loginpage');
        }
    }

    public function isAdmin()
    {
        // Check if the variable is defined
        if ($this->session->get('is_admin') != null ){
            return true;
        }
        return false;
    }

    public function isLoggedIn()
    {
        // Check if the variable is defined
        if ($this->session->has(`email`) ){
            return true;
        }
        return false;
    }
}
 