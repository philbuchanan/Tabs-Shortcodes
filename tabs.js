(function() {
	'use strict';
	
	var tabs = document.querySelectorAll('ul.tabs li a'),
		tabNumber = parseInt(tabsShortcodesSettings.open),
		num;
	
	// Set the tab number based on URL hash 'tab-#'
	if (window.location.hash) {
		tabNumber = window.location.hash.match(/\d+$/);
	}
	
	// Hide active tab
	function hideActive() {
		document.querySelector('ul.tabs a.active').removeAttribute('class');
		document.querySelector('section.tab.active').className = 'tab';
	}
	
	// Select tab
	function selectTab(ele) {
		ele.className = 'active';
	}
	
	// Select tab content
	function selectContent(selector) {
		document.querySelector(selector).className = 'tab active';
	}
	
	// Set active tab based on tab number (URL hash or shortcode parameter)
	if (tabNumber) {
		// Tab number is 0 based
		num = tabNumber - 1;
		
		// Activate the tab if it exists
		if (tabs[num]) {
			hideActive();
			
			selectTab(tabs[num]);
			
			if (window.location.hash) {
				selectContent(window.location.hash);
			}
			else {
				selectContent('#tab-' + tabNumber);
			}
		}
	}
	
	// Add event handler
	document.getElementById('tabs').onclick = function(event) {
		event.preventDefault();
		
		if (event.target.tagName.toLowerCase() === 'a') {
			hideActive();
			
			// Set new active tab
			selectTab(event.target);
			selectContent(event.target.getAttribute('href'));
		}
	};

}());