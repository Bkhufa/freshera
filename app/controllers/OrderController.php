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

}