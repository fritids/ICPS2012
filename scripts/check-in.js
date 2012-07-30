"use strict";

$(function () {
    window.live = $('#live');
    window.resultsList = $('#results');
    window.users = [];
	window.uDialog = $('#user-dialog');
	window.tmpl = '<h1>${first_name} ${last_name}</h1><div class="list"><dl><dt>Passport number</dt><dd>${passport_nr}</dd><dt>Date of Birth</dt><dd>${date_of_birth}</dd><dt>Required payment</dt><dd>${total_payment}</dd><dt>Completed payment</dt><dd>${payment_amount}</dd><dt>Debt</dt><dd>${debt}</dd></dl></div><div class="comments"><textarea>${comment}</textarea></div><div class="clear"></div><div class="submit"><button data-user_id="${user_id}">Check In</button></div>';

    window.live.focus();
	window.resultsList.on('click', 'li', function(e) {
		userDialog($(e.target).data('id'));
	});
    window.live.keyup(function () {
        $.getJSON('/check-in/json-filter-users/', {search: live.val()}, function (data) {
            window.users = data;

            populateUserTable();
        });
    });

    window.uDialog.on('click', '.close', function() { window.uDialog.fadeOut(60) });
    window.uDialog.on('click', '.submit button', function (e) { console.log($(e.target).data('user_id')); });
});

function populateUserTable() {
    window.resultsList.empty();

    $.each(window.users, function (i, e) {
        $('<li>' + e.first_name + ' ' + e.last_name + '</li>').data('id', e.user_id).appendTo(window.resultsList);
    });
}

function userDialog (uid) { 
	window.uDialog.find('.user-data').html('');
	$.getJSON('/check-in/json-user-checkin-data/', 
	{id : uid}, 
	function (data) {
	    data.debt = parseInt(data.total_payment) - parseInt(data.payment_amount);
    	window.uDialog.find('.user-data').html($.tmpl(window.tmpl, data));
	});

	window.uDialog.css('top', '220px').css('display','block').css('opacity','0');
	window.uDialog.animate({opacity: 1, top: '230px'}, 60, 'swing');
}
