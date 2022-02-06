<?php

namespace App\Repositories;

use App\Models\Author;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Author as Model;

/**
 * Class AuthorRepository.
 */
class AuthorRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();

        $this->model = Model::class;
    }

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Model::class;
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
        return Author::distinct()->pluck($field);
    }

    public function createModel ($request) {
        return Author::create($request->all());
    }

    public function updateModel ($author, $request) {
        return $author->update($request->all());
    }

    public function deleteModel ($author) {
        return $author->delete();
    }

    public function getVarsForView ($request) {
        $authors = $this->buildQuery($request);
        $uniqueAuthorsSurname = $this->getUniqueField('surname');
        $uniqueAuthorsName = $this->getUniqueField('name');

        return compact('authors', 'uniqueAuthorsSurname', 'uniqueAuthorsName');
    }
}
