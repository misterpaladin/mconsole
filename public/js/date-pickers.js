var DatePickers = {
	class: '.date-picker',
}

DatePickers.init = function () {
	if ($(DatePickers.class).length > 0) {
		$(DatePickers.class).datepicker({
			format: 'DD/MM/YYYY',
		});
	}
}

$(DatePickers.init);