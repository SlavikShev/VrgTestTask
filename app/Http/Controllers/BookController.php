<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
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
        $result = $this->bookRepository->createModel($request);

        if ($result) {
            $authors = $this->authorRepository->getAllBaseRecords();
            $books = $this->bookRepository->buildQuery();
            $booksTitleList = $this->bookRepository->getUniqueField('title');
            $booksAuthorsList = $this->authorRepository->getBookAuthorsList();

            return response()->view('books.list', compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
        } else
            return response()->json(['message' => 'error'],500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BookRequest $request
     * @param  \App\Models\Book  $book
     * @return JsonResponse|Response
     */
    public function update(BookRequest $request, Book $book)
    {
        $result = $this->bookRepository->updateModel($book, $request);

        if ($result) {
            $authors = $this->authorRepository->getAllBaseRecords();
            $books = $this->bookRepository->buildQuery();
            $booksTitleList = $this->bookRepository->getUniqueField('title');
            $booksAuthorsList = $this->authorRepository->getBookAuthorsList();

            return response()->view('books.list', compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
        } else
            return response()->json(['message' => 'error'],500);
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
            $books = $this->bookRepository->buildQuery();
            $booksTitleList = $this->bookRepository->getUniqueField('title');
            $booksAuthorsList = $this->authorRepository->getBookAuthorsList();

            return response()->view('books.list',compact('authors', 'books', 'booksTitleList', 'booksAuthorsList'));
        } else
            return response()->json(['message' => 'error'],500);
    }
}
