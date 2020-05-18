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
            $item->status_diskon = 0;
            $item->setItemFoto(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));

            $success = $item->save();
        }
        if($success)
        {
            $this->flashSession->success("Data item tersimpan!");
            return $this->response->redirect('item/aturitem');
        } else 
        {
            $messages = $item->getMessages();

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);

            return $this->response->redirect('item/aturitem');
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
            $this->flashSession->success("Data berhasil diubah!");
            return $this->response->redirect('item/aturitem');
        } else 
        {
            $messages = $item->getMessages();

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);

            return $this->response->redirect('item/aturitem');
        }
    }

    public function aturDiskonAction($item_id)
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
            // vardump($dataSent(["status_diskon"]));
            if($dataSent["status_diskon"] == 0) {
                $exist->item_harga = (100/(100-$exist->status_diskon))*$exist->item_harga;
            }
            else if($exist->status_diskon == 0) {
                $exist->item_harga = (100-$dataSent["status_diskon"])*$exist->item_harga*0.01;
            }
            else {
                $exist->item_harga = (100/(100-$exist->status_diskon)*$exist->item_harga); 
                $exist->item_harga = (100-$dataSent["status_diskon"])*$exist->item_harga*0.01;
            }
            
            $exist->status_diskon = $dataSent["status_diskon"];

            $success = $exist->update();
        }
        if($success)
        {
            $this->flashSession->success("Atur diskon berhasil!");
            return $this->response->redirect('item/aturitem');
        } else 
        {
            $messages = $item->getMessages();
            $this->flashSession->error($messages);
            return $this->response->redirect('item/aturitem');
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

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);
            return $this->response->redirect('item/aturitem');
            } else {
                $this->flashSession->success("Data item berhasil dihapus!");
                return $this->response->redirect('item/aturitem');
            }
        } 
        if (!$exist)
        {
            if ($item !== false) {
                if ($item->delete() === false) {
                    $messages = $item->getMessages();
    
                    $msg = "";
                    foreach ($messages as $message) {
                        $msg = $msg." ".$message.".";
                    }
                    $this->flashSession->error($msg);
                    return $this->response->redirect('item/aturitem');
                } else {
                    $this->flashSession->success("Data item berhasil dihapus!");
                    return $this->response->redirect('item/aturitem');
                }
            }
        }
    }

}