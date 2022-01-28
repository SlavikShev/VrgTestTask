<table class="table" id="authors_list">
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
            <th scope="row">{{ $key + 1 }}</th>
            <td>{{ $author->name }}</td>
            <td>{{ $author->surname }}</td>
            <td>{{ $author->patronymic }}</td>
            <td><i class="fas fa-edit"></i></td>
            <td><i class="fas fa-trash"></i></td>
        </tr>
    @endforeach
    </tbody>
</table>
