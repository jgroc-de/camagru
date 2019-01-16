<!-- Navbar (sit on top) -->
<nav class="w3-top">
<div class="w3-bar w3-white w3-wide w3-padding w3-card">
	<a href="/" class="w3-bar-item w3-button"><b>GG</b> Camagru</a>
	<!-- Float links to the right. Hide them on small screens -->
	<div class="w3-right w3-hide-small">
      <a href="index.php" class="w3-bar-item w3-button">Last Pictures</a>
      <a href="index.php?action=listPicsByLike" class="w3-bar-item w3-button">Trending</a>
      <a class="w3-bar-item w3-button" href="index.php?action=camagru">/b/</a>
	<?php if (!isset($_SESSION['pseudo'])): ?>
      <a class="w3-bar-item w3-button" href="index.php?action=login">Login</a>
      <a class="w3-bar-item w3-button" href="index.php?action=signup">Signup</a>
	<?php else: ?>
      <a class="w3-bar-item w3-button" href="index.php?action=settings">settings</a>
      <a class="w3-bar-item w3-button" href="index.php?action=logout">logout</a>
	<?php endif; ?>
    <span class="w3-bar-item w3-button" onclick="test()">test</span>
</div>
</nav>
<script>
function test()
{
	alert("lol");
}
</script>
