<section class = "upload">
    <div id="drop_file_zone" ondrop="imgDrag(event)" ondragover="return false">
        <div id="drag_upload_file">
            <p>Drop file(s) here</p>
            <p>or</p>
            <p><input type="button" value="Select File(s)" onclick="doc();"></p>
            <input type="file" id="selectfile" multiple>
        </div>
    </div>
</section>
<section class = "upload">
        <div id = "uploaded">
        </div>
</section>

<script>

var files;

  function imgDrag(file) {
      var img = file.dataTransfer.files;
      imgUpload(img);
  }

  function doc() {
      document.getElementById('selectfile').click();
      document.getElementById('selectfile').onchange = function() {
        files = document.getElementById('selectfile').files;
        imgUpload(files);
      };
  }
  
  function imgUpload(img) {
    var id = <?php echo json_encode($game_id); ?>;
      var img_data = new FormData();
      for(i=0; i < img.length; i++) {  
          img_data.append('file[]', img[i]);
      }
      $.ajax({
          type: 'POST',
          url:"<?php echo base_url(); ?>upload/uploadImages/" + id,
          data: img_data,
          contentType: false,
          processData: false,
          success:function(data) {
              $('#drag_upload_file').append(data);
          }
      });
  }



$(document).ready(function () {
    $("html").on("dragover", function (e) {
      e.preventDefault();
      e.stopPropagation();
    });
 
    $("html").on("drop", function (e) {
      e.preventDefault();
      e.stopPropagation();
    });
 
    $('#drop_file_area').on('dragover', function () {
      $(this).addClass('drag_over');
      return false;
    });
 
    $('#drop_file_area').on('dragleave', function () {
      $(this).removeClass('drag_over');
      return false;
    });
});

</script>

<style>
.upload {
    padding: 1%;
    display: flex;
    justify-content: center;
    align-items: center;
}

#drop_file_zone {
    background-color: #EEE;
    border: #999 5px dashed;
    min-width: 40%;
    min-height: 40%;
    max-width: 70%;
    padding: 10px;
    font-size: 18px;
}
#drag_upload_file {
    width:80%;
    margin:0 auto;
}
#drag_upload_file p {
    text-align: center;
}
#drag_upload_file #selectfile {
    display: none;
}

#drag_upload_file > img {
  width: 200px;
}
</style>