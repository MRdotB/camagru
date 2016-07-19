(function() {

	var streaming = false,
		webcam	= document.querySelector('#webcam'),
		video		= document.querySelector('#video'),
		sidebar	= document.querySelector('#sidebar'),
		cover		= document.querySelector('#cover'),
		canvas	= document.querySelector('#canvas'),
		ctx 		= canvas.getContext('2d'),
		photo		= document.querySelector('#photo'),
		shoot		= document.querySelector('#shoot'),
		upload	= document.querySelector('#upload'),
		imageLoader = document.getElementById('imageLoader'),
		width		= 640,
		height	= 0;

	navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia);

	function startWebcam() {
		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
		);

		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);
	}

	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
	}

	function ajaxUpload() {
		var xhr = new XMLHttpRequest();
		var formData = new FormData();
			xhr.onload = function () {
				if (xhr.status >= 200 && xhr.status <= 400) {
					var data = JSON.parse(xhr.responseText);
					var img = document.createElement("img");
					img.src = data.path;
					img.className = 'thumbnail';
					sidebar.appendChild(img);
				} else {
					console.log(new Error(xhr.responseBody));
				}
			};

		canvas.toBlob(function(blob) {
			formData.append('pictures[]', blob, 'blob.png');
			xhr.open('POST', '/image/upload', true);
			xhr.send(formData);
		});
	}

	function handleImage(e){
		webcam.style.opacity = 0;
		document.getElementById('step2').style.opacity = 1;
		var reader = new FileReader();
		reader.onload = function(event){
			var img = new Image();
			img.onload = function(){
				canvas.width = img.width;
				canvas.height = img.height;
				ctx.drawImage(img,0,0);
			}
			img.src = event.target.result;
		}
		reader.readAsDataURL(e.target.files[0]);
	}

	//Events
	imageLoader.addEventListener('change', handleImage, false);

	webcam.addEventListener('click', function(e) {
		document.getElementById('step1').style.opacity = 0;
		document.getElementById('step2').style.opacity = 1;
		document.getElementById('shoot').style.opacity = 1;
		startWebcam();
		e.preventDefault();
	}, false);
	shoot.addEventListener('click', function(e){
		takepicture();
		e.preventDefault();
	}, false);

	upload.addEventListener('click', function(e) {
		ajaxUpload();
		e.preventDefault();
	}, false);

	sidebar.addEventListener('click', function(e) {
		e.preventDefault();
		var target = e.target
		var id = e.target.getAttribute('data-id');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/image/delete/' + id, true);
		xhr.onload = function() {
			if (xhr.status >= 200 && xhr.status < 400) {
				target.parentNode.removeChild(target);
			} else {
				console.log('error');
			}
		};

		xhr.onerror = function() {
		};

		xhr.send();
	}, true);
})();
