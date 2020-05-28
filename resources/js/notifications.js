// window.notifications = [];
const NOTIFICATION_TYPES = {
    task: {
        attached: 'App\\Notifications\\TaskAttached',
        updated: 'App\\Notifications\\TaskUpdated',
    },
    team: {
        included: 'App\\Notifications\\TeamIncluded',
        updated: 'App\\Notifications\\TeamUpdated',
    },
    event: {
        created: 'App\\Notifications\\EventCreated',
        updated: 'App\\Notifications\\EventUpdated',
    },
    document: {
        received: 'App\\Notifications\\DocumentReceived',
        approved: 'App\\Notifications\\DocumentApproved',
        rejected: 'App\\Notifications\\DocumentRejected',
    },
    interview: {
        planned: 'App\\Notifications\\InterviewPlanned',
        ended: 'App\\Notifications\\InterviewEnded',
        feedbackReady: 'App\\Notifications\\InterviewFeedbackReady',
    },
    vacancy: 'App\\Notifications\\VacancyPublished',
    post: 'App\\Notifications\\PostPublished',
    survey: 'App\\Notifications\\SurveyAttached',
    quiz: {
        attached: 'App\\Notifications\\QuizAttached',
        passed: 'App\\Notifications\\QuizPassed'
    },
    timeOff: 'App\\Notifications\\TimeOffApproved',
    message: 'App\\Notifications\\MessageReceived',
};

function addNotification(newNotification) {
    switch (newNotification.type) {
        case NOTIFICATION_TYPES.message:
            showMessage(newNotification);
            break;
        default:
            showNotification(newNotification);
            break;
    }
}

function showNotification(notification) {
    let counter = $('#alertsDropdown span.badge'),
        unreadCount = +counter.text() || 0;
    if (notification) {
        unreadCount++;
        let html = makeNotification(notification);
        $('#noNotifications').remove();
        $(html).insertAfter($('#notificationsBlock .dropdown-header'));
        if (unreadCount > 0) counter.show("scale").text(unreadCount);
    }
}

function showMessage(notification) {
    let counter = $('#messagesDropdown span.badge'),
        unreadCount = +counter.text() || 0,
        notificationsBlock = $('#messagesBlock');
    if (notification) {
        count = $(`.notification[data-thread='${notification.thread_id}']`).find('.mark-as-read.badge-primary').length;
        unreadCount += count > 0 ? 0 : 1;
        notificationsBlock.find(`.notification[data-thread='${notification.thread_id}']`).remove();
        let html = makeMessage(notification);
        $('#noMessages').remove();
        $(html).insertAfter($('#messagesBlock .dropdown-header'));
        if (unreadCount > 0) counter.show("scale").text(unreadCount);
    }
}

function getDiffForHumans(date) {
    const offSet = 0; // new Date().getTimezoneOffset() * 60 * 1000;
    let diff = humanizeDuration(Date.now() + offSet - Number(new Date(date)), {largest: 1, round: true});

    return diff == '0 seconds' ? 'just now' : diff + ' ago'
}

// Make a single notification string
function makeNotification(notification) {
    let diffForHumans = getDiffForHumans(notification.created_at),
        url = notification.url;
    return `<div class="dropdown-item d-flex align-items-center notification" data-id="${notification.id}">
                     <div class="mr-3">
                         <div class="icon-circle bg-${notification.color}">
                             <i class="${notification.icon} text-white"></i>
                         </div>
                     </div>
                     <a href="${url}">
                         <div class="small text-gray-500">
                             ${notification.title} · ${diffForHumans}
                         </div>
                         <span class="${notification.read_at ? "" : "font-weight-bold"}">
                             ${notification.text}
                         </span>
                     </a>
                     <span class="ml-3 badge mark-as-read badge-${notification.read_at ? "light" : "primary"}"></span>
                 </div>`;
}

// Make a single message string
function makeMessage(notification) {
    let diffForHumans = getDiffForHumans(notification.created_at),
        url = notification.url;
    return `<div class="dropdown-item d-flex align-items-center notification" data-thread="${notification.thread_id}" data-id="${notification.id}">
                     <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="${notification.sender.avatar ? notification.sender.avatar : '/images/no_avatar.jpg'}" alt="">
                     </div>
                     <a href="${url}" class="${notification.read_at ? "" : "font-weight-bold"}">
                        <div class="text-truncate">
                           ${notification.text}
                        </div>
                        <div class="small text-gray-500">
                            ${notification.sender.name} · ${diffForHumans}
                        </div>
                     </a>
                     <span class="ml-3 badge mark-as-read badge-${notification.read_at ? "light" : "primary"}"></span>
                 </div>`;
}

function popUpNotification(notification) {
    let html = notification.type == NOTIFICATION_TYPES.message ? makeMessage(notification) : makeNotification(notification),
        popUp = $(html).toggleClass('dropdown-item pop-up-notice shadow d-flex');
    $('.notifications-area').toggleClass('d-none d-flex').empty().append(popUp);
    animateCSS('.pop-up-notice', 'slideInUp', function () {
        setTimeout(() => {
            animateCSS('.pop-up-notice', 'slideOutDown', function () {
                $('.pop-up-notice').fadeOut();
                $('.notifications-area').toggleClass('d-none d-flex')
            }, 'faster')
        }, 5000);
    }, 'faster')
}


$(function () {
    $('span.badge-counter').each(function () {
        let unreadCount = +$(this).text();
        if (unreadCount > 0) $(this).show("scale");
        else $(this).hide("scale");
    });

    $(document).on('click', '.mark-as-read.badge-primary', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let _this = $(this),
            parent = _this.parents('.notification'),
            id = parent.attr('data-id'),
            url = $('#allNotificationsLink').attr('href') + '/' + id;
        axios.put(url, {
            mark_read: 1
        }).then(({data}) => {
            _this.removeClass('badge-primary').addClass('badge-light');
            parent.find('.font-weight-bold').removeClass('font-weight-bold');
            let counter = data.notification.data.type == NOTIFICATION_TYPES.message ? $('#messagesDropdown span.badge-counter') : $('#alertsDropdown span.badge-counter'),
                unreadCount = +counter.text();
            unreadCount--; // If there is unread message from this thread counter is not incrementing
            if (unreadCount > 0) counter.text(unreadCount);
            else counter.toggle("scale");
        }).catch(err => {
            console.log(err);
        });
    });

    $('#markAllAsRead').on('click', function (e) {
        e.preventDefault();
        let url = $(this).attr('href'),
            notificationsBlock = $('#notificationsBlock');
        axios.get(url)
            .then(({data}) => {
                notificationsBlock.find('.mark-as-read')
                    .removeClass('badge-primary')
                    .addClass('badge-light');
                notificationsBlock.find('.font-weight-bold')
                    .removeClass('font-weight-bold');
                $('#alertsDropdown span.badge-counter').text('0').toggle("scale");
            })
            .catch(err => {
                console.log(err);
            });
    });

    if (typeof Laravel != "undefined" && Laravel.userId > 0) {
        window.Echo.private(`App.Models.User.${Laravel.userId}`)
            .notification((notification) => {
                addNotification(notification);
                popUpNotification(notification);
                if (notification.type == NOTIFICATION_TYPES.message) {
                    axios.get('/employees/avatars', {
                        params: {
                            employee: notification.sender.id
                        }
                    }).then(({data}) => {
                        if (data.avatar) {
                            $(`.notification[data-id=${notification.id}]`).find('img.rounded-circle').attr('src', data.avatar);
                            notification.sender.avatar = data.avatar;
                        }
                    }).catch(err => console.log(err));
                }
            });
    }
});