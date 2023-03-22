<form method="POST" action="{{ route('newslettersend') }}">
	@csrf
	<div class="input-group">
		<input class="form-control input-lg" name="newsletter_email" placeholder="Abonnez-vous vite" type="email" >
		<span class="input-group-btn">
			<button class="btn btn-lg button-theme" type="submit">
				<i class="fa fa-envelope">
				</i>
			</button>
		</span>
	</div> 
	<div class="input-group"> 
		@error('email')
			<p style="color:red">Entrer votre email</p>
		@enderror
	</div> 
</form>