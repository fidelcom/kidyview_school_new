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

$("#show-meal-btn").click(function(){
  $(".loop-row").show();
});

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

/* function for upload preview button */
function readURL(input) {
	if (input.files && input.files[0]) {
		var uploadfile = new FileReader();
		uploadfile.onload = function (e) {
		$('#upload-preview-img')
			.attr('src', e.target.result);
		};
		uploadfile.readAsDataURL(input.files[0]);
	}
}


$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $(".files").on("change", function(e) {
		var clickedButton = this;
		var parentTag = $(this).parent();
    	//var addhtml = this;
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<div class=\"upload-preview-box\">" +
			"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
			"<span class=\"remove-photo\"></span>"+
			"</div>").insertBefore(parentTag);
			$(".remove-photo").click(function(){
				$(this).parent(".upload-preview-box").remove();
			  });
          });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});


// function addMeal() {
// 	var x = document.getElementById("firstDate").value;
// 	var y = document.getElementById("secondDate").value;
// 	if (x == "" || y == "" ) {
// 		alert("Please select date");
// 		return false;
// 	} else if (x > y) {
// 		alert("Please select valid date")
// 	} else
// 	document.getElementById("looprow").style.display = "block";;
// }


const setup = () => {
	let firstDate = $('#firstDate').val();
	let secondDate = $('#secondDate').val();

	const findTheDifferenceBetweenTwoDates = (firstDate, secondDate) => {
		firstDate = new Date(firstDate);
		secondDate = new Date(secondDate);
		let timeDifference = Math.abs(secondDate.getTime() - firstDate.getTime());
		let millisecondsInADay = (1000 * 3600 * 24);
		let differenceOfDays = Math.ceil(timeDifference / millisecondsInADay);
	return differenceOfDays;
	}
	let result = findTheDifferenceBetweenTwoDates(firstDate, secondDate);

	if (firstDate == "" || secondDate == "" ) {
			alert("Please select date");
			return false;
		} else if (firstDate > secondDate) {
			alert("Please select valid date")
			return false;
		} else
		alert(result);
			$("#looprow").slideToggle();
			//$("#result").text(result);
		}
	
	$(document).ready(function () {
		$('#addmeal-btn').click(function () {
			setup();
		})
	});






