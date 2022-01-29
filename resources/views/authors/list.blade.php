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

<script>
    $(function() {
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
        });
        // edit
        $('.editButton').on('click', function () {
            // fill modal fields
            let name = $(this).closest('tr').find('.author_name').html();
            let surname = $(this).closest('tr').find('.author_surname').html();
            let patronymic = $(this).closest('tr').find('.author_patronymic').html();
            $('#form-data').find('#name').val(name);
            $('#form-data').find('#surname').val(surname);
            $('#form-data').find('#patronymic').val(patronymic);
            $('#form-data').attr('data-type', 'edit');
            $('#form-data').attr('data-id', $(this).attr('data-id'));
        });
        // update data
        $('#saveButton').on('click', function () {
            if ($('#form-data').attr('data-type') === 'edit') {
                let data = $('form').serialize();
                let route = $('#form-data').data('route');
                let id = $('#form-data').attr('data-id');
                $.ajax({
                    url: route + '/' + id,
                    method: 'patch',
                    data: data,
                    success: function (data) {
                        $('#authors_list').replaceWith(data);
                    }
                });
            }
        })
    });
</script>
