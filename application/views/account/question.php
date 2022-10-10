<div class="container">
      <div class="col-4 offset-4">
			<h3 class="text-center">Current Secret Question: <?php echo $question ?></h3> 
			<h3 class="text-center">Current Answer: <?php echo $answer ?></h3>       
			<?php echo form_open(base_url().'account/question/'); ?>
				<h2 class="text-center">Change Secret Question</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Question" required="required" name="newQuestion">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Answer" required="required" name="newAnswer">
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