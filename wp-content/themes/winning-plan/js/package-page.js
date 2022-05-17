jQuery(document).ready(function($) {
    $(document.body).on('click', '.show-list_advantages', function(event) {
        event.preventDefault();
        $(this).prev('.routes-list_advantages').find('.description').slideDown();
        $(this).prev('.routes-list_advantages').addClass('open');
        $(this).slideUp();
    });


    $(document.body).on('click', '.btn-add-group', function(event) {
        event.preventDefault();
        let template_group = $('.template-buy-group').clone();
        $(this).before(template_group.show().removeClass('template-buy-group'));

        $('.buy-package__groups').find('.buy-groups__name').each(function(index, value) {
            $(this).find('input').attr('name', 'groups[' + index + '][title]');
        });

        $('.buy-package__groups').find('.buy-groups__players').each(function(index, value) {
            $(this).find('input').attr('name', 'groups[' + index + '][players]');
        });
    });

    $(document.body).on('click', '.buy-groups__delete', function(event) {
        event.preventDefault();
        $(this).parents('.buy-groups__box').hide().remove();
    });

    function calc_cost_package() {
        let count_players = parseInt($('#coach-players').val());
        const package_cost = parseInt($('#package-cost').val());
        $('.msg-players').text(count_players + 1);
        $('#calc-coach-players').text(count_players * package_cost);
        $('#calc-coach-cost-total').text((count_players * package_cost) + package_cost);
        $('.msg-cost-total').text((count_players * package_cost) + package_cost);
        $('#calc-coach-cost-total-input').val((count_players * package_cost) + package_cost);
    }

    $(document.body).on('click', '.plus-players', function(event) {
        event.preventDefault();
        let curent_players = parseInt($(this).parents('span').find('input').val());
        $(this).parents('span').find('input').val(curent_players + 1);
        calc_cost_package();
    });

    $(document.body).on('click', '.minus-players', function(event) {
        event.preventDefault();
        let curent_players = parseInt($(this).parents('span').find('input').val());
        if (curent_players > 20) {
            $(this).parents('span').find('input').val(curent_players - 1);
        }
        calc_cost_package();
    });

    $(document.body).on('submit', '#buy-package', function(event) {
        event.preventDefault();
        const object = {
            'security': winning_plan_ajax_object.nonce,
        };
        const data = $(this).serialize() + '&' + $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function() {
                $('#buy-package').append('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function(result) {
                $('#buy-package').find('.preloader').remove();
                if (result.data.error) {
                    if (result.data.error == 'useremail') {
                        $('#' + result.data.error).addClass('error');
                        $('.status-email').addClass('error');
                        $('.status-email').text(result.data.message);
                    }
                }
                if (result.data.html_result) {
                    $('#buy-package').html(result.data.html_result);
                }
            },
            error: function(result) {
                $('#buy-package').find('.preloader').remove();
            },
        });
    });
});