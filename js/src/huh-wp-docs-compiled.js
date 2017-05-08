'use strict';

// const docUrl = 'https://raw.githubusercontent.com/secretpizzaparty/huh/master/README.md';

var huhLauncher = '',
    huhMobileClose = '',
    huhContainer = '',
    huhContent = '',
    huhHeader = '',
    huhBackButton = '',
    huhAccentColor = '',
    huhTocTriggers = '',
    huhData = [];

// init
function huhInit() {
	huhLauncher = document.querySelector('#huh-launcher--button');
	huhMobileClose = document.querySelector('#huh-mobile-close');
	huhContainer = document.querySelector('#huh-container');
	huhContent = document.querySelector('#huh-content');
	huhHeader = document.querySelector('#huh-header');
	huhBackButton = document.querySelector('#huh-back-to-toc');
	huhAccentColor = huhLauncher.getAttribute('data-accent-color');

	if (HuhWPDocs.huhCurrentScreen) {
		var currentScreenInfo = document.createElement('span');
		currentScreenInfo.appendChild(document.createTextNode(HuhWPDocs.huhCurrentScreen));
		currentScreenInfo.className = 'huh-screen-info';
		huhLauncher.appendChild(currentScreenInfo);
	}

	if (HuhWPDocs.huhDocUrl) {
		var grabContent = function grabContent(url, i) {
			return fetch(url).then(function (res) {
				return res.text();
			}).then(function (data) {
				return huhData.push({ index: i, data: data });
			});
		};

		Promise.all(HuhWPDocs.huhDocUrl.map(grabContent)).then(function () {
			return loadContent(huhData);
		});
	}
}

function loadContent(data) {
	var dataRaw = '';
	data = _.sortBy(data, 'index');
	data.forEach(function (obj) {
		dataRaw += obj.data + '\n';
	});
	// first we format the content
	var dataFormat = marked(dataRaw);

	// then we create our custom content structure
	var content = createContent(dataFormat);

	// then we insert content into the content box
	huhContent.innerHTML = content;

	// apply accent color
	applyAccentColor(huhAccentColor);

	// bind interaction events after all content is loaded
	huhBindEvents();
}

function createContent(data) {
	var sections = data.split('<h1'); // split at h1
	sections = sections.filter(function (n) {
		return n != '';
	}); // remove empty elements

	var content = sections.map(function (section) {
		var splitIndex = section.indexOf('</h1>'); // split into two blocks after <h1>
		var headingSplit = section.slice(0, splitIndex);
		var heading = headingSplit.slice(headingSplit.indexOf('>') + 1); // content after `id="*">``
		var body = section.slice(splitIndex + 5); // content after closing `</h1>`

		return {
			heading: heading,
			body: body
		};
	});

	var contentHtml = formatContent(content);

	return contentHtml;
}

function formatContent(content) {
	var html = content.map(function (item) {
		return '\n\t\t\t<a class="huh-toc--trigger">' + item.heading + '<span>&rarr;</span></a>\n\t\t\t<div class="huh-toc--content">\n\t\t\t\t' + item.body + '\n\t\t\t</div>\n\t\t';
	}).join('');

	return html;
}

function showHideContainer(e) {
	huhLauncher.classList.toggle('active');
	huhContainer.classList.toggle('open');
}

function showContent(e) {
	// hide all triggers
	for (var i = 0; i < huhTocTriggers.length; i++) {
		huhTocTriggers[i].classList.add('hidden');
		huhTocTriggers[i].classList.remove('show');
	}

	// add a class to indicate current selection
	e.target.classList.add('current');

	// add a class to content block of the current selection
	// so we can show just that one
	var content = e.target.nextElementSibling;
	content.classList.add('open');

	// show back button
	huhHeader.classList.add('with-content');
}

function backToToc() {
	// show all triggers
	for (var i = 0; i < huhTocTriggers.length; i++) {
		huhTocTriggers[i].classList.remove('hidden', 'current');
		huhTocTriggers[i].classList.add('show');
	}

	// hide all content blocks
	var contentBlocks = document.querySelectorAll('.huh-toc--content');
	for (var i = 0; i < contentBlocks.length; i++) {
		contentBlocks[i].classList.remove('open');
	}

	// show main header
	huhHeader.classList.remove('with-content');
}

function applyAccentColor(color) {
	huhLauncher.setAttribute('style', 'background:' + color);
	huhHeader.setAttribute('style', 'background:' + color);
}

function huhBindEvents() {
	huhLauncher.addEventListener('click', showHideContainer);
	huhMobileClose.addEventListener('click', showHideContainer);
	huhBackButton.addEventListener('click', backToToc);

	huhTocTriggers = document.querySelectorAll('.huh-toc--trigger');
	for (var i = 0; i < huhTocTriggers.length; i++) {
		huhTocTriggers[i].addEventListener('click', showContent);
	}
}

// init after page has loaded to make sure
// we can find the DOM nodes to modify
window.addEventListener('load', huhInit);
