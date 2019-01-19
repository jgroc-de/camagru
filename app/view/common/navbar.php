<!-- Navbar (sit on top) -->
<nav class="w3-top">
<div class="w3-bar w3-white w3-wide w3-padding w3-card">
	<a href="/" class="w3-bar-item w3-button"><b>GG</b> Camagru</a>
	<!-- Float links to the right. Hide them on small screens -->
	<div class="w3-right">
	  <a href="#pictures" class="w3-hide-small w3-bar-item w3-button">Pictures</a>
	  <a class="w3-bar-item w3-button" href="/camagru">/b/</a>
	<?php if (!isset($_SESSION['pseudo'])): ?>
	  <span class="w3-bar-item w3-button" onclick="document.getElementById('form').style.display='block';
   			document.getElementById('signup').style.display='none'">sign-in/up</span>
	<?php else: ?>
	  <span class="w3-bar-item w3-button" onclick="document.getElementById('settings').style.display='block'">settings</span>
	  <a class="w3-bar-item w3-button" href="/logout">logout</a>
	<?php endif; ?>
	  <a class="w3-hide-small w3-bar-item w3-button" href="#about">about</a>
	  <a class="w3-hide-small w3-bar-item w3-button" href="#contact">contact</a>
</div>
</nav>
