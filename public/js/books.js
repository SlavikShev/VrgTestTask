$(function() {
    $('#create').on('click', function () {
        $('#form-data').trigger('reset');
        $('#form-data').attr('data-type', 'create');
    });
    // save
    $('#saveButton').on('click', function () {
        if ($('#form-data').attr('data-type') === 'create') {
            let form = document.getElementById('form-data')
            let fd = new FormData(form);
            let route = $('#form-data').data('route');
            $.ajax({
                url: route,
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#books_list').replaceWith(data);
                }
            });
        }
    })
    // delete
    $('.deleteButton').on('click', function () {
        let res = confirm('are you sure?');
        if (res) {
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
                    $('#books_list').replaceWith(data);
                }
            });
        }
    });
    // edit
    $('.editButton').on('click', function () {
        // get values from table row
        let title = $(this).closest('tr').find('.title').html();
        let short_description = $(this).closest('tr').find('.short_description').html();
        let authors = $(this).closest('tr').find('.book_authors li');
        let selectedAuthors = [];
        authors.each(function() { selectedAuthors.push($(this).attr('data-id')) });
        //todo show image in modal
        // let book_cover = $(this).closest('tr').find('.book_cover').html();
        let publication_date = $(this).closest('tr').find('.publication_date').html();
        // put these values in modal fields
        $('#form-data').find('#title').val(title);
        $('#form-data').find('#shortDescription').val(short_description);
        $('#form-data').find('#book_authors').val(selectedAuthors);
        // $('#form-data').find('#bookCover').before('');
        $('#form-data').find('#publicationDate').val(publication_date);
        $('#form-data').attr('data-type', 'edit');
        $('#form-data').attr('data-id', $(this).attr('data-id'));
    });
    // update data
    $('#saveButton').on('click', function () {
        if ($('#form-data').attr('data-type') === 'edit') {
            let form = document.getElementById('form-data')
            let id = $('#form-data').attr('data-id');
            let fd = new FormData(form);
            fd.append('_method', 'PUT');
            let route = $('#form-data').data('route');
            $.ajax({
                url: route + "/" + id,
                method: "post",
                data: fd,
                contentType: false,
                processData: false,
                // todo убрать токен или из head или из формы
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    $('#books_list').replaceWith(data);
                }
            });
        }
    })
});
