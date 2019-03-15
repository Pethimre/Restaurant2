
/*=================================
||          Owl Carousel
==================================*/
    $("#header-slider").owlCarousel({

        navigation : true, // Show next and prev buttons
        slideSpeed : 100,
        paginationSpeed : 400,
        singleItem: true,
        autoPlay: true,
        pagination: false,

        // "singleItem:true" is a shortcut for:
        // items : 1, 
        // itemsDesktop : false,
        // itemsDesktopSmall : false,
        // itemsTablet: false,
        // itemsMobile : false

    });

/*=================================
||          WOW
==================================*/
wow = new WOW(
    {
      boxClass:     'wow',      // default
      animateClass: 'animated', // default
      offset:       0,          // default
      mobile:       true,       // default
      live:         true        // default
    }
  )
wow.init();

/*=================================
||          Smooth Scrooling
==================================*/
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: (target.offset().top - 9)//top navigation height
                    }, 1000);
                    return false;
                }
            }
        });
    });

    
/*====================================================================
            Navbar shrink script
======================================================================*/
$(document).ready(function() {
    $(window).scroll(function() {
        if ($(document).scrollTop() > 50) {
            $('nav').addClass('shrink');
        } 
        else {
            $('nav').removeClass('shrink');
        }
    });
});


$(document).ready(function(){
    $(window).scroll(function() {
        if ($(document).scrollTop() > 50) {
            $("#logo").attr("src", "images/eatwell.png")
        }
        else {
             $("#logo").attr("src", "images/Logo_main.png")
        }
    });
});


$(document).ready(function () {

    var $menuPricing = $('#menu-pricing');
    $menuPricing.mixItUp({
        selectors: {
            target: 'li'
        }
    });

});


/*=================================================
        Showing Icon in placeholder
=====================================================*/

$('.iconified').on('keyup', function() {
    var input = $(this);
    if(input.val().length === 0) {
        input.addClass('empty');
    } else {
        input.removeClass('empty');
    }
});

/*=========================================================
                Scroll  Speed
=======================================================*/

$(function() {  
    jQuery.scrollSpeed(100, 1000);
});

/*=========================================================
                Drag and Drop
=======================================================*/

/**
 * Drag and Upload 2.0
 * A Remi A Olsen Production :D
 * remi@remiolsen.info / https://remiolsen.info
 * 
 * This work is licensed under a Creative Commons Attribution-NonCommercial 4.0 International License:
 * https://creativecommons.org/licenses/by-nc/4.0/
 * 
 * Instructions:
 * At the bottom of the script, you can pass in all custom variables. Typically that would be your server-side script, e.g.:
 * d.setUp( { url: 'dragAndUpload/uploadscripts/uploader.php' } );
 * 
 * To pass a custom query string to the script, used the 'data-post-string' attribute in the 'label' tag.
 * The upload response is stored in 'data-response' on said 'label'.
 * If the first five characters in the response is 'error' (no quotes), the JavaScript will consider the upload a fail.
 * 
 * To limit on file-types:
 * d.setUp( { url: 'dragAndUpload/uploadscripts/uploader.php', allowedFileTypes: ['text/plain', 'text/html'] } );
 * 
 * And so on and so forth.
 */

'use strict';

