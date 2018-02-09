<form id="form-contact" action="#" method="post" data-url=" <?php echo admin_url('admin-ajax.php'); ?> ">
	<div class="form-group">
		<div class="form-field-container">
			<input type="text" placeholder="Whats that name of yours?" id='name' name="name">
		</div>
		<small class="form-control-msg">Please input a little something, something here.</small>
	</div>

	<div class="form-group">
		<div class="form-field-container">
			<input type="text" placeholder="How do I reach you via the email?" id='email' name="email">
		</div>
		<small class="form-control-msg">Please input a little something, something here.</small>
	</div>

	<div class="form-group">
		<div class="form-field-container">
			<textarea name="message" id='message' placeholder="What do you what?" ></textarea>
		</div>
		<small class="form-control-msg">Please input a little something, something here.</small>
		<small class="form-status-msg form-submission js-form-submission">Submission in progress...</small>
		<small class="form-status-msg form-success js-form-success">You're complaints been noted.</small>
		<small class="form-status-msg form-error js-form-error">Try again pal.</small>
	</div>

	<button type='submit' class="btn btn-submit">Fire Away</button>
</form>