<!DOCTYPE html>
<html lang="fr">
<?php
$description = "Bienvenue sur ce petit site type image-board/instagram. Vous pouvez vous prendre en photo dans l'onglet /b et faire un petit montage avec les filtres proposés.";
?>
	<head>
		<meta charset="utf-8"/>
<?php if ($options['last']):?>
		<meta name="description" content="<?= $description ?>">
<?php endif; ?>
		<meta name="keywords" lang="fr" content="image-board photo-montage">
		<title>Camagru</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

<body>	
	<?php require __DIR__.'/common/navbar.php' ?>
	<?php 
		foreach ($header as $value)
		{
			require __DIR__.$value;
		}?>

	<div class="w3-content w3-padding" style="max-width:1564px">

	<!-- Project Section -->
  		<div class="w3-container w3-padding-32" id="projects">
			<h3 class="w3-border-bottom w3-border-light-grey w3-padding-16"><?= $view ?></h3>
  		</div>

  		<div class="w3-row-padding">
	<?php
		if (function_exists('flashMessage'))
			flashMessage();
		require __DIR__.$main;
		?>
  		</div>

	<?php 
		foreach ($components as $value)
		{
			require __DIR__.$value;
		}?>
	</div>
	<footer class="w3-center w3-black w3-padding-16">
		<hr>
		<em class="">© jgroc-de 2018</em>
	</footer>
	<?php if ($options['script']): ?>        
	<script src="<?= $options['script'] ?>"></script>
	<?php endif;?>
	</body>
</html>
