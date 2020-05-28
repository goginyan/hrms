window.initSelect2 = $el => {
    $el.select2({
        placeholder: $(this).attr('data-placeholder'),
        width: $(this).attr('data-width') || '15%'
    });
};

window.prepareCroppie = (url, croppie) => {
    $('.profile-picture-lg').fadeOut(0);
    $('.img-actions').addClass('top');
    $('.upload-img').fadeOut(0);
    $('.apply-img, .cancel-img').fadeIn();
    $('#uploadPlayground').fadeIn();
    croppie.croppie('bind', {
        url
    }).then(() => {
        $('#profilePicModal .modal-body').removeClass('loading');
    });
};

window.readFile = (input, croppie) => {
    if (input.files && input.files[0]) {
        if (typeof FileReader !== "undefined") {
            let reader = new FileReader();
            reader.onload = e => {
                prepareCroppie(e.target.result, croppie)
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            let form = $(input).parent(),
                url = form.attr('action'),
                data = new FormData(),
                image = input.files[0];
            data.append('avatar', image, image.name);
            axios.post(url, data).then(({data}) => {
                prepareCroppie(data.avatar, croppie);
            }).catch(err => console.log(err))
        }
    }
};

window.animateCSS = (element, animationName, callback, speed = '1s') => {
    const node = document.querySelector(element);
    node.classList.add('animated', animationName, speed);

    function handleAnimationEnd() {
        node.classList.remove('animated', animationName, speed);
        node.removeEventListener('animationend', handleAnimationEnd);

        if (typeof callback === 'function') callback()
    }

    node.addEventListener('animationend', handleAnimationEnd)
};

$(function () {
    // Libraries applying
    $(".custom-file-input").on("change", function () {
        let fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('.custom-select').not('.dataTables_length .custom-select').each(function () {
        initSelect2($(this))
    });

    $('.tags-select').each(function () {
        $(this).select2({
            placeholder: $(this).attr('data-placeholder'),
            width: '100%',
            tags: true,
            tokenSeparators: [','],
            insertTag(data, tag) {
                // Insert the tag at the end of the results
                data.push(tag);
            }
        })
    });

    $(".sortable").sortable({
        placeholder: "ui-placeholder mb-4 list-group-item"
    });

    $('.roles-list [data-toggle="popover"]').popover({
        html: true,
        content() {
            return $(this).siblings('.permsList').html();
        }
    });
    $('[data-toggle="tooltip"], input[type="range"]').tooltip();
    $('input[type="range"]').on('input change', function () {
        let el = $(this), minValue, maxValue;
        if (!el.attr("min")) {
            minValue = 0;
        } else {
            minValue = el.attr("min");
        }
        if (!el.attr("max")) {
            maxValue = 100;
        } else {
            maxValue = el.attr("max");
        }
        let width = el.width(),
            point = width / (maxValue - minValue),
            left = (el.val() - minValue) * point;
        el.next("output")
            .css({
                left
            })
            .text(el.val());
    }).change();

    $('[type=tel]').each(function () {
        intlTelInput($(this)[0]);
    });
    let itiInputs = [];
    $('.iti-input').each(function () {
        let i = itiInputs.length;
        itiInputs[i] = intlTelInput($(this)[0], {
            utilsScript: '/js/utils.js',
            autoHideDialCode: false,
            separateDialCode: true,
        });
        $(this).on('change', function () {
            $('#' + $(this).attr('data-target')).val(itiInputs[i].getNumber());
        })
    });

    $('[data-type=date]').each(function () {
        let disable = $(this).attr('data-weekend') == 'false' ? [
            function (date) {
                // return true to disable
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ] : [];
        flatpickr($(this)[0], {
            // defaultDate: 'today',
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: $(this).attr('data-min-date') || '',
            time_24hr: true,
            disable,
            locale: {
                firstDayOfWeek: 1
            }
        })
    });
    $('[data-type=datetime]').each(function () {
        let disable = $(this).attr('data-weekend') == 'false' ? [
            function (date) {
                // return true to disable
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ] : [];
        flatpickr($(this)[0], {
            // defaultDate: 'today',
            enableTime: true,
            altInput: true,
            altFormat: "H:i d.m.Y",
            dateFormat: "Y-m-d H:i:ss",
            minDate: $(this).attr('data-min-date') || '',
            disable,
            time_24hr: true,
            locale: {
                firstDayOfWeek: 1
            },
        });
    });
    $('[data-type=daterange]').each(function () {
        let defaultDate = $(this).attr('data-default-range') ? $(this).attr('data-default-range').split(',') : '';
        flatpickr($(this)[0], {
            mode: "range",
            dateFormat: "Y-m-d",
            altFormat: "d.m.Y",
            altInput: true,
            defaultDate,
            minDate: $(this).attr('data-min-date') || '',
            locale: {
                firstDayOfWeek: 1
            }
        })
    });

    //Select All functional
    $('.select-all').on('change', function () {
        let $select = $(this).parents('.form-group').find('select.custom-select');
        $select.find('option').prop('selected', $(this).prop('checked'));
        $select.change();
    }).parents('.form-group').find('select.custom-select').on('change', function () {
        let all = $(this).find('option');
        let selected = 0;
        all.each(function () {
            selected = $(this).prop('selected') ? selected + 1 : selected;
        });
        $(this).parents('.form-group').find('.select-all').prop('checked', selected == all.length);
    }).change();
});