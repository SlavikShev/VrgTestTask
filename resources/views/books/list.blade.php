<div id="books_list" class="d-flex">
    <div class="right_column d-flex flex-column mr-2">
        <div class="button">
            <button id="create" type="button" class="btn btn-primary text-nowrap m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create book
            </button>
        </div>
        <form action="{{ route('books.index') }}" class="filters gap-3 p-3 d-flex flex-column">
            <div class="border-bottom text-center">Filters</div>
            {{--            todo сделать кнопу выбрать всё и сняты выделение со всех--}}
            @include('partials.filter',['filter' => $booksTitleList, 'title' => 'Book title Filter', 'inputName' => 'bookTitle'])
            @include('partials.filter',['filter' => $booksAuthorsList, 'title' => 'Authors Filter', 'inputName' => 'bookAuthor','custom_id' => true])
            <button class="btn btn-info" type="submit">Filter</button>
        </form>
    </div>
    <div class="main w-100">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title
                    {{--todo возможно переделать на link вместо формы--}}
                    <form action="{{ route('books.index') }}" method="get" class="d-inline">
                        <input type="hidden" value="asc" name="titleOrderBy">
                        <button type="submit">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                    </form>
                    <form action="{{ route('books.index') }}" method="get" class="d-inline">
                        <input type="hidden" value="desc" name="titleOrderBy">
                        <button type="submit">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </form>
                </th>
                <th scope="col">Short Description
                </th>
                <th scope="col">Authors</th>
                <th scope="col">Book Cover</th>
                <th scope="col">Publication date</th>
                <th scope="col">edit</th>
                <th scope="col">delete</th>
            </tr>
            </thead>
            <tbody class="align-middle">
            @foreach($books as $key => $book)
                <tr>
                    <th scope="row"> {{ ($books->currentpage()-1) * $books->perpage() + $key + 1 }}</th>
                    <td class="title">{{ $book->title }}</td>
{{--                    todo limit to first 50 chars and on click show entire description--}}
                    <td class="short_description">{{ $book->short_description }}</td>
                    <td>
                        <ul class="book_authors">
                            @foreach($book->authors as $book_author)
                                <li data-id="{{ $book_author->id }}">{{ $book_author->full_name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="book_cover">
                        @if($book->image)
                            <img src="{{ asset('book_covers/'.$book->image) }}" style="width: 60px;">
                        @endif
                    </td>
                    <td class="publication_date">{{ $book->publication_date }}</td>
                    {{--todo rename example model to more appropriate name--}}
                    <td><i class="fas fa-edit editButton" data-id="{{ $book->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                    {{--                    todo remove token from data attribute and take it from mata tag in title--}}
                    <td><i class="fas fa-trash deleteButton" data-id="{{ $book->id }}" data-token="{{ @csrf_token() }}"></i></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mx-auto w-25">
            {{ $books->links() }}
        </div>
    </div>
    <script src="{{ asset('js/books.js') }}"></script>
</div>
