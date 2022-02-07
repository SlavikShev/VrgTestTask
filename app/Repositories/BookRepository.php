<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass() {
        return Book::class;
    }

    /**
     * return result with paginate
     *
     * @param null $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function buildQuery ($request = null)
    {
        $books = Book::select()->with(['authors']);

        if ($request) {
            if ($request->has('titleOrderBy')) {
                $books->orderBy('title', $request->get('titleOrderBy'));
            }
            if ($request->has('bookTitle')) {
                $books->whereIn('title', $request->get('bookTitle'), 'or');
            }
            if ($request->has('bookAuthor')) {
                $books->join('book_authors', 'books.id', '=', 'book_authors.book_id')
                    ->whereIn('author_id', $request->get('bookAuthor'), 'or')
                    ->groupBy('id');
            }
        }
        return $books->paginate(15)->withQueryString();
    }

    /**
     * return unique ordered field from db
     *
     * @param string $field
     * @return \Illuminate\Support\Collection
     */
    public function getUniqueField (string $field)
    {
        return Book::distinct()->orderBy($field)->pluck($field);
    }

    public function updateModel ($book, $request) {
        $data = $this->storeImage($request);
        $result = $book->update($data);
        if ($result) {
            $data_authors = $data['book_authors'];
            $book->authors()->detach();
            $book->authors()->attach($data_authors);
        }
        return $result;
    }

    public function createModel($request)
    {
        $data = $this->storeImage($request);
        $book = Book::create($data);

        if ($book) {
            $book->authors()->attach($data['book_authors']);
        }
        return $book;
    }

    private function storeImage ($request)
    {
        $data = $request->all();
        if (isset($data['bookCover'])) {
            $image = $request->file('bookCover');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('book_covers'), $new_name);
            $data['image'] = $new_name;
        }
        return $data;
    }
}
