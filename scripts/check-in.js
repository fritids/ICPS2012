"use strict";

$(function () {
  window.live = $('#live');
  window.resultsList = $('#results');
  window.users = [];
  window.uDialog = $('#user-dialog');
  window.uInfoForm = $('#information dl.personal-info');
  window.uInfoReceipt = $('#receipt dl.personal-info');
  window.tmpl = '<h1>${first_name} ${last_name}</h1><div class="list"><dl><dt>Passport number</dt><dd>${passport_nr}</dd><dt>Date of Birth</dt><dd>${date_of_birth}</dd><dt>Expenses</dt><dd>${expenses}</dd><dt>Required payment</dt><dd>${total_cost}</dd><dt>Completed payment</dt><dd>${payment_amount}</dd><dt>Debt</dt><dd>${debt}</dd></dl></div><div class="comments"><textarea data-user_id="${user_id}">${comment}</textarea></div><div class="clear"></div><div class="submit"><button class="check-in" data-user_id="${user_id}">Check In</button><button class="check-out" data-user_id="${user_id}">Undo Check In</button></div>';

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
  window.uDialog.on('click', '.submit button.check-in', function (e) { checkInUser( $(e.target).data('user_id') );  });
  window.uDialog.on('click', '.submit button.check-out', function (e) { undoCheckIn( $(e.target).data('user_id') );  });
  window.uDialog.on('keyup', '.comments textarea', function(e) { if(e.which == 13) updateComment( $(e.target).data('user_id'), $(e.target).val() ); });

  // bg click closes window
  $('body').click(function(e) { if(e.target.nodeName == 'BODY') window.uDialog.fadeOut(60) } ) 
});

function populateUserTable() {
  window.resultsList.empty();

  $.each(window.users, function (i, e) {
    var li = $('<li>' + e.first_name + ' ' + e.last_name + '</li>').data('id', e.user_id).addClass('id-' + e.user_id);
    if(e.checked_in == 'on') { li.addClass('checked-in'); }
    li.appendTo(window.resultsList);
  });
}

function userDialog (uid) { 
  window.uDialog.find('.user-data').html('');
  $.getJSON('/check-in/json-user-checkin-data/', 
	    {id : uid}, 
	    function (data) {

	      var expenses = [];

	      if(data.extra_day_pre == 'on') { expenses.push('Extra night before') }
	      if(data.extra_day_post == 'on') { expenses.push('Extra night after') }
	      if(data.iaps_member == '0') { expenses.push('IAPS Fee') }

	      data.debt = parseInt(data.total_cost) - parseInt(data.payment_amount);
	      if(data.debt < 0) data.debt = 0;

	      data.expenses = expenses.join(' + ');
    	      window.uDialog.find('.user-data').html($.tmpl(window.tmpl, data));
	      $('#user-dialog button.check-out').hide();
	      $('#user-dialog button.check-in').show();
	      if(data.checked_in == 'on') {  $('#user-dialog button.check-in').hide(); $('#user-dialog button.check-out').show(); }
	    });

  window.uDialog.css('top', '220px').css('display','block').css('opacity','0');
  window.uDialog.animate({opacity: 1, top: '230px'}, 60, 'swing');
}

function checkInUser(user_id) {
  var comments = $('.user-data .comments textarea').val();
  $.getJSON('/check-in/ajax-ucheckin/', { user_id: user_id, comments: comments }, function(data) {
    window.uInfoForm.html('');
    $.each(data.information, function(i, el) {
      window.uInfoForm.append('<dt>'+el.nicename+'</dt>');
      var dd = $('<dd>'+el.value+'</dd>');
      if(el.value == '') { dd.addClass('incomplete') }
      dd.appendTo(window.uInfoForm);
    });

    var receipt_tmpl = '<dt>First name</dt><dd>${first_name}</dd><dt>Last name</dt><dd>${last_name}</dd><dt>Room</dt><dd>${preferred_accommodation} ${room_number}</dd><dt>T-Shirt type</dt><dd>${gender}</dd><dt>T-Shirt size</dt><dd>${shirt_size}</dd><dt>Paid amount</dt><dd>${remaining_payment}</dd>';

    data.receipt.remaining_payment = data.receipt.total_cost - data.receipt.payment_amount;
    if(data.receipt.remaining_payment < 0) data.receipt.remaining_payment = 0;

    window.uInfoReceipt.html('');
    window.uInfoReceipt.html($.tmpl(receipt_tmpl, data.receipt));
    window.print();

    $('#results li.id-' + user_id).addClass('checked-in');
    $('#user-dialog button.check-in').hide();
    $('#user-dialog button.check-out').show();
  });
}

function undoCheckIn(user_id) {
  $.getJSON('/check-in/ajax-ucheckout/', { user_id: user_id }, function(data) {
    window.uInfoForm.html('');
    window.uInfoReceipt.html('');

    $('#results li.id-' + user_id).removeClass('checked-in');
    $('#user-dialog button.check-out').hide();
    $('#user-dialog button.check-in').show();
  });
}

function updateComment(user_id, comments) {
  $.getJSON('/check-in/ajax-checkin-comment/', { user_id: user_id, comments: comments } );

}