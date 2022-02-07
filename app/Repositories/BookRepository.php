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

        if ($request->has('titleOrderBy')) {
            $books->orderBy('title', $request->get('titleOrderBy'));
        }
        if ($request->has('bookTitle')){
            $books->whereIn('title', $request->get('bookTitle'),'or');
        }
        if ($request->has('bookAuthor')){
            $books->join('book_authors','books.id','=','book_authors.book_id')
                ->whereIn('author_id',$request->get('bookAuthor'),'or')
                ->groupBy('id');
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

    /**
     * return array to set it in template
     *
     * @param $request
     * @return array
     */
    public function getVarsForView ($request) {
        $authors = $this->buildQuery($request);
        $uniqueAuthorsSurname = $this->getUniqueField('surname');
        $uniqueAuthorsName = $this->getUniqueField('name');

        return compact('authors', 'uniqueAuthorsSurname', 'uniqueAuthorsName');
    }
}
