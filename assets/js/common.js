/**
 * Elektron - An Admin Toolkit
 * @version 0.3.1
 * @license MIT
 * @link https://github.com/onokumus/elektron#readme
 */
'use strict';

/* eslint-disable no-undef */











$(function () {
	if ($(window).width() < 992) {
		$('#app-side').onoffcanvas('hide');
	} else {
		$('#app-side').onoffcanvas('show');
	}

	$('.side-nav .unifyMenu').unifyMenu({ toggle: true });

	$('#app-side-hoverable-toggler').on('click', function () {
		$('.app-side').toggleClass('is-hoverable');
		$(undefined).children('i.fa').toggleClass('fa-angle-right fa-angle-left');
	});

	$('#app-side-mini-toggler').on('click', function () {
		$('.app-side').toggleClass('is-mini');
		$("#app-side-mini-toggler i").toggleClass('icon-sort icon-menu5');
	});

	$('#onoffcanvas-nav').on('click', function () {
		$('.app-side').toggleClass('left-toggle');
		$('.app-main').toggleClass('left-toggle');
		$("#onoffcanvas-nav i").toggleClass('icon-sort icon-menu5');
	});
	
	$('.onoffcanvas-toggler').on('click', function () {
		$(".onoffcanvas-toggler i").toggleClass('icon-chevron-thin-left icon-chevron-thin-right');
	});
	
	$('.menu-link').on('click', function () {
		/*alert('hello');*/
		$('.app-side').removeClass('is-open');
	});

});


// $(function() {
// 	$('#unifyMenu')
// 	.unifyMenu()
// 	.on('shown.unifyMenu', function(event) {
// 			$('body, html').animate({
// 					scrollTop: $(event.target).parent('li').position().top
// 			}, 600);
// 	});
// });

// Bootstrap Tooltip
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})


// Bootstrap Popover
$(function () {
	$('[data-toggle="popover"]').popover()
})
$('.popover-dismiss').popover({
	trigger: 'focus'
})


// Todays Date
$(function() {
	var interval = setInterval(function() {
		var momentNow = moment();
		$('#today-date').html(momentNow.format('MMMM . DD') + ' '
		+ momentNow.format('. dddd').substring(0,5).toUpperCase());
	}, 100);
});


// Task list
$('.task-list').on('click', 'li.list', function() {
	$(this).toggleClass('completed');
});
// Loading
$(function() {
	$("#loading-wrapper").fadeOut(5000);
});

// Allow only digit values
$(document).on("input", ".digit-only", function() {
    this.value = this.value.replace(/\D/g,'');
});

// Restrict manual enter date and time
 $(".not-manually").keydown(function (event) { event.preventDefault(); });
 
// multile select

 /*--------------------------------------*/
// select2
if ($.isFunction($.fn.select2)) {
	$("#multicategory").select2({
		placeholder: 'Select Category',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}


$(function(){
	$(".group1").fancybox({
  openEffect: 'elastic',
  closeEffect: 'elastic',
  //prevEffect: 'fade',
 // nextEffect: 'fade',
  fitToView: false,
  maxWidth: "90%",
  //type: 'iframe',
  //scrolling: 'no'
  });
  });


//$('.myCalendar').calendar({
//	date: new Date(),
//	autoSelect: false, // false by default
//	select: function(date) {
//	  console.log('SELECT', date)
//	},
//	toggle: function(y, m) {
//	  console.log('TOGGLE', y, m)
//	}
//})

function radioCheck() {
	if (document.getElementById('permissionCheck').checked) {
		document.getElementById('permission').style.display = 'block';
	}
	else {
		document.getElementById('permission').style.display = 'none';
	}	
}



