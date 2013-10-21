(function($) {
	$(function() {

		// set values for pyro.sort_tree (we'll use them below also)
		$item_list	= $('#lesson-list ul.sortable');
		$url		= 'admin/course/lesson_order';
		$cookie		= 'open_lesson';

		// make the link clickable and go to the link page
		$item_list.find('li a').live('click', function(e) {
			window.location = $(this).attr('href');
		});

		// retrieve the ids of root pages so we can POST them along
		data_callback = function(even, ui) {
			// In the pages module we get a list of root pages
			root_pages = [];
			// grab an array of root page ids
			$('ul.sortable').children('li').each(function(){
				root_pages.push($(this).attr('id').replace('lesson_', ''));
			});
			return { 'root_pages' : root_pages };
		}

		// And off we go
		pyro.sort_tree($item_list, $url, $cookie, data_callback);

		function refresh_sticky_page_details(reset) {
			var els = $('.scroll-follow');
			if ( reset === true ) {
				els.stickyScroll('reset');
			}
			els.stickyScroll({ topBoundary: 170, bottomBoundary: 110, minimumWidth: 770});
		}
		refresh_sticky_page_details();
	});
})(jQuery);