(function() {
	'use strict';
	
	var tabLinks = document.querySelectorAll('ul.tabs a'),
		i,
	
	init = function() {
	
		// Loop through event tabs and add click handlers
		for (i = 0; i < tabLinks.length; i += 1) {
			addEvent(tabLinks.item(i), 'click', tabClickHandler);
		}
	
	},
	
	// Multi-browser support for event listeners
	addEvent = function(elem, event, func) {
	
		if (elem.addEventListener) {
			elem.addEventListener(event, func, false);
		}
		else {
			elem.attachEvent('on' + event, func);
		}
	
	},
	
	tabClickHandler = function(event) {
	
		var currentActiveTab     = document.querySelector('ul.tabs a.active'),
			currentActiveSection = document.querySelector('section.tab.active'),
			selectSection        = document.querySelector(this.getAttribute('href')),
			i;
		
		// Prevent default click
		event.preventDefault();
		
		// Remove active tab
		if (currentActiveTab) {
			currentActiveTab.removeAttribute('class');
			currentActiveSection.setAttribute('class', 'tab');
		}
		
		// Set new active tab
		this.setAttribute('class', 'active');
		selectSection.setAttribute('class', 'tab active');
	
	};
	
	init();

}());