<script>

if ($.isFunction($.fn.select2)) {
	$("#classection").select2({
		placeholder: 'Select class and section',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}


if ($.isFunction($.fn.select2)) {
	$("#chooseschool").select2({
		placeholder: 'Select school',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}
if ($.isFunction($.fn.select2)) {
	$("#chooseclass").select2({
		placeholder: 'Select class',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}
if ($.isFunction($.fn.select2)) {
	$("#choosesection").select2({
		placeholder: 'Select section',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}
if ($.isFunction($.fn.select2)) {
	$("#choosedistrice").select2({
		placeholder: 'Select district',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}
if ($.isFunction($.fn.select2)) {
	$("#choosestates").select2({
		placeholder: 'Select state',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}
if ($.isFunction($.fn.select2)) {
	$("#choosecountry").select2({
		placeholder: 'Select country',
		allowClear: true
	}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
}
</script>