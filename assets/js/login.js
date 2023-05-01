$(function () {
    $('#username').on('keyup', function (evt) {
        if ($(this).val()) {
            $(this).closest('.form-group').find('.text-danger').hide();
        }
    })
    $('#password').on('keyup', function (evt) {
        if ($(this).val()) {
            $(this).closest('.form-group').find('.text-danger').hide();
        }
    })

    $('#frmLogin').on('submit', function (e) {
        e.preventDefault();
        $('#error').html('');
        var username = $('#username').val();
        var password = $('#password').val();

        if (!password) {
            $('#password').closest('.form-group').find('.text-danger').text('El password es requerido.').show();
            $('#password').focus();
        }
        if (!username) {
            $('#username').closest('.form-group').find('.text-danger').text('El usuario es requerido.').show();
            $('#username').focus();
        }
        if (!username || !password) {
            return;
        }

        var url = "/admin/login_ajax";
        var user = $('#frmLogin').serialize();
        var login = function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: user,
                dataType: 'json'
            })
                .done(function (data) {
                    console.log(data);
                    if (data.error == "") {

                        window.location.href = "/admin/panel";
                    } else {
                        $('#error').html('<b>' + data.error + '</b>');
                    }
                })
                .fail(function (jqXHR,textStatus) {
                    console.log('ERROR LOGIN');
                    console.log(jqXHR.responseText);
                })
        };
        setTimeout(login, 200);
    })
})