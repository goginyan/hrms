$(function () {
    $('#search').on('input', function () {
        let search = $(this).val();
        if (search.length >= 3) {
            $('.results-heading').text($('.results-heading').attr('data-search'));
            let list = $('.results-list');
            list.addClass('loading');
            axios.post($(this).attr('data-url'), {search})
                .then(({data}) => {
                    list.empty();
                    for (const post of data) {
                        list.append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="${post.url}">${post.title}</a>
                                <span class="badge badge-primary badge-lg ml-2">by ${post.searchable.author}</span>
                            </li>
                        `);
                    }
                    list.removeClass('loading');
                })
                .catch(error => console.log(error));
        }
    })
});