<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookController extends Controller
{
    private $authorRepository;
    private $bookRepository;

    public function __construct()
    {
        $this->bookRepository = app(BookRepository::class);
        $this->authorRepository = app(AuthorRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $authors = $this->authorRepository->getAllBaseRecords();
        $books = $this->bookRepository->buildQuery(request());
        $booksTitleList = $this->bookRepository->getUniqueField('title');
        $booksAuthorsList = $this->authorRepository->getBookAuthorsList();

        return view('books.index', compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
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

        $books = Book::select()
            ->with(['authors']);
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
     * @return JsonResponse|Response
     */
    public function destroy(Book $book)
    {
        $result = $this->bookRepository->deleteModel($book);

        if ($result) {
            $authors = $this->authorRepository->getAllBaseRecords();
            $books = $this->bookRepository->buildQuery(request());
            $booksTitleList = $this->bookRepository->getUniqueField('title');
            $booksAuthorsList = $this->authorRepository->getBookAuthorsList();

            return response()->view('books.list',compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
        } else
            return response()->json(['message' => 'error'],500);
    }
}
