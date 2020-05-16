<?php

class ItemController extends ControllerBase
{
    public function indexAction()
    {
        
    }

    public function aturItemAction()
    {
        $this->authorized();
        $this->view->items = Item::find();
    }
    
    public function lihatItemAction()
    {
        $this->view->items = Item::find();
    }
    
    public function detailItemAction($item_id)
    {
        $this->view->item = Item::findFirst([
            'conditions' => 'item_id = :item_id:',
            'bind'       => [
                'item_id' => $item_id,
            ],
        ]);
    }

    public function tambahItemAction()
    {
        $this->authorized();
        $success = false;
        
        $dataSent = $this->request->getPost();
        $item = new Item;
         
        if($this->request->isPost())
        {
            $item->item_nama = $dataSent["item_nama"];
            $item->item_deskripsi = $dataSent["item_deskripsi"];
            $item->item_kategori = $dataSent["item_kategori"];
            $item->item_harga = $dataSent["item_harga"];
            $item->item_stock = $dataSent["item_stock"];
            $item->item_lokasi = $dataSent["item_lokasi"];
            $item->setItemFoto(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));

            $success = $item->save();
        }
        if($success)
        {
            echo "<div class='alert alert-success'> Data saved! </div>";
            header("refresh:2;url=/item/aturitem");
        } else 
        {
            $messages = $item->getMessages();

            foreach ($messages as $message) {
                echo "<div class='alert alert-danger'>", $message->getMessage(), "</div>";
            }
            header("refresh:2;url=/item/aturitem");
        }
    }

    public function editItemAction($item_id)
    {
        $this->authorized();
        $success = false;
        $dataSent = $this->request->getPost();

        $exist = Item::findFirst([
            'conditions' => 'item_id = :item_id:',
            'bind'       => [
                'item_id' => $item_id,
            ],
        ]);
 
        if($exist)
        {
            $exist->item_nama = $dataSent["item_nama"];
            $exist->item_deskripsi = $dataSent["item_deskripsi"];
            $exist->item_kategori = $dataSent["item_kategori"];
            $exist->item_harga = $dataSent["item_harga"];
            $exist->item_stock = $dataSent["item_stock"];
            $exist->item_lokasi = $dataSent["item_lokasi"];
            $exist->setItemFoto(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));

            $success = $exist->update();
        }
        if($success)
        {
            echo "<div class='alert alert-success'> Data berhasil diubah! </div>";
            header("refresh:2;url=/item/aturitem");
        } else 
        {
            $messages = $item->getMessages();

                foreach ($messages as $message) {
                    echo "<div class='alert alert-danger'>", $message,  "</div><br>";
                }
            header("refresh:2;url=/item/aturitem");
        }
    }

    public function hapusItemAction($item_id)
    {
        $this->authorized();
        $exist = Item::findFirst([
            'conditions' => 'item_id = :item_id:',
            'bind'       => [
                'item_id' => $item_id,
            ],
        ]);
        if ($exist !== false) 
        {
            if ($exist->delete() === false) {
                $messages = $exist->getMessages();

                foreach ($messages as $message) {
                    echo "<div class='alert alert-danger'>", $message,  "</div><br>";
                }
                header("refresh:2;url=/item/aturitem/".$item_id);
            } else {
                echo "<div class='alert alert-success'> Item berhasil dihapus!</div>";
                header("refresh:2;url=/item/aturitem/".$item_id);
            }
        } 
        if (!$exist)
        {
            if ($item !== false) {
                if ($item->delete() === false) {
                    $messages = $item->getMessages();
    
                    foreach ($messages as $message) {
                        echo "<div class='alert alert-danger'>", $message,  "</div><br>";
                    }
                    header("refresh:2;url=/item/aturitem");
                } else {
                    echo "<div class='alert alert-success'> Item berhasil dihapus!</div>";
                    header("refresh:2;url=/item/aturitem");
                }
            }
        }
    }

}