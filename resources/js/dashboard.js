$(function () {

    // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
        if ($(".sidebar").hasClass("toggled")) {
            $('.sidebar .collapse').collapse('hide');
        }
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function () {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide');
        }
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });

    // Scroll to top button appear
    $(document).on('scroll', function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (e) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });

    // Employees email not saving, if not changed
    let email = '',
        $form = $('#employeeForm');
    if ($form.length == 0 && $('#settingForm').length > 0) {
        $form = $('#settingForm');
    }
    if ($form.length > 0) {
        email = $('#email').val();
        $form.on('submit', function (e) {
            if ($form.find('#email').val() == email) {
                $('#email').attr({
                    name: '',
                    id: ''
                });
            }
        });
    }

    // Doc.Types
    $('#addNewField').on('click', function () {
        let $cloned = $('#initialForm').clone(true);
        let $select = $cloned.removeClass('d-none').find('select');
        initSelect2($select);
        $select.attr('name', 'fields_types[]').prop('required', true);
        $cloned.find('input').attr('name', 'fields_names[]').prop('required', true);
        $(this).parent().prev().append($cloned);
    });
    $(document).on('click', '.remove-field', function () {
        $(this).parents('li').remove();
    });
    let stepIndex = $('.steps-sequence>.form-group').length;
    $('#addNewRole').on('click', function () {
        stepIndex++;
        let $cloned = $('#initialStep').clone(true);
        let $select = $cloned.removeClass('d-none').removeAttr('id').find('select');
        // initSelect2($select);
        $select.attr('name', `approveRoles[]`).prop('required', true).removeClass('select2-hidden-accessible');
        $cloned.find('input').val(stepIndex).attr('name', `sequence[]`);
        $(this).parent().prev().append($cloned);
    });
    $(document).on('click', '.removeNewRole', function () {
        $(this).parent().remove();
    });

    // Display name autofill
    $('#display_name').on('change', function () {
        let displayName = $(this).val();
        let name = snake(displayName);
        $('#name').val(name);
    });

    // Documents
    $('#fillDocument').on('click', function () {
        let route = $(this).attr('data-route').split('%');
        route[1] = $('#docType').val();
        location.href = route.join('');
    });
    $('.approve-btn').on('click', function () {
        $(this).parent().find('input').val(1);
        $(this).parents('form').submit();
    });
    $('.reject-comment').on('click', function () {
        $(this).next().removeClass('d-none').prop('required', true);
    });
    $('.reject-btn').on('click', function () {
        $(this).parent().find('input').val(0);
        $(this).parents('form').submit();
    });

    // Teams
    $('.member-role-select').on('change', function () {
        $('#membersForm').submit()
    });

    // Profile form
    $('.profile-field-update').on('change', function () {
        $(this).parents('form').submit()
    });
    $('#addEducationBtn').on('click', function () {
        let cloned = $('#zeroEducation').clone(true);
        cloned.removeAttr('id').toggleClass('d-flex d-none');
        cloned.find('[name]:not(.date-to)').each(function () {
            $(this).prop('required', true)
        });
        $('.education-column').append(cloned);
    });
    $('.remove-education-btn').on('click', function () {
        $(this).parent().parent().remove();
    });
    $('#addExperienceBtn').on('click', function () {
        let cloned = $('#zeroExperience').clone(true);
        cloned.removeAttr('id').toggleClass('d-flex d-none');
        cloned.find('[name]:not(.date-to)').each(function () {
            $(this).prop('required', true)
        });
        $('.experience-column').append(cloned);
    });
    $('.remove-experience-btn').on('click', function () {
        $(this).parent().parent().remove();
    });
    $('#employeeProfileForm').on('submit', function () {
        $('#zeroEducation').remove();
        $('#zeroExperience').remove();
    });

    // Jobs
    $('#createJobForm').on('submit', function () {
        let emptyFieldsCount = 0;
        $('#collapseForm').find('select.form-control').each(function () {
            if ($(this).val() == '')
                emptyFieldsCount++;
        });
        if (emptyFieldsCount == 18)
            $('#with_form').prop('checked', false);
    });

    // Events
    $(document).on('click', '#select2-members-results li>strong', function (e) {
        e.preventDefault();
        let label = $(this).text();
        let $select = $('#members');
        $(this).next().find('li').attr('aria-selected', true);
        $select.find(`optgroup[label='${label}']`).find('option').prop('selected', true);
        $select.change();
    });


    // Surveys
    $(document).on('click', '#select2-employees-results li>strong', function (e) {
        e.preventDefault();
        let label = $(this).text();
        let $select = $('#employees');
        $(this).next().find('li').attr('aria-selected', true);
        $select.find(`optgroup[label='${label}']`).find('option').prop('selected', true);
        $select.change();
    });

    // Messages send by CTRL+ENTER
    $('#replyForm textarea').on('keypress', function (e) {
        if ((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)) {
            $('#replyForm').submit();
        }
    });

    // Profile image upload
    let $uploadCrop = $('#uploadPlayground').croppie({
        viewport: {
            width: 300,
            height: 300,
        },
        enableExif: true
    });
    $('#avatar').on('change', function () {
        $('#profilePicModal .modal-body').addClass('loading');
        readFile(this, $uploadCrop);
    });
    $('.apply-img').on('click', function () {
        $uploadCrop.croppie('result', {
            type: 'base64', size: {width: 500, height: 500}
        }).then(base64 => {
            let form = $('#avatarForm'),
                container = form.parent(),
                url = form.attr('action');
            container.addClass('loading');
            axios.post(url, {
                newAvatar: base64
            }).then(({data}) => {
                container.removeClass('loading');
                $('.profile-picture-lg').attr('src', data.avatar);
                $('.profile-picture').attr('src', data.avatar);
                $('.img-profile').attr('src', data.avatar);
                $('.cancel-img').click();
            }).catch(err => console.log(err))
        });
    });
    $('.cancel-img').on('click', function () {
        $('.profile-picture-lg').fadeIn();
        $('.img-actions').removeClass('top');
        $('.upload-img').fadeIn();
        $('.apply-img, .cancel-img').fadeOut(0);
        $('#uploadPlayground').fadeOut(0);
        $('#avatar').val('');
    });

    // Reports search
    $('#search').on('input', function (e) {
        e.stopPropagation();
        let search = $(this).val();
        let list = $('.results-list');
        if (search.length >= 3) {
            list.addClass('loading').slideDown();
            axios.post($(this).attr('data-url'), {search})
                .then(({data}) => {
                    list.empty();
                    for (const post of data) {
                        list.append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="${post.url}">${post.title}</a>
                                ${post.searchable.has_chart ? '<i class="fas fa-chart-pie text-primary"></i>' : ''}
                            </li>
                        `);
                    }
                    list.removeClass('loading');
                })
                .catch(error => console.log(error));
        } else {
            list.slideUp();
        }
    });
    $(document).click(function () {
        $('.results-list').slideUp();
    });

    //Surveys Questions form
    $('#questionForm #type').on('change', function () {
        let $answers = $('#questionForm #answers'),
            $rAnswers = $('#questionForm #right_answers');
        switch ($(this).val()) {
            case 'text':
                $answers.prop('disabled', true).attr('name', '').change();
                if ($rAnswers.length > 0) {
                    $answers.parent().fadeOut(0);
                    $rAnswers.parent().fadeOut(0);
                    $('#questionForm #right_answer').parent().fadeIn();
                }
                break;
            case 'range':
                $answers.prop('disabled', false).attr('name', 'answers[]').val('').change();
                if ($rAnswers.length > 0) {
                    $('#questionForm #right_answer').parent().fadeOut(0);
                    $answers.parent().fadeIn();
                    $rAnswers.parent().fadeIn();
                    $rAnswers.removeAttr('multiple').change();
                }
                break;
            default:
                $answers.prop('disabled', false).attr('name', 'answers[]').change();
                if ($rAnswers.length > 0) {
                    $('#questionForm #right_answer').parent().fadeOut(0);
                    $answers.parent().fadeIn();
                    $rAnswers.parent().fadeIn();
                    if ($(this).val() != 'checkbox') {
                        $rAnswers.removeAttr('multiple').change()
                    } else {
                        $rAnswers.attr('multiple', true).change()
                    }
                }
                break;
        }
    }).change();

    //Vacancy Applicants
    $('.status-select').on('change', function () {
        let url = $(this).attr('data-url'),
            status = $(this).val();
        $(this).parents('tr').addClass('loading');
        axios.put(url, {
            status
        }).then(({data}) => {
            $(this).val(data.instance.status).parents('tr').removeClass('loading');
            if (data.instance.status == 'pending') {
                $(this).parents('tr').removeClass().addClass('table-warning');
            } else if (data.instance.status == 'done') {
                $(this).parents('tr').removeClass().addClass('table-secondary');
            } else {
                $(this).parents('tr').removeClass('table-warning table-secondary')
            }
        }).catch(err => {
            alert(err);
        })
    });

    //Quiz questions
    // sort ordering
    let questions = [],
        $sortableQuestions = $('#sortedQuestions'),
        getSortedValues = () => {
            let sortedQuestions = $sortableQuestions.sortable('toArray'),
                sortedJSON = JSON.stringify(sortedQuestions);
            $('#questions_ordering').val(sortedJSON);
        };
    $sortableQuestions.sortable({
        placeholder: "ui-placeholder mb-4 list-group-item",
        update: getSortedValues
    });
    if ($sortableQuestions.find('li').length > 0) {
        for (const q of $sortableQuestions.sortable('toArray')) {
            questions[q] = 'exists';
        }
        getSortedValues();
    }
    $('#quizForm #questions').on('change', function () {
        $(this).find('option').each(function () {
            let questionId = $(this).attr('value');
            if ($(this).prop('selected')) {
                if (typeof questions[questionId] === 'undefined') {
                    let question = {
                        text: $(this).text().trim(),
                        questionId,
                        order: 0
                    };
                    questions[questionId] = question;
                    let questionHtml = $(`<li class="list-group-item mb-4" id="${questionId}">${question.text}</li>`);
                    $sortableQuestions.append(questionHtml);
                }
            } else {
                if (typeof questions[questionId] !== 'undefined') {
                    delete questions[questionId];
                    $(`#quizForm .sortable #${questionId}`).remove();
                }
            }
        });
        getSortedValues();
    });
    $('#questionForm #answers').on('change', function () {
        let $answers = $(this),
            $rAnswers = $('#questionForm #right_answers');
        if ($rAnswers.length > 0) {
            let type = $('#questionForm #type').val(),
                answers = $answers.val(),
                data = [],
                multiple = false;
            $rAnswers.val('').change().find('option').remove();
            switch (type) {
                case 'checkbox':
                    multiple = true;
                case 'radio':
                    for (const answer of answers) {
                        data.push({
                            id: answer,
                            text: answer
                        });
                    }
                    $rAnswers.select2({
                        data,
                        multiple
                    }).change();
                    break;
                case 'range':
                    if (answers.length == 2) {
                        for (let i = Math.min(...answers); i <= Math.max(...answers); i++) {
                            data.push({
                                id: i,
                                text: i
                            });
                        }
                        $rAnswers.select2({
                            data,
                            multiple
                        }).change();
                    }
                    break;
                default:
                    break;
            }
        }
    });

    //Redeemables
    $('.redeemable-card .redeem-button').on('click', function () {
        let card = $(this).parents('.redeemable-card').addClass('loading'),
            url = $(this).attr('data-url');

        axios.put(url, {})
            .then(({data}) => {
                $('#userPoints').text(data.user_points);
                card.removeClass('loading');
                let $alert;
                if (data.status) {
                    $alert = $('.redeem-alert-area .alert-success')
                } else {
                    $alert = $('.redeem-alert-area .alert-danger')
                }
                $alert.find('.alert-message').text(data.user_message);
                $alert.addClass('show');
                $('.redeemable-card .redeem-button').each(function () {
                    let price = +$(this).text().split(' ')[0];
                    if (price > +data.user_points) {
                        $(this).prop('disabled', true).parents('.redeemable-card').addClass('loading');
                    }
                });
                setTimeout(() => {
                    $alert.removeClass('show')
                }, 5000)
            })
            .catch(err => {
                console.error(err);
                let $alert = $('.redeem-alert-area .alert-danger');
                $alert.find('.alert-message').text('Something went wrong. Reload page and try again.');
                $alert.addClass('show');
                setTimeout(() => {
                    $alert.removeClass('show')
                }, 5000)
            })
    })
});
