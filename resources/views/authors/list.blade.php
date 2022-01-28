<div id="authors_list">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Patronymic</th>
            <th scope="col">edit</th>
            <th scope="col">delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($authors as $key => $author)
            <tr>
                <th scope="row">{{ $author->id }}</th>
                <td>{{ $author->name }}</td>
                <td>{{ $author->surname }}</td>
                <td>{{ $author->patronymic }}</td>
                <td><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                <td><i class="fas fa-trash deleteButton" data-id="{{ $author->id }}" data-token="{{ @csrf_token() }}"></i></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mx-auto w-25">
        {{ $authors->links() }}
    </div>
</div>

<script>
    // delete
    $('.deleteButton').on('click', function () {
        let route = $('#form-data').data('route');
        let id = $(this).data('id');
        let token = $(this).data('token');
        $.ajax({
            url: route + '/' + id,
            method: 'delete',
            data: {
                "id": id,
                "_token": token
            },
            success: function (data) {
                $('#authors_list').replaceWith(data);
            }
        });
    })
</script>
