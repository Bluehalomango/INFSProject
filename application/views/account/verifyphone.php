<div class="container">
      <div class="col-4 offset-4">
			<h2 class="text-center">Verify Phone Number:</h2>
			<h4 class="text-center">In order to verify your phone number, a unique code has been sent to your phone via sms.</h4>    
			<?php echo form_open(base_url().'account/check_phone/'); ?>
				<h3 class="text-center">Please Enter SMS Code</h3>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Code" required="required" name="code">
					</div>
					<div class="form-group">
					<?php echo $result; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Verify</button>
					</div>   
			<?php echo form_close(); ?>
	</div>
</div>