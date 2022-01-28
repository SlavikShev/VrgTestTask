$(function() {
    $('#saveButton').on('click', function (e) {
        let data = $('form').serialize();
        let route = $('#form-data').data('route');
        console.log(data);
        $.ajax({
            url: route,
            method: 'post',
            data: data,
            success: function (data) {
                alert(data);
            }
        });
    })
});
