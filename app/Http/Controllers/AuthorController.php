<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $authors = Author::selectRaw('*')->toBase();
        if (request()->has('surnameOrderBy')) {
            $order = request()->get('surnameOrderBy');
            $authors->orderBy('surname',$order);
        }
        $uniqueAuthorsSurname = $authors->get()->unique('surname')->pluck('surname');
        $uniqueAuthorsName = $authors->get()->unique('name')->pluck('name');

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
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        // todo add validation
        $author = Author::create($request->all());

        if ($author) {
            $authors = Author::selectRaw('*')->toBase();
            $uniqueAuthorsSurname = $authors->get()->unique('surname')->pluck('surname');
            $uniqueAuthorsName = $authors->get()->unique('name')->pluck('name');
            $authors = $authors->paginate(15)->withQueryString();
            return response()->view('authors.list',compact('authors' , 'uniqueAuthorsName' , 'uniqueAuthorsSurname'));
        }
        else
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return JsonResponse|Response
     */
    public function update(Request $request, Author $author)
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
