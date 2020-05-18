<?php

use Phalcon\Mvc\Model;

class Item extends Model
{
    /**
     *
     * @var integer
     */
    public $item_id;

    /**
     *
     * @var string
     */
    public $item_nama;

    /**
     *
     * @var string
     */
    public $item_deskripsi;

    /**
     *
     * @var string
     */
    public $item_kategori;

    /**
     *
     * @var string
     */
    public $item_harga;

    /**
     *
     * @var string
     */
    public $item_stock;

    /**
     *
     * @var string
     */
    public $item_lokasi;

    /**
     *
     * @var int
     */
    public $status_diskon;

    /**
     *
     * @var string
     * @Column(column="created", type="string", nullable=false)
     */
    public $item_updated;

    public function initialize()
    {
        $this->setSchema("freshera");
        $this->setSource("Item");
    }

    /**
     * Method to set the value of field item_foto
     *
     * @param string $uang_bukti
     * @return $this
     */
    public function setItemFoto($item_foto)
    {
        $this->item_foto = $item_foto;

        return $this;
    }

    /**
     * Returns the value of field uang_bukti
     *
     * @return string
     */
    public function getItemFoto()
    {
        return $this->item_foto;
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