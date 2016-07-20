(function () {
	var pagination = document.getElementById('pagination');
	if (pagination === null) {
		return;
	}
	var collection = document.getElementById('collection');
	var current = 0;
	// default active class on the second li
	pagination.children[1].className = 'active';

	function setActive(elNum) {
		current = elNum;
		if (current === 0) {
			pagination.firstChild.classList.add('disabled');
			pagination.lastChild.classList.remove('disabled');
		} else if (current === pagination.childElementCount - 3) {
			pagination.firstChild.classList.remove('disabled');
			pagination.lastChild.classList.add('disabled');
		} else {
			pagination.firstChild.classList.remove('disabled');
			pagination.lastChild.classList.remove('disabled');
		}

		var i = 1;
		var last = pagination.childElementCount - 1;
		while (i < last) {
			if (i === elNum + 1) {
				pagination.children[i++].classList.add('active');
			} else {
				pagination.children[i++].classList.remove('active');
			}
		}
	}

	function displayBook(elNum) {
		elNum *= 3;
		var i = 0;
		while (i < collection.childElementCount) {
			if (i >= elNum && i < elNum + 3) {
				collection.children[i++].classList.remove('gallery--modifier');
			} else {
				collection.children[i++].classList.add('gallery--modifier');
			}
		}
	}

	function paginator(e) {
		e.preventDefault();
		var tar = e.target;
		document.body.scrollTop = 15;
		if (!isNaN(tar.innerHTML)) {
			setActive(parseInt(tar.innerHTML, 10));
			displayBook(tar.innerHTML);
		} else if (tar.innerHTML === 'chevron_left' && current) {
			setActive(--current);
			displayBook(current);
		} else if (tar.innerHTML === 'chevron_right' && current < pagination.childElementCount - 3) {
			setActive(++current);
			displayBook(current);
		}
	}

	pagination.addEventListener('click', paginator);
})();
