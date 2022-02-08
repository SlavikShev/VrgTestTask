@extends('layouts.main')

@section('title', 'Authors')

@section('modal')
    <form id="form-data" data-route="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="title">
        </div>
        <div class="mb-3">
            <label for="shortDescription" class="form-label">Short Description</label>
            <textarea class="form-control" id="shortDescription" name="short_description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="bookCover" class="form-label">Book cover</label>
            <input class="form-control" type="file" id="bookCover" name="bookCover" accept=".jpg,.png">
        </div>
{{--                        todo move select in modal window for convenience--}}
        <div class="mb-3">
            <select class="form-select" multiple aria-label="multiple select example" id="book_authors" name="book_authors[]">
{{--                                todo accessor for author model to return name and surname}}--}}
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="publicationDate" class="form-label">Publication date</label>
            <input class="form-control" type="date" id="publication_date" name="publication_date">
        </div>
    </form>
@endsection

@section('table')
    @include('books.list')
@endsection
