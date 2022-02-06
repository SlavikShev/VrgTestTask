<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $authors = Author::toBase();

        if (request()->has('surnameOrderBy')) {
            $authors->orderBy('surname', request('surnameOrderBy'));
        }

        if (request()->has('authorName')) {
            $authors->whereIn('name', request('authorName'),'or');
        }

        if (request()->has('authorSurname')) {
            $authors->whereIn('surname', request('authorSurname'),'or');
        }

        // todo add alphabetic sort
        $uniqueAuthorsSurname = Author::distinct()->pluck('surname');
        $uniqueAuthorsName = Author::distinct()->pluck('name');

        $authors = $authors->paginate(15)->withQueryString();
        return view('authors.index', compact('authors', 'uniqueAuthorsSurname', 'uniqueAuthorsName'));
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
     * @param  AuthorRequest  $request
     * @return JsonResponse|Response
     */
    public function store(AuthorRequest $request)
    {
        // todo add validation
        $author = Author::create($request->all());

        if ($author) {
            $authors = Author::selectRaw('*')->toBase();
            $uniqueAuthorsSurname = $authors->get()->unique('surname')->pluck('surname');
            $uniqueAuthorsName = $authors->get()->unique('name')->pluck('name');
            $authors = $authors->paginate(15)->withQueryString();
            return response()->view('authors.list',compact('authors' , 'uniqueAuthorsName' , 'uniqueAuthorsSurname'));
        } else
            return response()->json(['message' => 'error'],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
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
        $result = $author->update($request->all());

        if ($result) {
            $authors = Author::selectRaw('*')->toBase();
            $uniqueAuthorsSurname = $authors->get()->unique('surname')->pluck('surname');
            $uniqueAuthorsName = $authors->get()->unique('name')->pluck('name');
            $authors = $authors->paginate(15)->withQueryString();
            return response()->view('authors.list',compact('authors', 'uniqueAuthorsName', 'uniqueAuthorsSurname'));
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
        $result = $author->delete();

        if ($result) {
            $authors = Author::selectRaw('*')->toBase();
            $uniqueAuthorsSurname = $authors->get()->unique('surname')->pluck('surname');
            $uniqueAuthorsName = $authors->get()->unique('name')->pluck('name');
            $authors = $authors->paginate(15)->withQueryString();
            return response()->view('authors.list',compact('authors', 'uniqueAuthorsName', 'uniqueAuthorsSurname'));
        }
        else
            return response()->json(['message' => 'error'],500);
    }
}
