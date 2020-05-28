function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

$(function () {
    //Initialize emoji picker
    const icon = document.getElementById('emojiPicker');
    const container = document.getElementById('emojiContainer');
    const editable = document.getElementById('rewardPost');
    picker.listenOn(icon, container, editable);

    //Catch employee pull up
    let $rewardField = $('#rewardPost'),
        employeePullUp = false,
        $rewardingEmployee = $('#rewardingEmployee');

    $rewardField.on('keydown', function (event) {
        if (!$rewardingEmployee.val() && (event.key == '@' || (event.shiftKey && event.code == 'Digit2'))) {
            event.preventDefault();
            let content = $rewardField.html();
            $rewardField.html(content + `<span class="pull-up-wrapper"><span id="employee-pull-up">@`);
            let listHtml = `<ul id="employees-match-list" contenteditable="false">`,
                i = 0;
            for (const employee of employees) {
                listHtml += `<li data-id="${employee.id}">${employee.first_name} ${employee.last_name}</li>`;
                if (++i >= 5) break;
            }
            listHtml += `</ul>`;
            $(listHtml).prependTo($('.pull-up-wrapper'));
            employeePullUp = true;
            placeCaretAtEnd($rewardField[0]);
            return true;
        }
        if (employeePullUp) {
            let $pullUp = $('#employee-pull-up');
            if (event.code == 'Space' || event.key == ' ') {
                employeePullUp = false;
                let plainText = $pullUp.text();
                $('.pull-up-wrapper').empty().removeClass('pull-up-wrapper').text(plainText);
                placeCaretAtEnd($rewardField[0]);
            } else {
                let keyType = event.code.substring(0, 3),
                    charTypes = ['Num', 'Dig', 'Key'],
                    newSymbol = charTypes.includes(keyType) ? event.key : '',
                    writtenText = $pullUp.text() + newSymbol,
                    match = writtenText[0] == '@' ? writtenText.slice(1).toLowerCase() : writtenText.toLowerCase(),
                    listHtml = ``,
                    i = 0;
                if (event.code == 'Backspace') match = match.slice(0, -1);
                for (const employee of employees) {
                    if (employee.first_name.toLowerCase().includes(match) || employee.last_name.toLowerCase().includes(match)) {
                        listHtml += `<li data-id="${employee.id}">${employee.first_name} ${employee.last_name}</li>`;
                        i++;
                    }
                    if (i >= 5) break;
                }
                if (listHtml) $(document).find('#employees-match-list').fadeIn().html(listHtml);
                else $(document).find('#employees-match-list').fadeOut();
            }
            return true;
        }
    });
    $(document).on('click', '#employees-match-list>li', function () {
        $rewardingEmployee.val($(this).attr('data-id'));
        employeePullUp = false;
        let pulledEmployee = $(this).text(),
            newHtml = `<span>@${pulledEmployee}</span>&nbsp;&nbsp;<small><i class="remove-employee-tag fas fa-times"></i></small>`;
        $('.pull-up-wrapper').empty()
            .removeClass('pull-up-wrapper')
            .html(newHtml)
            .addClass('pulled-employee badge badge-lg badge-primary')
            .prop('contentEditable', false);
        $rewardField.html($rewardField.html() + '&nbsp;');
        placeCaretAtEnd($rewardField[0]);
    });

    $(document).on('click', '.remove-employee-tag', function () {
        $rewardingEmployee.val(null);
        $('.pulled-employee').remove();
        placeCaretAtEnd($rewardField[0]);
    });

    $('.points-dropdown .dropdown-item').on('click', function () {
        $(this).parent().find('.dropdown-item').removeClass('active');
        $(this).addClass('active');
        let value = $(this).attr('data-value');
        $('#rewardingPoints').val(value);
        $('.points-dropdown .active-reward').text(value);
    })


//GIPHY FUNCTIONAL
    // // Initiate gifLoop for set interval
    // var refresh;
    // // Duration count in seconds
    // const duration = 1000 * 10;
    // // Giphy API defaults
    // const giphy = {
    //     baseURL: "https://api.giphy.com/v1/gifs/",
    //     apiKey: "Q7bDiM48mU9ciAFAU9dSuavzpjPmyIjD",
    //     tag: "doughnut",
    //     type: "random",
    //     rating: "pg-13"
    // };
    // // Target gif-wrap container
    // const $gif_wrap = $("#gif-wrap");
    // // Giphy API URL
    // let giphyURL = encodeURI(
    //     giphy.baseURL +
    //     giphy.type +
    //     "?api_key=" +
    //     giphy.apiKey +
    //     "&tag=" +
    //     giphy.tag +
    //     "&rating=" +
    //     giphy.rating
    // );
    //
    // // Call Giphy API and render data
    // var newGif = () => {
    //     axios.get(giphyURL)
    //         .then(({data}) => {
    //             renderGif(data)
    //         })
    //         .catch(err => {
    //             console.error(err);
    //         })
    // };// $.getJSON(giphyURL, json => );
    //
    // // Display Gif in gif wrap container
    // var renderGif = _giphy => {
    //     console.log(_giphy);
    //     // Set gif as bg image
    //     $gif_wrap.css({
    //         "background-image": 'url("' + _giphy.image_original_url + '")'
    //     });
    //
    //     // Start duration countdown
    //     // refreshRate();
    // };
    // const newGifButton = $('#new-gif');
    //
    // newGifButton.click(newGif)
});
