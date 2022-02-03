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
                dataType: "json",
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
});
