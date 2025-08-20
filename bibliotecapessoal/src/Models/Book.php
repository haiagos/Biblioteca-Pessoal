<?php

class Book {
    private $title;
    private $author;
    private $year;
    private $genre;

    public function __construct($title, $author, $year, $genre) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function save() {
        // Logic to save the book to the database or a file
    }

    public static function all() {
        // Logic to retrieve all books from the database or a file
    }

    public static function find($id) {
        // Logic to find a book by its ID
    }

    public function update($data) {
        // Logic to update the book's information
    }

    public function delete() {
        // Logic to delete the book
    }
}