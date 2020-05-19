<?php

class OrderController extends ControllerBase
{
    public function tambahOrderAction($product_id)
    {
        $this->authorized();
        $success = false;

        $user_id = $this->session->get('id');
        
        $dataSent = $this->request->getPost();
        $order = new Order;
         
        if($this->request->isPost())
        {
            $order->productid = $product_id;
            $order->userid = $user_id;
            $order->order_quantity = $dataSent["modal-jumlah"];
            $order->order_subtotal = $dataSent["modal-harga"];
            $order->order_status = 0;
            $success = $order->save();
        }
        if($success)
        {
            echo "<div class='alert alert-success'> Pesanan berhasil dibuat! </div>";
            header("refresh:2;url=/");
        } else 
        {
            $messages = $order->getMessages();

            foreach ($messages as $message) {
                echo "<div class='alert alert-danger'>", $message->getMessage(), "</div>";
            }
            header("refresh:2;url=/");
        }
    }

    public function hapusItemAction($order_id)
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

    public function lihatOrderAction() 
    {
        $this->authorized();
        $this->view->items = Item::find();
        $this->view->orders = Order::find();
        $this->view->users = User::find();
    }

    public function bayarOrderAction($order_id)
    {
        $this->authorized();
        $success = false;
        $dataSent = $this->request->getPost();

        $exist = Order::findFirst([
            'conditions' => 'order_id = :order_id:',
            'bind'       => [
                'order_id' => $order_id,
            ],
        ]);
 
        if($exist)
        {
            $exist->order_address = $dataSent["order_address"];
            $exist->setItemFoto(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));
            $exist->order_status = 1;
            $success = $exist->update();
        }
        if($success)
        {
            $this->flashSession->success("Konfirmasi Pembayaran Berhasil!");
            return $this->response->redirect('order/lihatorder');
        } else 
        {
            $messages = $order->getMessages();

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);

            return $this->response->redirect('order/lihatorder');
        }
    }

    public function hapusOrderAction($order_id)
    {
        $this->authorized();
        $exist = Order::findFirst([
            'conditions' => 'order_id = :order_id:',
            'bind'       => [
                'order_id' => $order_id,
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
            return $this->response->redirect('order/lihatorder');
            } else {
                $this->flashSession->success("Pesanan telah dibatalkan!");
                return $this->response->redirect('order/lihatorder');
            }
        } 
        if (!$exist)
        {
            if ($order !== false) {
                if ($order->delete() === false) {
                    $messages = $order->getMessages();
    
                    $msg = "";
                    foreach ($messages as $message) {
                        $msg = $msg." ".$message.".";
                    }
                    $this->flashSession->error($msg);
                    return $this->response->redirect('order/lihatorder');
                } else {
                    $this->flashSession->success("Pesanan telah dibatalkan!");
                    return $this->response->redirect('order/lihatorder');
                }
            }
        }
    }

    public function aturOrderAction()
    {
        $this->authorized();
        $this->view->items = Item::find();
        $this->view->orders = Order::find();
        $this->view->users = User::find();
    }

    public function kirimOrderAction($order_id)
    {
        $this->authorized();
        $success = false;

        $exist = Order::findFirst([
            'conditions' => 'order_id = :order_id:',
            'bind'       => [
                'order_id' => $order_id,
            ],
        ]);
        if($exist)
        {
            $exist->order_status = 2;
            $success = $exist->update();
        }
        if($success)
        {
            $this->flashSession->success("Konfirmasi Pembayaran Disetujui dan Pesanan Dikirim!");
            return $this->response->redirect('order/aturorder');
        } else 
        {
            $messages = $order->getMessages();

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);

            return $this->response->redirect('order/aturorder');
        }
    }

    public function tibaOrderAction($order_id)
    {
        $this->authorized();
        $success = false;

        $exist = Order::findFirst([
            'conditions' => 'order_id = :order_id:',
            'bind'       => [
                'order_id' => $order_id,
            ],
        ]);
        if($exist)
        {
            $exist->order_status = 3;
            $success = $exist->update();
        }
        if($success)
        {
            $this->flashSession->success("Pesanan telah Tiba di Tempat Anda!");
            return $this->response->redirect('order/lihatorder');
        } else 
        {
            $messages = $order->getMessages();

            $msg = "";
            foreach ($messages as $message) {
                $msg = $msg." ".$message.".";
            }
            $this->flashSession->error($msg);

            return $this->response->redirect('order/lihatorder');
        }
    }
}