$(function() {
    // save
    $('#saveButton').on('click', function () {
        if ($('#form-data').attr('data-type') === 'create') {
            let data = $('form').serialize();
            let route = $('#form-data').data('route');
            $.ajax({
                url: route,
                method: 'post',
                data: data,
                success: function (data) {
                    $('#authors_list').replaceWith(data);
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
                    $('#authors_list').replaceWith(data);
                }
            });
        }
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
    // clean form fields
    $('#create').on('click',function () {
        $('#form-data').trigger('reset');
        $('#form-data').attr('data-type', 'create');
    });
});
