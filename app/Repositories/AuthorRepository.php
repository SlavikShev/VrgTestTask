<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends CoreRepository
{

    protected function getModelClass() {
        return Author::class;
    }

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

    public function getUniqueField (string $field) {
        return Author::distinct()->orderBy($field)->pluck($field);
    }

    public function getVarsForView ($request) {
        $authors = $this->buildQuery($request);
        $uniqueAuthorsSurname = $this->getUniqueField('surname');
        $uniqueAuthorsName = $this->getUniqueField('name');

        return compact('authors', 'uniqueAuthorsSurname', 'uniqueAuthorsName');
    }
}
