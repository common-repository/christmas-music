jQuery(document).ready(function() {
  var $ = jQuery;



  // Color pickers
  var xmasColor = {
    defaultColor: true
  };
  $('#button_bg').wpColorPicker(xmasColor); 
  $('#button_color').wpColorPicker(xmasColor);



  // Choose audio file
  var frame,
      addFileButton = $('.christmas-music-file-button'),
      removeFileButton = $('.christmas-music-file-remove'),
      fileInput = $('.christmas-music-file'),
      fileName = $('.christmas-music-file-name');
  
  addFileButton.on( 'click', function( event ){
    event.preventDefault();
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload audio file to Christmas Music plugin',
      button: {
        text: 'Use this file'
      },
      multiple: false,
      library: {
        type: 'audio',
      }
    });
    
    // When an image is selected in the media frame...
    frame.on( 'select', function() {

      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment id to our hidden input
      fileInput.val( attachment.id );
      fileName.text( attachment.filename );
      removeFileButton.css( 'display', 'inline-block' );
    });

    // Finally, open the modal on click
    frame.open();
  });

  removeFileButton.on( 'click', function() {
    fileInput.val( '' );
    fileName.text( '' );
    removeFileButton.css( 'display', 'none' );
  });

});



