// Basic DataTable
$(function(){
	$('#schoolinfo').DataTable({
		'iDisplayLength': 5,
	});
});
$(function(){
	$('#student-listing').DataTable({
		'iDisplayLength': 10,
	});
});
$(function(){
	$('#parent-listing').DataTable({
		'iDisplayLength': 15,
	});
});
$(function(){
	$('#school-listing').DataTable({
		'iDisplayLength': 10,
	});
});

$(function(){
	$('#payment-listing').DataTable({
		'iDisplayLength': 10,
	});
});

$(function(){
	$('#sub-admin-list').DataTable({'iDisplayLength': 10,});
});






// Vertical Scroll
$(function(){
	$('#scrollVertical').DataTable({
		"scrollY": "200px",
		"scrollCollapse": true,
		"paging": false,
		'iDisplayLength': 3,
	});
});

// Row Selection
$(function(){
	$('#rowSelection').DataTable({
		'iDisplayLength': 3,
	});
	var table = $('#rowSelection').DataTable();

	$('#rowSelection tbody').on( 'click', 'tr', function () {
		$(this).toggleClass('selected');
	});

	$('#button').on('click', function () {
		alert( table.rows('.selected').data().length +' row(s) selected' );
	});
});


// Highlighting rows and columns
$(function(){
	$('#varificationtable').DataTable({
		'iDisplayLength': 10,
	});
	var table = $('#varificationtable').DataTable();  
	$('#varificationtable tbody').on('mouseenter', 'td', function (){
		var colIdx = table.cell(this).index().column;
		$(table.cells().nodes()).removeClass('highlight');
		$(table.column(colIdx).nodes()).addClass('highlight');
	});
});


// Using API in callbacks
$(function(){
  $('#apiCallbacks').DataTable({
  	'iDisplayLength': 3,
    "initComplete": function(){
      var api = this.api();
      api.$('td').on('click', function(){
        api.search(this.innerHTML).draw();
      });
    }
  });
});


// Fixed Header
$(document).ready(function(){
	var table = $('#fixedHeader').DataTable({
	  fixedHeader: true,
	  'iDisplayLength': 3,
	});
});