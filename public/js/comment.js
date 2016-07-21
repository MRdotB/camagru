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

	document.querySelector('#submit').addEventListener('click', function(e) {
		e.preventDefault();
		var title = document.querySelector('#title'),
			text = document.querySelector('#text'),
			image = document.querySelector('#article img'),
			comments = document.querySelector('#comments ul');

		var data = new FormData();
		data.append('title', title.value);
		data.append('text', text.value);
		data.append('image_id', image.getAttribute('data-id'));
		request('POST', '/comment/add', data, function(data) {
			if (data !== 'false') {
				var li = document.createElement('li');
				li.textContent = title.value;
				comments.appendChild(li);
				var li = document.createElement('li');
				li.textContent = text.value;
				comments.appendChild(li);
				var li = document.createElement('li');
				li.textContent = data;
				comments.appendChild(li);
			} else {
			}
		});
	}, false);
})();
