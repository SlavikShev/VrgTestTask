@extends('layouts.main')

@section('title', 'Authors')

@section('content')
    <button id="create" type="button" class="btn btn-primary text-nowrap m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create book
    </button>
    {{--  move modal to balde and pass there form html and rename example fields  --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <input class="form-control" type="file" id="bookCover" name="bookCover" accept="image/x-png,image/gif,image/jpeg">
                        </div>
{{--                        todo move select in modal window for convenience--}}
                        <div class="mb-3">
                            <select class="form-select" multiple aria-label="multiple select example">
{{--                                todo accessor for author model to return name and surname}}--}}
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="publicationDate" class="form-label">Publication date</label>
                            <input class="form-control" type="date" id="publicationDate" name="publication_date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="saveButton" type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/books.js') }}"></script>
@endsection
