(function($) {
	$(function() {

		// set values for pyro.sort_tree (we'll use them below also)
		$item_list	= $('ul.sortable');
		$url		= 'admin/pyrocourse/order_lesson';
		$cookie		= 'open_pages';

		// store some common elements
		$details 	= $('div#page-details');
		$details_id	= $('div#page-details #lesson-id');

		// show the page details pane
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

		// the "post sort" callback
		post_sort_callback = function() {

			$details 	= $('div#page-details');
			$details_id	= $('div#page-details #lesson-id');

			// refresh pane if it exists
			if($details_id.val() > 0)
			{
				$details.load(SITE_URL + 'admin/pages/ajax_page_details/' + $details_id.val());
			}
		}

		// And off we go
		pyro.sort_tree($item_list, $url, $cookie, data_callback, post_sort_callback);

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