var $ = jQuery;
$(function() {
    window.udata = null;
    $.getJSON('/overview/json-udata/', function(data) {
	window.udata = data;
	populateTable();
	initListeners();
    });
});

function populateTable() {
    var rows = '';
    $('#overview tbody').empty();
    $.each(window.udata, function(i, usr) {
	var tr = '<tr class="';

	if(usr['application_status'] == 0) tr = tr+'opgekankerd ';
	if(usr['application_status'] > 2) tr = tr+'roflqwop ';
	if(usr['application_status'] > 3) tr = tr+'qwopter ';
        tr = tr+'">';
        tr = tr + '<td>'+i+'</td>';
	$.each(usr, function(j, val) {
            if(j == 'application_status') {
		if(val < 3) val = 'Yes';
		else val = 'No';
	    }
	    tr = tr + '<td class="field-'+j+'">' + val + '</td>';
	});
	tr=tr+'<td><a href="#" class="approve" data-uid="'+usr.ID+'">klikkerdeklik</a></td>'; // approve
        tr=tr+'<td class="floes"><input type="text" data-uid="'+usr.ID+'"></td>'; // doekoes
	tr=tr+'<td><a href="#" class="opkankeren" data-uid="'+usr.ID+'">opkankeren</a></td>'; // opkankeren
        tr = tr + '</tr>';
	rows = rows + tr;

    });
    $('#overview tbody').append($(rows));

}

function sortTable(by) {
    window.udata = window.udata.sort(function(a,b) {
	cmp_a = a[by];
	cmp_b = b[by];        
	if(!isNaN(parseInt(cmp_a))) {
	    cmp_a = parseInt(cmp_a);
	    cmp_b = parseInt(cmp_b);
	}
        if(typeof cmp_a === 'string') {
	    cmp_a=cmp_a.toLowerCase();
	    cmp_b=cmp_b.toLowerCase();
	}
	return (cmp_a < cmp_b) ? -1 : 1;
    });
    populateTable();
}

function reverseTable() {
    window.udata = window.udata.reverse();
    populateTable();
}

function initListeners() {
    $.each($('#overview thead th'), function(i, column) {
	$(column).click(function(e) { sortTable($(column).data('key')) });
    });

    $('#reverse').click(function(e) { reverseTable() });

    $('#overview tbody').on('click', 'td', function(e) { 
        e.preventDefault(); 
        var elem = $(e.target); 
        
        if(elem.hasClass('approve')) {
    
            $.post('/overview/ajax-uapprove/', {uid: elem.data('uid')}, function(response) {
                if(response == '1') {
                    elem.parent().siblings('.field-application_status').text('No');
                    elem.parent().parent().addClass('roflqwop');
                }
           }); 
        } else if(elem.hasClass('opkankeren')) {
	    $.post('/overview/ajax-uopkankeren/', {uid: elem.data('uid')}, function(response) {
                if(response == '1') {
                    elem.parent().parent().removeClass().addClass('opgekankerd');
		}

             });

        }
    return false; });
    
    $('#overview tbody').on('keypress', 'td.floes input', function(e) {
	if(e.keyCode == 13) {
	    var elem = $(e.currentTarget);

            $.post('/overview/ajax-upayment/', {uid: elem.data('uid'), amount: elem.val()}, function(response) {
            console.log(response);
	});

	}
    });
}