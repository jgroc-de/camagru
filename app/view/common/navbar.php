<!-- Navbar (sit on top) -->
<nav class="w3-top">
<div class="w3-bar w3-white w3-wide w3-padding w3-card">
	<a href="/" class="w3-bar-item w3-button"><b>GG</b><span class="w3-hide-small"> Camagru</span></a>
	<!-- Float links to the right. Hide them on small screens -->
	<div class="w3-right">
	<div class="w3-container w3-bar-item w3-button" onclick="pageNav(this)">
  		<div class="bar1"></div>
  		<div class="bar2"></div>
   		<div class="bar3"></div>
	</div>
	  <a id="btnCamagru" class="w3-bar-item w3-button" <?php if (!isset($_SESSION['pseudo']))
{
    ?>href="#camagru" onclick="document.getElementById('form').style.display='block';printNotif('You must be loged to access this resource', 200)"<?php
}
    else
    {
        ?>href="/camagru"<?php
    } ?>><b>/b</b></a>
<?php if (!isset($_SESSION['pseudo']))
        {
            ?>
	  <a id="btnLog" class="w3-bar-item w3-green w3-button" href="#login" onclick="document.getElementById('form').style.display='block';">
<?php
        }
    else
    {
        ?>
	  <a id="btnLog" class="w3-bar-item w3-black w3-button" href="#main" onclick="ggForm(this, '/logout', logout);">
<?php
    } ?>
			<i class="fas fa-power-off" title="logout"></i>
	  </a>
	</div>
</div>
</nav>
<div id="pageNav" class="w3-card gg-page-nav w3-row w3-container w3-topbar w3-border-green" hidden="">
<?php if (!empty($options['components']))
	{
?>
<div><a class="w3-button" href="#pictures" style="width:100%">Pictures</a></div>
<div><a class="w3-button" href="#about" style="width:100%">about</a></div>
<div><a class="w3-button" href="#contact" style="width:100%">contact</a></div>
<?php
	}
?>
<div id="btnSettings" <?php if (!isset($_SESSION['pseudo'])) { ?> hidden=""<?php } ?>>
	<a href="#settings" class="w3-button" style="width:100%" onclick="document.getElementById('settingsForm').style.display='block';ggForm(null, '/getSettings', fillSettings)">settings</a>
</div>
</div>
