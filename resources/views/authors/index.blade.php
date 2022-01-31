@extends('layouts.main')

@section('title', 'Authors')

@section('content')

    {{--  move modal to balde and pass there form html and rename example fields  --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-data" data-route="{{ route('authors.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input name="surname" type="text" class="form-control" id="surname">
                        </div>
                        <div class="mb-3">
                            <label for="patronymic" class="form-label">Patronymic</label>
                            <input name="patronymic" type="text" class="form-control" id="patronymic">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="saveButton" type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    @include('authors.list')
@endsection
