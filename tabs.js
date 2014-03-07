(function() {
	'use strict';
	
	document.getElementById('tabs').onclick = function(event) {
	
		event.preventDefault();
		
		// Remove active tab
		document.querySelector('ul.tabs a.active').removeAttribute('class');
		document.querySelector('section.tab.active').className = 'tab';
		
		// Set new active tab
		event.target.className = 'active';
		document.querySelector(event.target.getAttribute('href')).className = 'tab active';
	
	};

}());