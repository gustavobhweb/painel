function ImgSelect(container, options) {
	
    // Default options
    var defaults = {
		url: 'server/upload.php',
        
        crop: {
            aspectRatio: null,
            minSize: null,
            maxSize: null,
            setSelect: null
        },

        flash: {
            swf: 'assets/webcam.swf',
            width: 400,
            height: 300
        },

        messages: {
            invalidJson: 'Invalid JSON response.',
            uploadError: 'Ajax upload error.',
            webcam: 'Webcam Error: ',
            flashwebcam: 'Webcam Error. Please try again.',
            uploading: 'Uploading...',
            saving: 'Saving...',
            loading: 'Loading...',
            jcrop: 'jQuery Jcrop not loaded',
            minCropWidth: 'Crop selection requires a minimum width of ',
            maxCropWidth: 'Crop selection exceeds maximum width of ',
            minCropHeight: 'Crop selection requires a height of ',
            maxCropHeight: 'Crop selection exceeds maximum height of ',
        }
	};

	this.options     = $.extend(true, defaults, options||{});
	
    this._container  = container;
    this._alert      = container.find('.imgs-alert');
    this._crop       = container.find('.imgs-crop-container');
    this._webcam     = container.find('.imgs-webcam-container');
    this._saveBtn    = container.find('.imgs-save');
    this._cancelBtn  = container.find('.imgs-cancel');
    this._captureBtn = container.find('.imgs-capture');

	this.init();
}


