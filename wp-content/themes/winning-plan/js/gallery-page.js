jQuery(document).ready(function ($) {

    $(document.body).on('click', '.subcategory-filter__accordion', function (event) {
        if ($(this).parent().hasClass("open")) {
            $(this).next().slideUp();
            $(this).parent().removeClass("open");
        } else {
            $(this).parent().toggleClass("open");
            $(this).next().slideToggle();
        }
        event.preventDefault();
    });

    $(document.body).on('click', '.drill-favorit', function (event) {
        event.preventDefault();
        $(this).toggleClass('added');
        const drill_id = $(this).data('id');
        let act = 'plus';
        if ($(this).hasClass('added')) {
            act = 'plus';
        } else {
            act = 'minus';
        }

        const object = {
            'security': winning_plan_ajax_object.nonce,
            'action': 'update_drill_favorit_user',
            'drill_id': drill_id,
            'act': act
        };
        const data = $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data
        });
    });

    $(document.body).on('click', '.modal-recommend__save', function (event) {
        event.preventDefault();
        $('#manager_сategory_list button').trigger('click');
    });

    $(document.body).on('click', '.modal-recommend__close', function (event) {
        event.preventDefault();
        $('.modal-recommend').remove();
    });

    $(document.body).on('submit', '#manager_сategory_list', function (event) {
        event.preventDefault();
        const object = {
            'security': winning_plan_ajax_object.nonce,
            'action': 'update_maneger_recommended'
        };
        const data = $(this).serialize() + '&' + $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function () {
                $('#manager_сategory_list').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                document.location.href = winning_plan_ajax_object.curent_url;
            }
        });
    });

    $(document.body).on('click', '.drill-divisions', function (event) {
        event.preventDefault();
        const drill_id = $(this).data('id');
        const This = $(this).closest('.gallery-drills__item');
        //$(this).toggleClass('added');
        const object = {
            'security': winning_plan_ajax_object.nonce,
            //'action': 'update_drill_divisions_user',
            'action': 'show_modal_form_maneger_recommend',
            'drill_id': drill_id,
        };
        const data = $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function () {
                This.append('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                This.find('.preloader').remove();
                $('.wrapper-personal').append(result.data.result);
            }
        });
    });

    $(document.body).on('click', '.modal-recommend__clear', function (event) {
        event.preventDefault();
        const drill_id = $(this).data('id');
        const object = {
            'security': winning_plan_ajax_object.nonce,
            'action': 'clear_maneger_recommend',
            'drill_id': drill_id,
        };
        const data = $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function () {
                $('.modal-recommend__category').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                $('.modal-recommend__category .preloader').remove();
                document.location.href = winning_plan_ajax_object.curent_url;
            }
        });
    });

    $(document.body).on('click', '#manager_сategory_list input', function (event) {
        $('.modal-recommend__presave').removeClass('m-close');
    });

    $('form#gallery-filter').on('change', 'select[name="drills_сategory"]', function (event) {
        event.preventDefault();
        const drill_id = $(this).val();
        const object = {
            'security': winning_plan_ajax_object.nonce,
            'action': 'get_drill_subcategory_checkbox_list',
            'drill_id': drill_id,
        };
        const data = $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function () {
                $('.subcategory-filter').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                if (result.data.result) {
                    $('.subcategory-filter').html(result.data.result);
                }
                $('.start-drills-filter').trigger('click');
            },
        });
    });


    $('form#gallery-filter').on('change', 'select[name="type"],select[name="goal"]', function (event) {
        event.preventDefault();
        const type = $('select[name="type"]').val();
        const goal = $('select[name="goal"]').val();
        console.log(type);
        console.log(goal);
        const object = {
            'security': winning_plan_ajax_object.nonce,
            'action': 'get_drill_subcategory_checkbox_list',
            'drill_id': 'all',
            'type' : type,
            'goal' : goal
        };
        const data = $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function () {
                $('.subcategory-filter').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                if (result.data.result) {
                    $('.subcategory-filter').html(result.data.result);
                }
                $('.start-drills-filter').trigger('click');
            },
        });
    });

    $('form#gallery-filter').on('keyup change paste', 'input, select, textarea', function () {
        if($(this).attr('name') != 'drills_сategory'){
            $('.start-drills-filter').trigger('click');
        }
    });

    $(document.body).on('click', '.advanced-filtering', function (event) {
        event.preventDefault();
        $(this).toggleClass('open');
        let text_button = '';
        if ($(this).hasClass('open')) {
            text_button = winning_plan_ajax_object.text_closure;
            $('.gallery-filter__subcategory').slideDown().css('display', 'flex');
        } else {
            $('.gallery-filter__subcategory').slideUp();
            text_button = winning_plan_ajax_object.text_advanced_filtering;
        }
        $(this).find('span').text(text_button);

    });

    $(document.body).on('click', '.subcategory-filter__reset', function (event) {
        event.preventDefault();
        $('.gallery-filter__subcategory input').each(function (i, obj) {
            $(this).prop('checked', false);
        });
        $('.start-drills-filter').trigger('click');
    });

    $(document.body).on('click', '.subcategory-filter__top input', function (event) {
        if ($(this).prop('checked')) {
            $(this).closest('.subcategory-filter__section').find('input').prop('checked', true);
        } else {
            $(this).closest('.subcategory-filter__section').find('input').prop('checked', false);
        }
    });

    $(document.body).on('click', '.subcategory-filter__head input', function (event) {
        if ($(this).prop('checked')) {
            $(this).closest('.subcategory-filter__box').find('.subcategory-filter__body input').prop('checked', true);
        } else {
            $(this).closest('.subcategory-filter__box').find('.subcategory-filter__body input').prop('checked', false);
        }
    });

    $(document.body).on('click', '.gallery-filter__subcategory input', function (event) {
        let subcategoryInput = [];
        let subcategoryInputChecked = [];
        $(this).closest('.subcategory-filter__box').find('input[name="subcategory-children[]"]').each(function (index, obj) {
            subcategoryInput.push(index);
            if ($(this).prop('checked')) {
                subcategoryInputChecked.push(index);
            }
        });
        if(subcategoryInput.length == subcategoryInputChecked.length){
            $(this).parents('.subcategory-filter__box').find('input[name="subcategory-parent[]"]').prop('checked', true);
        } else {
            $(this).parents('.subcategory-filter__box').find('input[name="subcategory-parent[]"]').prop('checked', false);
        }

        let parentСategoryInput = [];
        let parentСategoryInputChecked = [];
        $(this).closest('.subcategory-filter__section').find('input[name="subcategory-parent[]"]').each(function (index, obj) {
            parentСategoryInput.push(index);
            if ($(this).prop('checked')) {
                parentСategoryInputChecked.push(index);
            }
        });
        if(parentСategoryInput.length == parentСategoryInputChecked.length){
            $(this).parents('.subcategory-filter__section').find('input[name="headcategory[]"]').prop('checked', true);
        } else {
            $(this).parents('.subcategory-filter__section').find('input[name="headcategory[]"]').prop('checked', false)
        }

        $('.start-drills-filter').trigger('click');
    });

    $(document.body).on('click', '.gallery-filter__nav a', function (event) {
        event.preventDefault();
        $('.gallery-filter__nav a').removeClass('active');
        $(this).addClass('active');
        $('.start-drills-filter').trigger('click');
    });

    $(document.body).on('submit', '#gallery-filter', function (event) {
        event.preventDefault();
        let $current_page = $('.gallery-filter__nav .active ').data('page');
        const drill_taxonomy = $('select[name="drills_сategory"]').find(':selected').attr('data-taxonomy');

        const object = {
            'security': winning_plan_ajax_object.nonce,
            'curent_page': $current_page,
            'taxonomy_name' : drill_taxonomy
        };
        const data = $(this).serialize() + '&' + $.param(object);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: winning_plan_ajax_object.ajaxurl,
            data: data,
            beforeSend: function () {
                $('.gallery-filter__nav').remove();
                $('#drills-result-filter').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                $('#drills-result-filter').find('.preloader').remove();
                if (result.data.result) {
                    $('#drills-result-filter').html(result.data.result);
                }

                $('#all-drills-count i').text(result.data.allCount);
                $('#created-drills-count i').text(result.data.createdCount);
                $('#systems-drills-count i').text(result.data.systemsCount);
                $('#favorite-drills-count i').text(result.data.favoriteCount);

            },
            error: function (result) {

            },
        });
    });


    $(document.body).on('submit', '#add-manager-category form', function (event) {
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
            beforeSend: function () {
                $('#add-manager-category form').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                document.location.href = winning_plan_ajax_object.curent_url;
            },
            error: function (result) {

            },
        });
    });

    $(document.body).on('click', '.gallery-сategory__edit', function (event) {
        event.preventDefault();
        $(this).parents('.head').find('.сategory-edit__box').fadeToggle();
    });

    $(document.body).on('click', '.сategory-edit__box li', function (event) {
        event.preventDefault();
        const $action = $(this).data('action');
        const $term_id = $(this).parents('.gallery-сategory__item').data('term');
        const $term_title = $(this).parents('.gallery-сategory__item').data('title');
        if($action == 'edit'){
            $('#edit-manager-category input.term_name').val($term_title);
            $('#edit-manager-category input.term_id').val($term_id);
        } else {
            $('#delete-manager-category #title-manager-category').text('"'+$term_title+'"');
            $('#delete-manager-category input.term_id').val($term_id);
        }
    });

    $(document.body).on('submit', '#delete-manager-category form', function (event) {
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
            beforeSend: function () {
                $('#delete-manager-category  form').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                document.location.href = winning_plan_ajax_object.curent_url;
            },
            error: function (result) {

            },
        });
    });

    $(document.body).on('submit', '#edit-manager-category form', function (event) {
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
            beforeSend: function () {
                $('#edit-manager-category form').html('<div class="preloader"><div class="preloader-loader"></div></div>');
            },
            success: function (result) {
                document.location.href = winning_plan_ajax_object.curent_url;
            },
            error: function (result) {

            },
        });
    });
});