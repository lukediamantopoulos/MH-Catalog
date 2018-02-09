'use strict';

// -----------------------------------------------------------
// Basics
// -----------------------------------------------------------

function gE(e) {
	return document.getElementById(e);
}

// Get X & Y on page
function getPosition(element) {
	var xPosition = 0;
	var yPosition = 0;

	while (element) {
		xPosition += element.offsetLeft - element.scrollLeft + element.clientLeft;
		yPosition += element.offsetTop - element.scrollTop + element.clientTop;
		element = element.offsetParent;
	}

	return { x: xPosition, y: yPosition };
}

// -----------------------------------------------------------
// Footer Beneath 
// -----------------------------------------------------------

var footerIsOpen = false;
var footerB = gE('footer-beneath');
var site = gE('site');
var footerBtnOpen = gE('btn-footer-beneath-open');
var footerBtnClose = gE('btn-footer-beneath-close');

// button to OPEN
footerBtnOpen.addEventListener('click', function (e) {
	e.preventDefault();
	footerSwitch();
});

// button to Close 
footerBtnClose.addEventListener('click', footerClose);

// Switch
function footerSwitch() {
	footerIsOpen ? footerClose() : footerOpen();
}

// Open Action
function footerOpen() {
	footerIsOpen = true; // New state
	var footerBHeight = footerB.offsetHeight; // Footer Beneath height
	site.style.bottom = footerBHeight + 'px';

	// Turn off Menu while open
	navSwitchOn.style.pointerEvents = "none";
}

// Close action
function footerClose() {
	footerIsOpen = false;
	site.style.bottom = 0 + 'px';
	navSwitchOn.style.pointerEvents = "auto";
}

// -----------------------------------------------------------
// Popover
// -----------------------------------------------------------

var popover;
var popoverIsActive = false;

$('.mh-popover').on('click', function () {

	// Destroy if there already is one
	if (popoverIsActive) {
		fadeOut(popover);
		setTimeout(function () {
			popover.parentNode.removeChild(popover);
		}, 300);
		popoverIsActive = false;
		return;
	}

	// Create if there is none
	var target = this;

	// Position of target
	var targetCoords = getPosition(target);
	var targetX = targetCoords.x;
	var targetY = targetCoords.y;

	// Content
	var title = target.getAttribute('title');
	var content = target.getAttribute('data-content');
	var color = target.getAttribute('data-color');

	// Popover build
	popover = document.createElement('div');
	popover.className = 'mh-popover-modal';
	popover.innerHTML = '<h6 class="mh-popover-modal-title">' + title + '</h6>';
	popover.innerHTML += '<div class="mh-popover-modal-content">' + content + '</div>';

	// Popover position & style
	target.parentNode.insertBefore(popover, target.nextSibling);
	var popoverHeight = popover.offsetHeight;
	popover.style.display = 'none';
	popover.style.left = targetX + 'px';
	popover.style.top = targetY - popoverHeight - 10 + 'px';
	popover.style.backgroundColor = color;

	// Popover tail build
	var popoverTail = document.createElement('span');
	popoverTail.className = 'mh-popover-modal-tail';
	popover.style.backgroundColor = color;

	// Popover tail position & style
	popover.appendChild(popoverTail);

	// Animate in
	fadeIn(popover);

	// State
	popoverIsActive = true;
});

// -----------------------------------------------------------
// Fade Out
// -----------------------------------------------------------

function fadeIn(element) {
	element.style.opacity = 0;
	element.style.display = 'inline-block';

	setTimeout(function () {
		element.style.transition = '.3s all ease-out';
		element.style.opacity = 1;
	}, 300);
};

// -----------------------------------------------------------
// Fade In
// -----------------------------------------------------------

function fadeOut(element) {
	element.style.transition = '.3s all ease-out';
	element.style.opacity = 0;
};

// -----------------------------------------------------------
// Nav Menu Expand
// -----------------------------------------------------------

var navSwitchOn = gE('mh-sidebar-toggle');
var navIsExpanded = false;
var navIsOpen = false;
var borderEl = $('.border');

var tl = new TimelineMax({
	paused: true
}).to(".mh-sidebar", .4, { width: "100%" }).set([".mh-sidebar-menu .menu-item, .mh-sidebar .widget-location"], { opacity: 0, x: -20 }).set(".mh-sidebar-inner", { opacity: 1, display: 'inline-block' }, "+=.25").staggerTo(".mh-sidebar .menu-item", .3, { opacity: 1, x: 0 }, .1).to(".mh-sidebar .widget-location", .3, { opacity: 1, x: 0 }, "+=.1");

function navExpand() {
	navIsExpanded = true;
	tl.timeScale(1).play();
	$('#mh-sidebar-toggle').addClass('nav-open');
}

function navCollapse() {
	navIsExpanded = false;
	tl.timeScale(1.5).reverse();
	$('#mh-sidebar-toggle').removeClass('nav-open');
}

// Hover on toggle bar
navSwitchOn.addEventListener('mouseenter', function () {
	$('.border').addClass('hover');
});

// NOT hover on toggle bar
navSwitchOn.addEventListener('mouseleave', function () {
	$('.border').removeClass('hover');
});

navSwitchOn.addEventListener('click', function () {
	if (navIsExpanded == false) {
		navExpand();
	} else {
		navCollapse();
	}
});

// -----------------------------------------------------------
// Contact form to Post
// -----------------------------------------------------------

$('#form-contact').on('submit', function (e) {
	e.preventDefault();

	var form = $(this);
	var name = form.find('#name').val();
	var email = form.find('#email').val();
	var message = form.find('#message').val();
	var ajaxURL = form.data('url');

	// Remove styling/error classes
	$('.form-group').removeClass('has-error');
	$('.form-group').removeClass('js-form-feedback');
	$('.form-status-msg').removeClass('js-show-feedback');

	// Check if fields are empty
	if (name == '') {
		$('#name').parent().parent('.form-group').addClass('has-error');
		return;
	} else if (email == '') {
		$('#email').parent().parent('.form-group').addClass('has-error');
		return;
	} else if (message == '') {
		$('#message').parent().parent('.form-group').addClass('has-error');
		return;
	}

	// Disable fields while AJAX is firing
	form.find('input, textarea, button').attr('disabled', 'disabled');
	$('.js-form-submission').addClass('js-show-feedback');

	// Ajax Call
	$.ajax({
		url: ajaxURL,
		type: 'post',
		data: {
			name: name,
			email: email,
			message: message,
			action: 'mh_save_user_contact_form'
		},

		error: function error(response) {
			$('.js-form-submission').removeClass('js-show-feedback');
			$('.js-form-error').addClass('js-show-feedback');
			form.find('input, textarea, button').removeAttr('disabled');
		},

		success: function success(response) {
			if (response == 0) {
				setTimeout(function () {
					$('.js-form-submission').removeClass('js-show-feedback');
					$('.js-form-error').addClass('js-show-feedback');
					form.find('input, textarea, button').removeAttr('disabled');
				}, 2000);
			} else {
				setTimeout(function () {
					$('.js-form-submission').removeClass('js-show-feedback');
					$('.js-form-success').addClass('js-show-feedback');
					form.find('input, textarea, button').removeAttr('disabled').val('');
				}, 2000);
			}
		}
	});
});
//# sourceMappingURL=script.js.map
