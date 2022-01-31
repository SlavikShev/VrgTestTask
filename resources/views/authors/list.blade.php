<div id="authors_list" class="d-flex">
    <div class="right_column d-flex flex-column mr-2">
        <div class="button">
            <button id="create" type="button" class="btn btn-primary text-nowrap m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create author
            </button>
        </div>
        <div class="filters gap-3 p-3 d-flex flex-column">
            <div class="border-bottom text-center">Filters</div>
            <div class="nameFilter border p-2">
                <div class="text-center border-bottom mb-1">Name Filter</div>
                @foreach($uniqueAuthorsName as $key => $name)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="nameFilter{{ $key }}">
                        <label class="form-check-label" for="nameFilter{{ $key }}">
                            {{ $name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="surnameFilter border p-2">
                <div class="text-center border-bottom mb-1">Surname Filter</div>
                @foreach($uniqueAuthorsSurname as $key => $name)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="surnameFilter{{ $key }}">
                        <label class="form-check-label" for="surnameFilter{{ $key }}">
                            {{ $name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-info" type="submit">Filter</button>
        </div>
    </div>
    <div class="main w-100">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Surname
                    <form action="{{ route('authors.index') }}" method="get" class="d-inline">
                        <input type="hidden" value="asc" name="surnameOrderBy">
                        <button type="submit">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                    </form>
                    <form action="{{ route('authors.index') }}" method="get" class="d-inline">
                        <input type="hidden" value="desc" name="surnameOrderBy">
                        <button type="submit">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </form>
                </th>
                <th scope="col">Patronymic</th>
                <th scope="col">edit</th>
                <th scope="col">delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($authors as $key => $author)
                <tr>
                    <th scope="row"> {{ ($authors->currentpage()-1) * $authors->perpage() + $key + 1 }}</th>
                    <td class="author_name">{{ $author->name }}</td>
                    <td class="author_surname">{{ $author->surname }}</td>
                    <td class="author_patronymic">{{ $author->patronymic }}</td>
                    <td><i class="fas fa-edit editButton" data-id="{{ $author->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                    <td><i class="fas fa-trash deleteButton" data-id="{{ $author->id }}" data-token="{{ @csrf_token() }}"></i></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mx-auto w-25">
            {{ $authors->links() }}
        </div>
    </div>
</div>

<script src="{{ asset('js/authorsList.js') }}"></script>
