$(function() {
    $('#saveButton').on('click', function (e) {
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
    })
});
