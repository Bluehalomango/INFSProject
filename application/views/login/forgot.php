<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'login/forgot'); ?>
				<h2 class="text-center">Recover Password</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Obtain Secret Question</button>
					</div>
					<?php echo $error; ?>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>