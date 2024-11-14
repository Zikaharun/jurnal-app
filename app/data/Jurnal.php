<?php
abstract class Jurnal {
    protected int $id;
    protected string $title;
    protected string $date;
    protected string $content;

    public function __construct($id, $title, $date, $content) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->content = $content;

    }


    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDate() {
        return $this->date;
    }

    public function getContent() {
        return $this->content;
    }

    

    

    // public function getJurnal() {
    //     $str = "{$this->title} || {$this->date} || {$this->content}";

    //     return $str;
    // }
}