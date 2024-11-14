<?php

require_once 'Jurnal.php';
class Category extends Jurnal {
    protected $nameCategory;

    public function __construct($id,$title, $date, $content, $nameCategory) {
    parent::__construct($id, $title, $date,$content);
     $this->nameCategory = $nameCategory;
    }

    public function getNameCategory() {
        return $this->nameCategory;
    }

    

}