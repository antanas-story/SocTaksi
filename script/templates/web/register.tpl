{include file='header.tpl' title=$page.name metadescrip=$page.metaDescription}
<div class="page">
	{$page.text}

	<div class="contact-form">
		<form action="#">
			<label>Vardas</label>
			<input class="input" id="firstname" name="firstname" type="text" />
			
			<label>Pavardė</label>
			<input class="input" id="lastname" name="lastname" type="text" />
			
			<label>El. pa&scaron;tas</label>
			<input class="input" id="email" name="email" type="text" />
			
			<label>Papildoma informacija</label>
			<textarea class="textarea" id="extra" name="extra"></textarea>
			
			<input type="submit" value="Siųsti" />
		</form>
		<div id="contact-thankyou" style="display:none">
			Jūs esate užregistruoti, poros dienų bėgyje su
			jumis turėtų susisiekti mūsų vadybininkas
		</div>
	</div>
</div><!-- /.page -->
{include file='footer.tpl'}