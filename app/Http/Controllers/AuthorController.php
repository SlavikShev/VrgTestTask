<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    private $authorRepository;

    public function __construct()
    {
        $this->authorRepository = app(AuthorRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        // todo add alphabetic sort
        $compactVars = $this->authorRepository->getVarsForView(request());

        return view('authors.index', $compactVars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AuthorRequest  $request
     * @return JsonResponse|Response
     */
    public function store(AuthorRequest $request)
    {
        // todo add message after successful creating author
        $result = $this->authorRepository->createModel($request);

        if ($result) {
            $compactVars = $this->authorRepository->getVarsForView(request());

            return response()->view('authors.list', $compactVars);
        } else
            return response()->json(['message' => 'error'],500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return JsonResponse|Response
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $result = $this->authorRepository->updateModel($author, $request);

        if ($result) {
            $compactVars = $this->authorRepository->getVarsForView(request());

            return response()->view('authors.list', $compactVars);
        }
        else
            return response()->json(['message' => 'error'],500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return JsonResponse|Response
     */
    public function destroy(Author $author)
    {
        $result = $this->authorRepository->deleteModel($author);

        if ($result) {
            $compactVars = $this->authorRepository->getVarsForView(request());

            return response()->view('authors.list', $compactVars);
        }
        else
            return response()->json(['message' => 'error'],500);
    }
}
