<?php

require_once 'ServiceLogic.php';

class Logic implements ServiceLogic {
    private $Categorys = [];

    public function addJurnal(Category $category) {

        $this->Categorys[] = $category; 

    }

    public function deleteJurnal($id) {
        foreach($this->Categorys as $index => $category) {
            if ($category->getId()=== $id) {
                unset($this->Categorys[$index]);

                $this->Categorys = array_values($this->Categorys);
                
                return "jurnal has been deleted!";

                
            }
        }

        return "failed!";
    }

    public function findbyid($id) {
        foreach($this->Categorys as $index => $category) {
            if ($category->getId() == $id) {
                return $category;
            }
        }
    }

    public function getJurnalList() {

        return $this->Categorys;
        
    }
 }