<?php

namespace App\Controllers;

use App\Models\Book;

class BookController
{
    public function index()
    {
        // Logic to display the list of books
    }

    public function create()
    {
        // Logic to show the form for creating a new book
    }

    public function store($request)
    {
        // Logic to save a new book
        $book = new Book();
        $book->title = $request['title'];
        $book->author = $request['author'];
        $book->save();

        header('Location: /bibliotecapessoal/public/books');
        exit();
    }

    public function edit($id)
    {
        // Logic to show the form for editing a book
    }

    public function update($id, $request)
    {
        // Logic to update an existing book
    }

    public function show($id)
    {
        // Logic to display a single book's details
    }

    public function delete($id)
    {
        // Logic to delete a book
    }
}