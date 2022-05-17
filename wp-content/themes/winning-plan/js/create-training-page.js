jQuery(document).ready(function ($) {
    accordionsSectionEdit();
    accordionsSectionCreate();
    accordion();
    tabs();

    firstStep();
    secondStep();
    thirdStep();
    saveSession();

    leavePage();

    function accordionsSectionEdit() {
        $(document).on("click", ".create-training-page .accordion .edit button", function (event) {
            event.preventDefault();
            let step = $(this).attr("data-step");
            $(".create-training-page").attr("data-step", step);
            $(".create-training-page .accordion").removeClass("active");
            if (step == 1) {
                $(this).closest('.accordion').addClass("active");
                $(this).closest('.accordion').find('.create').show();
                $(this).closest('.accordion').find('.edit').hide();
            }
            if (step == 2) {
                $(this).closest('.accordion').removeClass('preview')
            }
        });
    }

    function accordionsSectionCreate(status = "") {
        let currentStep = $(".create-training-page").attr("data-step");
        console.log('currentStep', currentStep);
        $(".create-training-page .accordion").removeClass("active");
        $(".create-training-page .accordion").each(function (index, element) {
            let currentIndex = index + 1;
            if (currentStep == 0 && currentIndex == 1) {
                $(element).find(".create").show();
                $(element).css("opacity", "1");
                $(element).addClass("active");
            } else if (currentIndex == currentStep) {
                $(element).addClass("active");
                $(element).css("opacity", "1");

                if (status == "create") {
                    $(element).find(".edit").hide();
                    $(element).find(".create").show();
                } else {
                    $(element).find(".edit").show();
                }
            } else if (currentIndex <= currentStep) {
                if ($(element).find(".edit").length != 0) {
                    $(element).find(".edit").show();
                    $(element).find(".create").hide();
                }

                if (currentIndex == 2) {
                    $(element).find(".create").hide();
                    $(element).addClass('preview');
                }

                $(element)
                    .find(".header")
                    .off("click")
                    .click(function (event) {
                        event.preventDefault();
                        //if ($(this).closest(".accordion").find(".create").length && $(element).closest(".accordion").find(".create").css("display") == "block") {
                        if ($(this).closest(".accordion").hasClass("active")) {
                            $(this).closest(".accordion").removeClass("active");
                        } else {
                            $(this).closest(".accordion").addClass("active");
                        }
                        //}
                    });
            } else {
                $(element).css("opacity", "0.5");
                $(element).find(".edit").hide();
                $(element).find(".create").show();
            }
        });
    }

    function accordion() {
        /*$(document).on("click", ".create-training-page .accordion .header", function (event) {
          event.preventDefault();
          if ($(this).find(".arrow").length !== 0) {
            if ($(this).parent().hasClass("close")) {
              $(this).next().slideToggle("fast");
              $(this).parent().removeClass("close");
            } else {
              $(this).parent().toggleClass("close");
              $(this).next().slideToggle("fast");
            }
          }
        });*/

        $(document).on("click", ".session-box__head", function (event) {
            event.preventDefault();
            if ($(this).find(".arrow").length !== 0) {
                if ($(this).parent().hasClass("close")) {
                    $(this).next().slideToggle("fast");
                    $(this).parent().removeClass("close");
                } else {
                    $(this).parent().toggleClass("close");
                    $(this).next().slideToggle("fast");
                }
            }
        });
    }

    function tabs() {
        $(".tabs .tab").click(function (event) {
            event.preventDefault();
            const index = $(this).index();
            console.log(index);
            $(this).closest(".tabs").find(".tab").removeClass("active");
            $(this).closest(".tabs").find(".tab-content").removeClass("active");
            $(this).addClass("active");
            $(this)
                .closest(".tabs")
                .find(".tab-content:eq(" + index + ")")
                .addClass("active");
        });
    }

    function firstStep() {
        $(".create-training-page .first-step .types .radio input").change(function () {
            const type = $(this).val();
            const data = {
                security: winning_plan_ajax_object.nonce,
                action: "first_step_filter_type",
                type: type,
                user_id: winning_plan_ajax_object.current_user_id,
                post_id: $(".create-training-page").data("post-id"),
                step: $(this).find("button[type='submit']").data("step") + 1,
            };

            $.ajax({
                url: winning_plan_ajax_object.ajaxurl,
                type: "POST",
                data: data,
                beforeSend: function () {
                },
                success: function (response) {
                    $(".goals .checkbox-group").html(response);
                },
            });
        });

        $(".create-training-page #form-first-step").submit(function (event) {
            event.preventDefault();
            const trainingId = $("body").find(".create-training-page").data("post-id");
            const object = {
                security: winning_plan_ajax_object.nonce,
                action: "update_post_training",
                user_id: winning_plan_ajax_object.current_user_id,
                training_id: trainingId,
            };
            const data = $(this).serialize() + "&" + $.param(object);

            $.ajax({
                url: winning_plan_ajax_object.ajaxurl,
                type: "POST",
                data: data,
                beforeSend: function () {
                    $(".create-training-page .first-step .create").append('<div class="preloader"><div class="preloader-loader"></div></div>');
                },
                success: function (response) {
                    $(".preloader").remove();
                    $("body").find(".create-training-page").attr("data-post-id", response.data.training_id);
                    $("body").find(".create-training-page").attr("data-step", response.data.step);
                    window.history.replaceState(null, null, `?edit_id=${response.data.training_id}`);
                    if (response.data.result) {
                        $("#result-session-boxes").html(response.data.result);
                    }
                    accordionsSectionCreate();
                },
            });
        });
    }

    function secondStep() {
        function fancyTimeFormat(time) {
            // Hours, minutes and seconds
            let hrs = ~~(time / 3600);
            let mins = ~~((time % 3600) / 60);
            let secs = time % 60;
            // Output like "1:01" or "4:03:59" or "123:03:59"
            let ret = "";

            if (hrs > 0) {
                ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
            }

            ret += "" + mins + ":" + (secs < 10 ? "0" : "");
            ret += "" + secs;
            return ret;
        }

        function hmsToSecondsOnly(str) {
            let p = str.split(":"),
                s = 0,
                m = 1;
            while (p.length > 0) {
                s += m * parseInt(p.pop(), 10);
                m *= 60;
            }
            return s;
        }

        function SessionUpdateBoxes(actionSession = "") {
            let dataSessionBoxes = [];
            $(".session-box").each(function (i, sessionBox) {
                const number = $(sessionBox).data("number");
                let dataDrillBox = [];
                $(this)
                    .find(".session-box__drill")
                    .each(function (index, drillBox) {
                        const order = $(drillBox).data("order");
                        const duration = $(drillBox).find(".drill-duration .current").text();
                        const drillId = $(drillBox).data("id");
                        let dataDrill = {
                            number,
                            drillId,
                            duration,
                        };
                        dataDrillBox.push(dataDrill);
                    });
                dataSessionBoxes.push(dataDrillBox);
            });
            console.log("dataSessionBoxes", dataSessionBoxes);
            console.log("actionSession", actionSession);

            const trainingId = $("body").find(".create-training-page").data("post-id");
            const object = {
                security: winning_plan_ajax_object.nonce,
                action: "update_session_boxes",
                user_id: winning_plan_ajax_object.current_user_id,
                training_id: trainingId,
                sessionBoxes: dataSessionBoxes,
                actionSession: actionSession,
            };
            const data = $(this).serialize() + "&" + $.param(object);
            $.ajax({
                url: winning_plan_ajax_object.ajaxurl,
                type: "POST",
                data: data,
                beforeSend: function () {
                    if (actionSession == "sort" || actionSession == "trash") {
                    } else {
                        $(".create-training-page .second-step .content").append('<div class="preloader"><div class="preloader-loader"></div></div>');
                    }
                },
                success: function (response) {
                    $(".preloader").remove();
                    if (response.data.result) {
                        $("#result-session-boxes").html(response.data.result);
                    }
                    if (response.data.step) {
                        console.log(response.data.step);
                        $("body").find(".create-training-page").attr("data-step", response.data.step);
                        accordionsSectionCreate();
                    }
                },
            });
        }

        $(document).on("click", ".session-box__drill .order span", function (event) {
            event.preventDefault();
            const guide = $(this).data("guide");
            const parent = $(this).closest(".session-box__drill");
            const parentSession = $(this).closest(".session-box");
            const order = parseInt(parent.data("order"));
            $(".session-box__drill").removeClass("order");
            if (guide == "up") {
                parent.prev().before(parent);
            } else {
                parent.next().after(parent);
            }
            parentSession.find(".session-box__drill").each(function (index) {
                const drillBox = $(this);
                if (drillBox.prevAll(".session-box__drill").length !== 0) {
                    drillBox.addClass("order");
                }
            });
            SessionUpdateBoxes("sort");
        });

        $(document).on("click", ".session-box__drill .trash", function (event) {
            event.preventDefault();
            const parent = $(this).closest(".session-box__drill");
            parent.slideDown();
            parent.remove();
            SessionUpdateBoxes("trash");
        });

        $(document).on("click", ".second-step .session-box__add a", function (event) {
            event.preventDefault();
        });

        $(document).on("click", ".second-step .save a", function (event) {
            event.preventDefault();
            SessionUpdateBoxes("save");
        });

        $(document).on("click", ".second-step .preview .btn-transparent", function (event) {
            event.preventDefault();
            SessionUpdateBoxes("edit");
        });

        $(document).on("click", ".second-step .session-box .adding", function (event) {
            event.preventDefault();
        });

        $(document).on("change", ".second-step .session-box .drill-duration select", function (event) {
            event.preventDefault();
            let durationTotalSecond = 0;
            $(".session-box").each(function (i, sessionBox) {
                let durationSesionBoxSecond = 0;
                $(this)
                    .find(".session-box__drill")
                    .each(function (index, drillBox) {
                        const duration = $(drillBox).find(".drill-duration .current").text();
                        durationSesionBoxSecond = durationSesionBoxSecond + hmsToSecondsOnly(duration);
                    });
                $(sessionBox).find(".session-box__head .duration span").text(fancyTimeFormat(durationSesionBoxSecond));
                durationTotalSecond = durationTotalSecond + durationSesionBoxSecond;
            });
            $(".session-box__total .duration span").text(fancyTimeFormat(durationTotalSecond));
            SessionUpdateBoxes("sort");
        });

        $(".timepicker").timepicker({
            timeFormat: "h:mm p",
            interval: 10,
            minTime: "10",
            maxTime: "06:00pm",
            //defaultTime: '11',
            startTime: "09:00",
            dynamic: false,
            dropdown: true,
            scrollbar: true,
        });

        $("#date-session").datepicker();
    }

    function thirdStep() {
        console.log("thirdStep");
    }

    function saveSession() {
        $(".create-training-page .accordions .save button").click(function (event) {
            event.preventDefault();
            const trainingId = $("body").find(".create-training-page").data("post-id");
            const dataSession = $("body").find("#date-session").val();
            const timeSession = $("body").find("#time-session").val();
            let playersSession = false;
            if ($("#players-session").is(":checked")) {
                playersSession = true;
            }

            const object = {
                security: winning_plan_ajax_object.nonce,
                action: "update_session_construction_info",
                user_id: winning_plan_ajax_object.current_user_id,
                training_id: trainingId,
                data: dataSession,
                time: timeSession,
                players: playersSession,
            };
            const data = $(this).serialize() + "&" + $.param(object);

            $.ajax({
                url: winning_plan_ajax_object.ajaxurl,
                type: "POST",
                data: data,
                beforeSend: function () {
                    $(".create-training-page .accordions").append('<div class="preloader"><div class="preloader-loader"></div></div>');
                },
                success: function (response) {
                    $(".preloader").remove();
                },
            });
        });
    }


    function leavePage() {
        $(document).mousemove(function (e) {
            const top = $(window).scrollTop();
            if (e.pageY - 10 <= top) {
                $('#page-exit').show();
            }
        });

        $(window).keydown(function (event) {
            event.preventDefault();
            if (event.keyCode == 116) {
                $('#page-exit').show();
            }
        });

        $(document).on("click", "a", function (event) {
            event.preventDefault();
            const href = $(this).attr('href');

            $('#page-exit').find('a.exit').attr('href', href);
            $('#page-exit').find('a.save').attr('href', href);

            if ($(this).closest('.modal').length == 0) {
                if (window.location.href != href && href != '#') {
                    $('#page-exit').show();
                }
            }

            if ($(this).hasClass('save')) {
                event.preventDefault();
                let activeAccordion = $('.wrapper-personal').find('.accordions .accordion.active');
                console.log('page', activeAccordion.closest('.create-training-page').length);
                console.log('third-step', activeAccordion.closest('.third-step').length);
                if (activeAccordion.closest('.create-training-page').length == 1) {
                    if (activeAccordion.closest('.third-step').length == 1) {
                        $(document).find('.save .trigger-save').trigger('click');
                    } else {
                        activeAccordion.find('.trigger-save').trigger('click');
                    }
                }

                if (activeAccordion.closest('.create-drill-page').length == 1) {
                    if (activeAccordion.closest('.fouth-step').length == 1) {
                        $(document).find('.save .trigger-save').trigger('click');
                    } else {
                        activeAccordion.find('.trigger-save').trigger('click');
                    }
                }
                $('#page-exit').hide();
                $(document).ajaxComplete(function () {
                    document.location.href = href;
                });
            }
            if ($(this).hasClass('exit')) {
                document.location.href = href;
            }
            if ($(this).hasClass('back')) {
                $('#page-exit').hide();
            }
        });
    }
});
