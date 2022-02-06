<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
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
        if (request()->has('bookTitle')){
            $books->whereIn('title', request('bookTitle'),'or');
        }
        if (request()->has('bookAuthor')){
            $books->join('book_authors','books.id','=','book_authors.book_id')
                ->whereIn('author_id',request('bookAuthor'))
                ->groupBy('id');
        }

        $books = $books->paginate(15)->withQueryString();

        $booksTitleList = Book::toBase()->pluck('title');
        // todo make 1 request instead of two
        $book_authors_id_list = Author::get('id')->pluck('id')->toArray();
        $booksAuthorsFullNameList = Author::selectRaw('id, CONCAT(name, " ", surname ) as full_name')->pluck('full_name')->toArray();
        $booksAuthorsList = array_combine($book_authors_id_list, $booksAuthorsFullNameList);

//        todo optimize query to get 1 query using function with, to not get a lot of queries
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
     * @param  BookRequest  $request
     * @return JsonResponse|Response
     */
    public function store(BookRequest $request)
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
     * @param  BookRequest $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
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
