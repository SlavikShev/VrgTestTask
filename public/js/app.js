$(function() {
    // clean form fields
    $('#create').on('click',function () {
        $('#form-data').trigger('reset');
    });
    // save
    $('#saveButton').on('click', function () {
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
