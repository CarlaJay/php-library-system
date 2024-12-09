<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookCrud extends Component
{
    public $title, $author, $quantity, $bookId;
    public $books;

    public function render()
    {
        $this->books = Book::all();
        return view('livewire.book-crud');
    }

    public function store()
    {
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        Book::create($validatedData);

        session()->flash('message', 'Book successfully created.');
        $this->clearFields();
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $this->bookId = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->quantity = $book->quantity;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::find($this->bookId);
        $book->update($validatedData);

        session()->flash('message', 'Book successfully updated.');
        $this->clearFields();
    }

    public function delete($id)
    {
        Book::find($id)->delete();

        session()->flash('message', 'Book successfully deleted.');
    }

    public function clearFields()
    {
        $this->title = '';
        $this->author = '';
        $this->quantity = '';
        $this->bookId = null;
    }
}