(function($){

// Detect getUserMedia support
$.support.getUserMedia = !!(navigator.getUserMedia || navigator.webkitGetUserMedia || 
                            navigator.mozGetUserMedia || navigator.msGetUserMedia);

 // Variable to create unique names for the iframes
var counter = 0,
    stream;

ImgSelect.prototype = {

	// Constructor
	init: function() {
        counter += 1;

		// Upload btn event
		this._container.find('.imgs-upload').append('<input type="file" name="file">')
			.on('change', $.proxy(this.upload, this));

		// Webcam btn event
	    this._container.find('.imgs-webcam').on('click', $.proxy(this.webcam, this));
	},

    // Upload click event
	upload: function(event) {
		var iframe, form, base = this,
        fileInput = $(event.target),
        fileInputClone = fileInput.clone();

        this.removeCrop();
        this.removeWebcam();
        this.alert(this.i18n('uploading'), 2);

        // Create & add iframe to body
        iframe = $('<iframe name="iframe-transport-'+counter+'" style="display:none;"></iframe>');
        iframe.appendTo('body');

        // Add load event
        iframe.on('load', function() {
            var response = null;
            
            try {
                response = iframe.contents().find('body').html();
                response = $.parseJSON(response);
            } catch(e) {}

            if (response)
                base.uploadDone(response);
            else 
                base.alert(base.i18n('invalidJson'), 3);

            window.setTimeout(function() {
                // Remove the iframe & form
                iframe.remove();
                form.remove();

                 // Add the file button back
                $(event.currentTarget).append(fileInputClone);
            }, 100);

        });

        // Create form
        form = $('<form style="display:none;"><form/>');
        form.prop('method', 'POST');
        form.prop('action', this.options.url);
        form.prop('target', iframe.prop('name'));
        form.prop('enctype', 'multipart/form-data');
        form.prop('encoding', 'multipart/form-data');
        form.append(fileInput);
        form.append('<input type="hidden" name="action" value="upload"/>');

        // Add custom data to the form
        if (this.options.data) {
            $.each(this.options.data, function (name, value) {
                $('<input type="hidden"/>')
                    .prop('name', 'data['+name+']')
                    .val(value)
                    .appendTo(form);
            });
        }

        // Add & submit the form
        form.appendTo('body');
        form.submit();
	},

	// Webcam click event
	webcam: function() {
        var base = this, captureCallback,
        
        saveWebcamImage = function(imageData, flash) {
            base.alert(base.i18n('uploading'), 2);
            $.ajax({
                url: base.options.url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'upload',
                    file: imageData, 
                    data: base.options.data||0,
                    flashwebcam: flash
                }
            })
            .done(function(response) { base.uploadDone(response) })
            .fail(function() { base.alert(base.i18n('invalidJson'), 3) });
        };

        this.removeWebcam();
        this.removeCrop();
        this._webcam.show();
        this.alert(0);

        base._cancelBtn.on('click', $.proxy(base.removeWebcam, base));
        
        // HTML5 webcam
        if ($.support.getUserMedia) {
			var video = $('<video autoplay style="display:none"></video>');
            this._webcam.html(video);
            
            navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia ||
                                        navigator.mozGetUserMedia || navigator.msGetUserMedia);

            navigator.getUserMedia({video: true}, function (localMediaStream) {
                stream = localMediaStream;

                video.attr('src', window.URL.createObjectURL(localMediaStream));
                video.show();
                
                base._captureBtn.show();
                base._cancelBtn.show();              

                base._captureBtn.on('click', function() {
                    var canvas = document.createElement('canvas'),
                        ctx = canvas.getContext('2d');

                    canvas.width  = video[0].videoWidth;
                    canvas.height = video[0].videoHeight;
                    ctx.drawImage(video[0], 0, 0);

                    base.removeWebcam();
                    
                    saveWebcamImage( canvas.toDataURL('image/png').replace('data:image/png;base64,', '') );
                });

            }, function(error) {
                base.alert(base.i18n('webcam')+error.name, 3);
            });

		} 
        // Flash webcam
        else {   

            this._webcam.html( webcam.getHtml(this.options.flash) );

            webcam.loaded = function() {
                base._captureBtn.show();
                base._cancelBtn.show();
            };

            webcam.complete = function(imageData) {
                if (imageData) {
                    base.removeWebcam();
                    saveWebcamImage(imageData, true);
                } else
                    base.alert(base.i18n('flashwebcam'), 3);
            };

            base._captureBtn.on('click', function() { webcam.snap() });
        }
	},

    // Upload complete
    uploadDone: function(response) {
        if (response.success) {
            this.alert(0);

            if (this.options.uploadComplete)
                this.options.uploadComplete(response.data);

            if (this.options.crop) 
                this.crop(response.data.url)

        } else
            this.alert(this.i18n(response.data || 'uploadError'), 3);
    },

    // Show cropper
    crop: function(imageUrl) {
        if (!$.Jcrop) 
            return this.alert(this.i18n('jcrop'), 3);

        this.removeCrop();

        this._cancelBtn.on('click', $.proxy(this.removeCrop, this));

        var base = this, img = new Image(),
        options = this.options.crop,
        coords,
        updateCoords = function(_coords) {
            coords = _coords;
        },
        jcrop = {
            onChange: updateCoords,
            onRelease: updateCoords
        };

        if (options.aspectRatio) jcrop.aspectRatio = options.aspectRatio;
        if (options.setSelect) jcrop.setSelect = options.setSelect;
        if (options.minSize) jcrop.minSize = options.minSize;
        if (options.maxSize) jcrop.maxSize = options.maxSize;

        base.alert(base.i18n('loading'), 2);

        img.onload = function() {
            base.alert(0);
            base._cancelBtn.show();
            
            jcrop.trueSize = [img.width, img.height];

            var image = $('<img src="'+imageUrl+'">').appendTo(base._crop);

            window.setTimeout(function() {
                image.Jcrop(jcrop);
            }, 100);

            base._crop.show();

            base._saveBtn.on('click', function() {
                
                if (!base.validateCrop(coords||{})) return;

                base._saveBtn.prop('disabled', true);
                base.alert(base.i18n('saving'), 2);

                $.ajax({
                    url: base.options.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'crop', 
                        image: imageUrl,
                        coords: coords,
                        data: base.options.data||0
                    }
                })
                .done(function(response) { 
                    if (response.success) {
                       
                        base.alert(0);
                        base.removeCrop();

                        if (base.options.cropComplete)
                            base.options.cropComplete(response.data);
                        
                    } else
                        base.alert(base.i18n(response.data || 'uploadError'), 3);
                })
                .fail(function() { base.alert(base.i18n('invalidJson'), 3) })
                .always(function() { base._saveBtn.prop('disabled', false) });

            }).show();
            
        };

        img.src = imageUrl;
    },

    // Crop validation
    validateCrop: function(coords) {
        var  options = this.options.crop;
        
        if (options.minSize) {
            if (options.minSize[0] && (coords.w||0) < options.minSize[0])
               return this.alert(this.i18n('minCropWidth')+options.minSize[0]+'px', 3);

            if (options.maxSize[0] && (coords.w||0) > options.maxSize[0])
                return this.alert(this.i18n('maxCropWidth')+options.maxSize[0]+'px', 3);

            if (options.minSize[1] && (coords.h||0) < options.minSize[1])
                return this.alert(this.i18n('minCropHeight')+options.minSize[1]+'px', 3);

            if (options.maxSize[1] && (coords.h||0) > options.maxSize[1])
               return this.alert(this.i18n('maxCropHeight')+options.maxSize[1]+'px', 3);
        }

        return true;
    },

    // Remove webcam
    removeWebcam: function() {
        if (stream) stream.stop();
        this._webcam.html('');
        this._captureBtn.off('click').hide();
        this._cancelBtn.off('click').hide();
    },

    // Remove crop
    removeCrop: function() {
        $(this._crop).html('');
        this._saveBtn.off('click').hide();
        this._cancelBtn.off('click').hide();
    },

	// Alert function
	alert: function(message, type) {
        if (this.options.alert) 
            return this.options.alert(message, type); 

        if (!message) 
            return $(this._alert).hide();
	   	
        $(this._alert).html(message)
            .removeClass((type==1?'alert-danger alert-warning':type==2?'alert-danger alert-success':'alert-warning alert-danger'))
            .addClass('alert-'+(type==1?'success':type==2?'warning':'danger'))
            .show();
	},

    // Translation function
    i18n: function (message) {
        message = this.options.messages[message] || message.toString();
        return message;
    }
};

})(jQuery);


