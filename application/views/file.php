<?php echo form_open_multipart('upload/do_upload');?>
<div class="row justify-content-center">
    <div class="col-md-4 col-md-offset-6 centered">
        <?php echo $error;?>
        <h2 class="text-center">Upload Game</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Game Name" required="required" name="name">
					</div>
					<div class="form-group">
						<input type="date" class="form-control" placeholder="Release Date" required="required" name="dor">
					</div>
                    <label for="file_name">Cover Image:</label><br>
                    <input type="file" name="gamefile" size="2000"/>
                    <br>
                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" rows="8" cols="80"> </textarea>
        

		<div class="form-group">
            <input type="submit" value="upload" />
        </div>
    </div>
</div>

<?php echo form_close(); ?>
<h3></h3>
<div class="main"> </div>
