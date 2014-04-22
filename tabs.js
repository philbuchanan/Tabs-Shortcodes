(function() {
	'use strict';
	
	var tabs, tabNumber;
	
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
	
	// Set active tab based on URL
	if (window.location.hash) {
		tabs = document.querySelectorAll('ul.tabs li a');
		tabNumber = window.location.hash.match(/\d+$/) - 1;
		
		// Activate the tab if it exists
		if (tabs[tabNumber]) {
			hideActive();
			
			selectTab(tabs[tabNumber]);
			selectContent(window.location.hash);
		}
	}
	
	// Add event handler
	document.getElementById('tabs').onclick = function(event) {
		event.preventDefault();
		
		hideActive();
		
		// Set new active tab
		selectTab(event.target);
		selectContent(event.target.getAttribute('href'));
	};

}());