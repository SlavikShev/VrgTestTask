<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Author::class;
    }

    /**
     * return result with paginate
     *
     * @param null $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function buildQuery ($request = null)
    {
        $authors = Author::toBase();

        if ($request->has('surnameOrderBy')) {
            $authors->orderBy('surname', $request->get('surnameOrderBy'));
        }
        if ($request->has('authorName')) {
            $authors->whereIn('name', $request->get('authorName'), 'or');
        }
        if ($request->has('authorSurname')) {
            $authors->whereIn('surname', $request->get('authorSurname'), 'or');
        }
        return $authors->paginate(15)->withQueryString();
    }

    /**
     * return unique ordered field from db
     *
     * @param string $field
     * @return \Illuminate\Support\Collection
     */
    public function getUniqueField (string $field)
    {
        return Author::distinct()->orderBy($field)->pluck($field);
    }

    public function getBookAuthorsList ()
    {
        $query = Author::selectRaw('id, CONCAT(name, " ", surname ) as full_name')->get();
        $bookAuthorsIds = $query->pluck('id')->toArray();
        $bookFullNames = $query->pluck('full_name')->toArray();
        return array_combine($bookAuthorsIds, $bookFullNames);
    }

    public function getAllBaseRecords () {
        return Author::toBase()->get();
    }
}
