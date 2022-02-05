<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $authors = Author::toBase()->get();

        $books = Book::select();
        if (request()->has('titleOrderBy')) {
            $books->orderBy('title', request('titleOrderBy'));
        }
        $books = $books->paginate(15);

        $booksTitleList = Book::toBase()->pluck('title');
        $booksAuthorsList = Author::selectRaw('CONCAT(name, " ", surname ) as full_name')->pluck('full_name');

//        todo optimize query to get 1 query instead of amount of books
        return view('books.index', compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->file('bookCover')) {
            $image = $request->file('bookCover');
            // todo find better hash function
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('book_covers'), $new_name);
            $data['image'] = $new_name;
        }
        $book = Book::create($data);

        $data_authors = $data['book_authors'];
        $book->authors()->attach($data_authors);

        $authors = Author::toBase()->get();

        $books = Book::select();
        if (request()->has('titleOrderBy')) {
            $books->orderBy('title', request('titleOrderBy'));
        }
        $books = $books->paginate(15);

        $booksTitleList = Book::toBase()->pluck('title');
        $booksAuthorsList = Author::selectRaw('CONCAT(name, " ", surname ) as full_name')->pluck('full_name');
//        todo optimize query to get 1 query instead    of amount of books
        return response()->view('books.list',compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->all();
        if ($request->file('bookCover')) {
            $image = $request->file('bookCover');
            // todo find better hash function
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('book_covers'), $new_name);
            $data['image'] = $new_name;
        }
        $result = $book->update($data);
        $data_authors = $data['book_authors'];
        $book->authors()->detach();
        $book->authors()->attach($data_authors);

        $authors = Author::toBase()->get();

        $books = Book::select();
        if (request()->has('titleOrderBy')) {
            $books->orderBy('title', request('titleOrderBy'));
        }
        $books = $books->paginate(15);

        $booksTitleList = Book::toBase()->pluck('title');
        $booksAuthorsList = Author::selectRaw('CONCAT(name, " ", surname ) as full_name')->pluck('full_name');
//        todo optimize query to get 1 query instead of amount of books
        return response()->view('books.list',compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        $authors = Author::toBase()->get();

        $books = Book::select();
        if (request()->has('titleOrderBy')) {
            $books->orderBy('title', request('titleOrderBy'));
        }
        $books = $books->paginate(15);

        $booksTitleList = Book::toBase()->pluck('title');
        $booksAuthorsList = Author::selectRaw('CONCAT(name, " ", surname ) as full_name')->pluck('full_name');
//        todo optimize query to get 1 query instead    of amount of books
        return response()->view('books.list',compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
    }
}
