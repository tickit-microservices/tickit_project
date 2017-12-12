<?php

namespace app\entities;

use yii\db\ActiveRecord;

class Pagination
{
    private $models = [];

    private $total = 0;

    private $page = 1;

    private $pageSize = 20;

    /**
     * Pagination constructor.
     *
     * @param ActiveRecord[] $models
     * @param int $total
     * @param int $page
     * @param int $pageSize
     */
    public function __construct($models = [], $total = 0, $page = 1, $pageSize = 20)
    {
        $this->models = $models;
        $this->total = $total;
        $this->page = 1;
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return float
     */
    public function getPageCount()
    {
        return ceil($this->total / $this->pageSize);
    }
}