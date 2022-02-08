@extends('layouts.main')

@section('title', 'Authors')

@section('modal')
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
@endsection

@section('table')
    @include('authors.list')
@endsection
