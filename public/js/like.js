(function(){
	function request(verb, path, data, cb) {
		var xhr = new XMLHttpRequest();
		xhr.open(verb, path, true);
		xhr.onload = function() {
			if (this.status >= 200 && this.status < 400) {
				cb(this.response);
			} else {
				//cb(this.response);
			}
		};
		xhr.onerror = function() {};
		if (data) {
			xhr.send(data);
		} else {
			xhr.send();
		}
	}
	var image = document.querySelector('#article img');

	function likeCount() {
		request('POST', '/likecount/' + image.getAttribute('data-id'), null, function(data) {
			document.querySelector('#count').textContent = data;;
		});
	}

	document.querySelector('#like').addEventListener('click', function(e) {
		e.preventDefault();
		request('POST', '/like/' + image.getAttribute('data-id'), null, function(data) {
			if (data === 'true') {
			} else {
			}
			likeCount();
		});
	}, false);
	document.querySelector('#unlike').addEventListener('click', function(e) {
		e.preventDefault();
		request('POST', '/unlike/' + image.getAttribute('data-id'), null, function(data) {
			if (data === 'true') {
			} else {
			}
			likeCount();
		});
	}, false);

	likeCount();
})();
