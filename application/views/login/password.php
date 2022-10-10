<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'login/forgot/'.$user); ?>
				<h2 class="text-center">Create A New Password</h2>       
					<div class="form-group">
						<input type="password" class="form-control" placeholder="New Password" required="required" name="password">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Change Password Now</button>
					</div>
					<?php echo $error; ?>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>