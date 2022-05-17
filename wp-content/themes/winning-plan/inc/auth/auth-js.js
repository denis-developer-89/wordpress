jQuery(document).ready(function ($) {

    $(document.body).on('click', '.show-password', function (event) {
        event.preventDefault();
        $(this).toggleClass("open");
        if ($(this).hasClass("open")) {
            $(this).prev().attr('type', 'text');
        } else {
            $(this).prev().attr('type', 'password');
        }
    });

    $(document.body).on('click', '.send-new-code', function (event) {
        event.preventDefault();
        $('#code-resending').val('true');
        $('.auth__login-step-1').find('button').trigger('click');
        $('.status').addClass('resending');
    });

    $(document.body).on('submit', '#auth__login', function (event) {
        event.preventDefault();
        //$('.auth__login .status').show().text(winning_plan_ajax_object.loadingmessage);
        const object = {
            'action': 'action_auth_ajax_login',
            'security': winning_plan_ajax_object.nonce,
        };
        const data = $(this).serialize() + '&' + $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,

            beforeSend: function () {
                $('.auth__login-step-1').hide();
                $('.auth__login-step-2').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                $('.preloader').remove();
                $('.error').removeClass('error');

                if (result.data.step_2) {
                    $('.auth__login-step-2').html(result.data.step_2);
                }

                if (result.data.error) {
                    if(result.data.error == 'auth_code'){
                        $('.auth__login-code span').addClass('error');
                        $('.status.code').addClass('error');
                    } else {
                        $('.auth__login-step-1').show();
                        $('#'+ result.data.error).addClass('error');
                        $('.status').addClass('error');
                    }
                }

                if ($('.status').hasClass('resending')) {
                    $('.status').removeClass('resending');
                } else {
                    $('.auth__login .status').text(result.data.message);
                }

                if (result.data.status == true) {
                    $('.status.code').removeClass('error');
                    $('.status.code').addClass('success');
                    document.location.href = winning_plan_ajax_object.curent_url;
                }

                $('#code-resending').val('false');
            }
        });
    });

    $(document.body).on('submit', '#auth__register', function (event) {
        event.preventDefault();
        $('.auth__register .status').show().text(winning_plan_ajax_object.loadingmessage);
        const object = {
            'action': 'action_auth_ajax_register',
            'security': winning_plan_ajax_object.nonce,
        };
        const data = $(this).serialize() + '&' + $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            success: function (result) {
                $('.auth__register .status').text(result.data.message);
                if (result.data.status == true) {
                    document.location.href = winning_plan_ajax_object.home_url;
                }
            }
        });
    });

    $(document.body).on('submit', '#auth__forgot', function (event) {
        event.preventDefault();
        $('.auth__forgot .status').show().text(winning_plan_ajax_object.loadingmessage);
        const object = {
            'action': 'action_auth_ajax_forgot',
            'security': winning_plan_ajax_object.nonce,
        };
        const data = $(this).serialize() + '&' + $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            success: function (result) {
                $('.auth__forgot .status').text(result.data.message);
                if (result.data.status == true) {
                    document.location.href = winning_plan_ajax_object.home_url;
                }
            }
        });
    });

});