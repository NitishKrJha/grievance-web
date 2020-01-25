tinymce.init({
    selector: '.content',
     toolbar: "styleselect fontselect fontsizeselect | forecolor backcolor |insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | numlist bullist", 
    plugins: 'image code',
    height: 400,
    valid_elements: "*[*]",
    image_title: true,
    font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n;Century Gothic=Century Gothic',
    images_upload_base_path: 'https://www.mymissingrib.com/uploads/images/',
    images_upload_url: 'https://www.mymissingrib.com/tinymcimageupload',
    file_picker_types: 'image',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        // Note: In modern browsers input[type="file"] is functional without 
        // even adding it to the DOM, but that might not be the case in some older
        // or quirky browsers like IE, so you might want to add it to the DOM
        // just in case, and visually hide it. And do not forget do remove it
        // once you do not need it anymore.

        input.onchange = function() {
            var file = this.files[0];

            // Note: Now we need to register the blob in TinyMCEs image blob
            // registry. In the next release this part hopefully won't be
            // necessary, as we are looking to handle it internally.
            var id = 'blobid' + (new Date()).getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var blobInfo = blobCache.create(id, file);
            blobCache.add(blobInfo);

            // call the callback and populate the Title field with the file name
            cb(blobInfo.blobUri(), { title: file.name });
        };

        input.click();
    },
    autoresize_min_height: 400,
    autoresize_max_height: 800
});