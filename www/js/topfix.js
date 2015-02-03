(function($) {

	$.fn.topFix = function() {

		this.each(function () {
			var me = $(this);
			var topOffset = me.data('topfix-offset') || 0;
			var defaultPosition = me.offset().top;
			var meHeight = me.outerHeight();
			var dummy = $("<div>").css({
				height: meHeight
			});

			$(window).on("scroll", function () {

				var scrollTop = $(this).scrollTop();

				if (scrollTop + topOffset >= defaultPosition) {
					me.addClass("topfix-sticky").css({
						top: topOffset
					}).after(dummy);
				} else  {
					me.removeClass("topfix-sticky").css({
						top: ""
					});
					dummy.remove();
				}
			});

		});

	}

}(jQuery));