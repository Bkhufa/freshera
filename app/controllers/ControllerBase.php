<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function authorized()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->redirect('user/loginpage');
        }
    }

    public function isLoggedIn()
    {
        // Check if the variable is defined
        if ($this->session->has('name') AND $this->session->has('email') AND $this->session->has('id') ){
            return true;
        }
        return false;
    }
}
 