<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'account/change/'.$text); ?>
				<h2 class="text-center">Change <?php echo str_replace("_", " ", $text); ?></h2>       
					<div class="form-group">
						<input type="text" id = "input" class="form-control" placeholder="<?php echo str_replace("_", " ", $text); ?>" required="required" name="val">
					</div>
					<div class="form-group">
					<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Change</button>
					</div>   
			<?php echo form_close(); ?>
	</div>
</div>


<script>
check_type();

   function check_type() {
      var info = <?php echo json_encode($text); ?>;
	  console.log(info);
	  if (info == "Phone_Number") {
		//document.getElementById('input').type = 'number';
	  }
   }

</script>