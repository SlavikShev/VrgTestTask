$(function() {

    alert('hello')
    $.ajax({
        url: '/authors',         /* Куда пойдет запрос */
        method: 'post',             /* Метод передачи (post или get) */
        dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
        data: {text: 'Текст'},     /* Параметры передаваемые в запросе. */
        success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
            alert(data);            /* В переменной data содержится ответ от index.php. */
        }
    });
});
