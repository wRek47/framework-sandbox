<?php

class Documentation {

    public $ui;
    
    public $categories = [];

    public $documents = [];
    public $authors = [];

    public $filesys;

}

class Document {

    public $title = "";

    public $author = "";
    public $items = [];

    public $uploads = [];

}

class DocumentPage {

    public $authors = "";

    public $title = "";
    public $body = "";
    
    public $uploads = [];

}

?>