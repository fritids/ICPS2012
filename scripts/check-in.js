"use strict";

$(function () {
  window.live = $('#live');
  window.resultsList = $('#results');
  window.users = [];
  window.uDialog = $('#user-dialog');
  window.uInfoForm = $('#information dl.personal-info');
  window.uInfoReceipt = $('#receipt dl.personal-info');
  window.tmpl = '<h1>${first_name} ${last_name}</h1><div class="list"><dl><dt>Passport number</dt><dd>${passport_nr}</dd><dt>Date of Birth</dt><dd>${date_of_birth}</dd><dt>Expenses</dt><dd>${expenses}</dd><dt>Required payment</dt><dd>${total_payment}</dd><dt>Completed payment</dt><dd>${payment_amount}</dd><dt>Debt</dt><dd>${debt}</dd></dl></div><div class="comments"><textarea>${comment}</textarea></div><div class="clear"></div><div class="submit"><button data-user_id="${user_id}">Check In</button></div>';

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
  window.uDialog.on('click', '.submit button', function (e) { checkinUser( $(e.target).data('user_id') );  });

  // bg click closes window
  $('body').click(function(e) { if(e.target.nodeName == 'BODY') window.uDialog.fadeOut(60) } ) 
});

function populateUserTable() {
  window.resultsList.empty();

  $.each(window.users, function (i, e) {
    var li = $('<li>' + e.first_name + ' ' + e.last_name + '</li>').data('id', e.user_id);
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
	      var amount = calculateFullAmount(uid, data.extra_day_pre, data.extra_day_post, data.iaps_member);

	      if(data.extra_day_pre == 'on') { expenses.push('Extra night before') }
	      if(data.extra_day_post == 'on') { expenses.push('Extra night after') }
	      if(data.iaps_member == '0') { expenses.push('IAPS Fee') }

	      data.debt = amount - parseInt(data.payment_amount);
	      if(data.debt < 0) data.debt = 0;
	      data.total_payment = amount;
	      data.expenses = expenses.join(' + ');
    	      window.uDialog.find('.user-data').html($.tmpl(window.tmpl, data));
	    });

  window.uDialog.css('top', '220px').css('display','block').css('opacity','0');
  window.uDialog.animate({opacity: 1, top: '230px'}, 60, 'swing');
}

function checkinUser(user_id) {
  var comments = $('.user-data .comments textarea').val();
  $.getJSON('/check-in/ajax-ucheckin/', { user_id: user_id, comments: comments }, function(data) {
    window.uInfoForm.html('');
    $.each(data.information, function(i, el) {
      window.uInfoForm.append('<dt>'+el.nicename+'</dt>');
      var dd = $('<dd>'+el.value+'</dd>');
      if(el.value == '') { dd.addClass('incomplete') }
      dd.appendTo(window.uInfoForm);
    });

    var receipt_tmpl = '<dt>First name</dt><dd>${first_name}</dd><dt>Last name</dt><dd>${last_name}</dd><dt>Gender</dt><dd>${gender}</dd><dt>T-Shirt size</dt><dd>${shirt_size}</dd><dt>Remaining payment completed</dt><dd>${remaining_payment}</dd>';
    var amount = calculateFullAmount(data.receipt.ID, data.receipt.extra_day_pre, data.receipt.extra_day_post, data.receipt.iaps_member);
    data.receipt.remaining_payment = amount - data.receipt.payment_amount;
    window.uInfoReceipt.html('');
    window.uInfoReceipt.html($.tmpl(receipt_tmpl, data.receipt));
    window.print();

  });
}

function calculateFullAmount(user_id, extra_pre, extra_post, iaps_member) {
  var amount = 180;
  if(user_id > 586) { amount = 200; }
  if(extra_pre == 'on') { amount += 25; }
  if(extra_post == 'on') { amount += 25; }
  if(iaps_member == '0') { amount += 10; }

  return amount;
}