// JPEGCam by Joseph Huckaby - https://code.google.com/p/jpegcam/
// (just the basic functions are used) 
window.webcam = {
    isLoaded: false,
    loaded: null,
    complete: null,
    error: null,

    // Return html to embed webcam.swf flash
    getHtml: function(options) {
        return '<object id="webcam_movie" type="application/x-shockwave-flash" data="'+options.swf+'" width="'+options.width+'" height="'+options.height+'">'+
                    '<param name="wmode" value="transparent">'+
                    '<param name="movie" value="'+options.swf+'">'+
                    '<param name="FlashVars" value="width='+options.width+'&height='+options.height+'&server_width='+(options.width*1.5)+'&server_height='+(options.height*1.5)+'">'+
                    '<param name="allowScriptAccess" value="always">'+
                '</object>';
    },

    // Send request to webcam.swf
    snap: function() {
        if (!this.isLoaded) 
            return alert('ERROR: Movie is not loaded yet');

        var movie = document.getElementById('webcam_movie');
        if (!movie) 
            alert('ERROR: Cannot locate movie #webcam_movie in DOM');

        try {
            movie._snap();
        } catch (e) {}
    },
        
    // webcam.swf will call this function
    notify: function(type, msg) {
        switch (type) {
            case 'loaded':
                this.isLoaded = true;
                this.loaded();
            break;

            case 'error':
                this.error(msg);
            break;

            case 'success':
                this.complete(msg);
            break;
        }
    }
};