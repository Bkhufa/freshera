<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->buah = Item::find([
            'conditions' => 'item_kategori = "Buah"',
        ]);
        $this->view->sayur = Item::find([
            'conditions' => 'item_kategori = "Sayur"',
        ]);
        $this->view->rempah = Item::find([
            'conditions' => 'item_kategori = "Rempah"',
        ]);
        $this->view->lain = Item::find([
            'conditions' => 'item_kategori = "Lain"',
        ]);
    }

}