var
    duConfig,
    skeleton = {
        // URL to post upload to.
        url: 'https://youruploadscript',
        // Max total size of uploads.
        maxSize: 5242880,
        // Max number of files to upload.
        maxFiles: 5,
        // Allowed MIME types. Set to [] to allow all file types. Otherwise: ['image/png', 'text/html']
        allowedFileTypes: [],
        // Base target CSS class.
        staticClass: 'dragAndUpload',
        // Mouse over CSS class.
        hoverClass: 'dragAndUploadActive',
        // Currently uploading CSS class.
        uploadingClass: 'dragAndUploadUploading',
        // Error CSS class.
        errorClass: 'dragAndUploadFailure',
        // Successful upload CSS class.
        successClass: 'dragAndUploadSuccess',
        // Class of counter element.
        counterClass: 'dragAndUploadCounter',
        // Class of manual upload element.
        manualElement: 'dragAndUploadManual',

        /**
         * Checks if the event is a child of the drop element. If it is,
         * it returns the parent element -- i.e. the one handling the dropped
         * files. This is the element where we set one of the aforementioned
         * CSS classes.
         * @t: HTML element.
         */
        setElement: function ( t ) {
            if ( t ) {
                return ( t.nodeName === 'label' ? t : t.closest( 'label' ) );
            }
        },

        /**
         * Removes a CSS class from the received HTML element.
         * @t: HTML element.
         * @className: CSS class to remove.
         */
        removeClass: function ( t, className ) {
            if ( t.className.indexOf( className ) > -1 ) {
                className = ' ' + className;
                var tempClass = t.className.replace( className, '' );
                t.className = tempClass;
            }
        },

        /**
         * Changes the CSS class of the drop element, and updates
         * the text of the status element.
         * @text: Status text.
         * @isError: 0 = Not an error message. 1 = Is an error message.
         * @dropElement: Drop element.
         * @response: HTTP response.
         * @s: This class, passed in because of JS's object odditites.
         */
        message: function ( text, isError, dropElement, response, s ) {
            console.log( response );
            var changeToClass = isError === 1 ? this.errorClass : this.successClass,
                uploadingClass = this.uploadingClass,
                counterElement = dropElement.querySelector( '.' + s.counterClass );
            this.removeClass( dropElement, uploadingClass );
            dropElement.className += ' ' + changeToClass;
            counterElement.innerHTML = text;
        },

        /**
         * Checks that files are valid for upload.
         * @files: Files dropped onto element.
         * @s: This class, passed in because of JS's object odditites.
         * @dropElement: Drop element.
         */
        validFiles: function ( files, s, dropElement ) {
            var data = new FormData();
            var filesTotalSize = 0,
                totalFiles = files.length,
                filePlural = totalFiles > 0 ? "files" : "file",
                allFilesAllowed = true;
            for ( var i = 0; i < files.length; i++ ) {
                if ( s.allowedFileTypes.indexOf( files[i].type ) === -1 && s.allowedFileTypes.length > 0 ) {
                    allFilesAllowed = false;
                    break;
                } else {
                    data.append( files[i].name, files[i] );
                    filesTotalSize += files[i].size;
                }
            }
            if ( allFilesAllowed === false ) {
                s.message( 'Illegal file types in file list.', 1, dropElement, '', s );
                return 'failed';
            } else if ( filesTotalSize > s.maxSize ) {
                s.message( 'Total size of ' + filePlural + ' too big.', 1, dropElement, '', s );
                return 'failed';
            } else if ( totalFiles > s.maxFiles ) {
                s.message( 'Only ' + s.maxFiles + ' ' + filePlural + ' allowed.', 1, dropElement, '', s );
                return 'failed';
            } else {
                return data;
            }
        },

        /**
         * Where the actual HTTP upload happens.
         * @dropElement: Drop element.
         * @s: This class, passed in because of JS's object odditites.
         * @data: Form data.
         */
        uploadFiles: function ( dropElement, s, data ) {
            var xhr = new XMLHttpRequest(),
                qs = dropElement.getAttribute( 'data-post-string' ) + '&cacheisbad=' + new Date().getTime(),
                counterElement = dropElement.querySelector( '.' + s.counterClass );
            dropElement.removeAttribute( 'data-response' );
            xhr.onreadystatechange = function ( e ) {
                if ( xhr.readyState === 4 && xhr.status === 200 ) {
                    if ( xhr.responseText.substring( 0, 5 ) === "error" ) {
                        counterElement.innerHTML = 'Error';
                        s.message( 'Upload failed on server side.', 1, dropElement, xhr.responseText, s );
                    } else {
                        s.message( 'Upload complete!', 0, dropElement, xhr.responseText, s );
                        dropElement.setAttribute( 'data-response', xhr.responseText );
                    }
                } else if ( xhr.readyState === 4 && xhr.status !== 200 ) {
                    counterElement.innerHTML = 'Error';
                    s.message( 'Upload failed with status ' + xhr.status + '.', 1, dropElement, xhr.responseText, s );
                }
            };
            xhr.upload.onprogress = function ( e ) {
                var percent = ( parseInt( ( e.loaded / e.total ) * 100 ) );
                if ( isNaN( percent ) ) { percent = 0; }
                counterElement.innerHTML = percent + '%';
                if ( percent === 100 ) {
                    counterElement.innerHTML = 'Working&#8230;';
                }
            };
            xhr.open( 'POST', s.url + qs );
            xhr.send( data );
        },

        /**
         * Start the upload.
         * @files: Files dropped onto element.
         * @s: This class, passed in because of JS's object odditites.
         * @dropElement: Files dropped onto element.
         */
        uploadSetup: function ( files, s, dropElement ) {
            var data = this.validFiles( files, s, dropElement );
            if ( data !== 'failed' ) {
                this.uploadFiles( dropElement, s, data );
            }
        },
    },

    dragAndUpload = {
        /**
         * Handles manually uploaded files.
         * @event: HTML element event.
         */
        handleManualUpload: function ( event ) {
            event.stopPropagation();
            event.preventDefault();
            var s = duConfig,
                t = event.target,
                files = t.files,
                findId = t.getAttribute( 'id' ),
                dropElement = document.querySelector( '[for="' + findId + '"]' );
            s.removeClass( dropElement, s.successClass );
            s.removeClass( dropElement, s.errorClass );
            dropElement.className += ' ' + s.uploadingClass;
            s.uploadSetup( files, s, dropElement );
        },

        /**
         * Handles dropped files.
         * @event: HTML element event.
         */
        handleDrop: function ( event ) {
            event.stopPropagation();
            event.preventDefault();
            var s = duConfig,
                t = event.target,
                files = event.dataTransfer.files,
                dropElement = skeleton.setElement( t );
            s.removeClass( dropElement, s.successClass );
            s.removeClass( dropElement, s.hoverClass );
            dropElement.className += ' ' + s.uploadingClass;
            s.uploadSetup( files, s, dropElement );
        },

        /**
         * Handles drag over and leave.
         * @event: HTML element event.
         */
        handleDrag: function ( event ) {
            event.stopPropagation();
            event.preventDefault();
            var s = duConfig,
                dropElement = s.setElement( event.target );
            s.removeClass( dropElement, s.successClass );
            s.removeClass( dropElement, s.errorClass );
            if ( dropElement.className.indexOf( s.hoverClass ) === -1 ) {
                dropElement.className += ' ' + s.hoverClass;
            }
        },

        handleDragLeave: function ( event ) {
            event.stopPropagation();
            event.preventDefault();
            var s = duConfig,
                dropElement = s.setElement( event.target );
            s.removeClass( dropElement, s.successClass );
            s.removeClass( dropElement, s.errorClass );
            s.removeClass( dropElement, s.hoverClass );
        },

        /**
         * Kick off.
         */
        setUp: function ( config ) {
            duConfig = Object.create( skeleton );
            for ( var c in config ) {
                duConfig[c] = config[c];
            }
            var dropZones = document.getElementsByClassName( duConfig.staticClass );
            if ( dropZones.length > 0 ) {
                for ( var i = 0; i < dropZones.length; i++ ) {
                    if ( window.FormData ) {
                        var manualElement = dropZones[i].querySelector( '.' + duConfig.manualElement );
                        manualElement.addEventListener( 'change', this.handleManualUpload, false );
                        dropZones[i].addEventListener( 'dragover', this.handleDrag, false );
                        dropZones[i].addEventListener( 'dragleave', this.handleDragLeave, false );
                        dropZones[i].addEventListener( 'drop', this.handleDrop, false );
                    } else {
                        dropZones[i].className += ' ' + duConfig.errorClass;
                        dropZones[i].querySelector( '.' + duConfig.messageElement ).innerHTML = 'Sorry, browser in incompatible.';
                    }
                }
            }
        }
    };

// Kick-off

window.onload = function () {
    try {
        var d = Object.create( dragAndUpload );
        d.setUp();
    } catch ( exception ) {
        console.log( 'Error creating menus. In all likelihood your browser is out of date.\r\n', exception, '\r\n', navigator.userAgent );
    }
};

/* Table Animations */

var desktopBtn = $("#desktop");
var mobileBtn = $("#mobile");
var body = $('body');

desktopBtn.on('click', function() {
  body.addClass('large-screen');
  togglePrimaryButtonStyle($(this));
})

mobileBtn.on('click', function() {
  body.removeClass('large-screen');
  togglePrimaryButtonStyle($(this));
})

function togglePrimaryButtonStyle(el) {
  var sibling = el.parent('.btn-group').siblings('.btn-group').find('.btn');
  el.addClass('btn-primary');
  sibling.removeClass('btn-primary').addClass('btn-default');
}