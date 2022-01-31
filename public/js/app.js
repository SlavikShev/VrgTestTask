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
});
