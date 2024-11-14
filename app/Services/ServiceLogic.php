<?php



interface ServiceLogic  {
     
     public function addJurnal(Category $Category); 

     public function deleteJurnal($id);

     public function findbyid($id);

     public function getJurnalList();
}