<!-- Navbar (sit on top) -->
<nav class="w3-top">
<div class="w3-bar w3-white w3-wide w3-padding w3-card">
	<a href="/" class="w3-bar-item w3-button"><b>GG</b> Camagru</a>
	<!-- Float links to the right. Hide them on small screens -->
	<div class="w3-right">
	  <a href="#pictures" class="w3-hide-small w3-bar-item w3-button">Pictures</a>
	  <a id="btnCamagru" class="w3-bar-item w3-button" href="#camagru" <?php if (!$options['login']): ?>onclick="document.getElementById('form').style.display='block';"<?php endif ?>>/b</a>
	  <a class="w3-hide-small w3-bar-item w3-button" href="#about">about</a>
	  <a class="w3-hide-small w3-bar-item w3-button" href="#contact">contact</a>
<?php if (!$options['login']): ?>
	  <a id="btnLog" class="w3-bar-item w3-green w3-button" href="#login" onclick="document.getElementById('form').style.display='block';">
<?php else: ?>
	  <a id="btnLog" class="w3-bar-item w3-black w3-button" href="#main" onclick="ggForm(this, '/logout', logout);">
<?php endif ?>
			<i class="fas fa-power-off"></i>
	  </a>
	  <a id="btnSettings" href="#settings" class="w3-bar-item w3-button" <?php if (!$options['login']): ?>style="display:none"<?php endif ?> onclick="document.getElementById('settingsForm').style.display='block'">settings</a>
	</div>
</div>
</nav>
