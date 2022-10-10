<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'login/forgot/'.$user); ?>
				<h2 class="text-center">Answer Secret Question</h2> 
					<div class="form-group">
						<h2 class="text-center" id = "question"></h2>    
						<input type="text" class="form-control" placeholder="Answer" required="required" name="answer">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Submit Answer</button>
					</div>
					<?php echo $error; ?>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>


<script>
set_info();

   function set_info() {
		var question = <?php echo json_encode($question); ?>;
		var answer = <?php echo json_encode($answer); ?>;
		document.getElementById("question").innerHTML = "Secret Question: " + question;
	}
</script>