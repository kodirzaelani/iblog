//[editor Javascript]

//Project:	EduAdmin - Responsive Admin Template
//Primary use:   Used only for the wysihtml5 Editor


//Add text editor
    $(function () {
    "use strict";

    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
      };

    // Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace('editor1', options)
	//bootstrap WYSIHTML5 - text editor
	$('.textarea').wysihtml5();

  });

