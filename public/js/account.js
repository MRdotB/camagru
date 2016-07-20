(function() {
	//checkpage
	var slug = document.querySelector('body');
	if (slug.classList.contains('login')) {
		login();
	} else if (slug.classList.contains('register')) {
		register();
	} else if (slug.classList.contains('forgotten')) {
		forgotten();
	}

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

	function login() {
		document.querySelector('#submit').addEventListener('click', function(e) {
			e.preventDefault();
			var login = document.querySelector('#login'),
				password = document.querySelector('#password'),
				err = document.querySelector('#err');

			if (login.value.length > 0 && password.value.length > 0) {
				var data = new FormData();
				data.append('username', login.value);
				data.append('password', password.value);
				request('POST', '/user/login', data, function(data) {
					if (data === 'true') {
						window.location.replace("http://localhost:8080");
					} else {
						err.innerHTML = 'User ou password invalide !';
						setTimeout(function(){
							err.innerHTML = '';
						}, 2000);
					}
				});
			}
		}, false);
	}

	function register() {
		document.querySelector('#submit').addEventListener('click', function(e) {
			e.preventDefault();
			var login = document.querySelector('#login'),
				email = document.querySelector('#email'),
				password = document.querySelector('#password'),
				err = document.querySelector('#err');

			if (login.value.length > 0 && password.value.length > 0 && email.value.length > 0) {
				var data = new FormData();
				data.append('username', login.value);
				data.append('email', email.value);
				data.append('password', password.value);
				request('POST', '/user/register', data, function(data) {
					if (data === 'true') {
						window.location.replace("http://localhost:8080/login");
					} else {
						err.innerHTML = 'Un des fields est invalide cherche !';
						setTimeout(function(){
							err.innerHTML = '';
						}, 2000);
					}
				});
			}
		}, false);
	}

	function forgotten() {
		document.querySelector('#submit').addEventListener('click', function(e) {
			e.preventDefault();
			var login = document.querySelector('#login'),
				password = document.querySelector('#password'),
				err = document.querySelector('#err');

			if (login.value.length > 0) {
				request('POST', '/user/reset/' + login.value, null, function(data) {
					if (data === 'true') {
						window.location.replace("http://localhost:8080/login");
					} else {
						err.innerHTML = 'l\'user n\'existe pas !';
						setTimeout(function(){
							err.innerHTML = '';
						}, 2000);
					}
				});
			}
		}, false);
	}

})();
