<?php

use Phalcon\Mvc\Model;

class Order extends Model
{
    /**
     *
     * @var integer
     */
    public $order_id;
    
    /**
     *
     * @var integer
     */
    public $productid;
    
    /**
     *
     * @var integer
     */
    public $orderid;

    /**
     *
     * @var integer
     */
    public $order_quantity;

    /**
     *
     * @var string
     */
    public $order_address;

    /**
     *
     * @var string
     */
    public $order_subtotal;

    public function initialize()
    {
        $this->setSchema("freshera");
        $this->setSource("Order");
    }

    public function setItemFoto($order_foto)
    {
        $this->order_foto = $order_foto;

        return $this;
    }

    /**
     * Returns the value of field uang_bukti
     *
     * @return string
     */
    public function getItemFoto()
    {
        return $this->order_foto;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Item[]|Item|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Item|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}