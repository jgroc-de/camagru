<!DOCTYPE html>
<html lang="fr">
<?php
$description = "Bienvenue sur ce petit site type image-board/instagram. Vous pouvez vous prendre en photo dans l'onglet /b et faire un petit montage avec les filtres proposés.";
?>
	<head>
		<meta charset="utf-8"/>
		<meta name="description" content="<?= $description; ?>">
		<meta name="keywords" lang="fr" content="image-board photo-montage">
		<title>Camagru</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="/css/main.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	</head>

<body>	
	<?php require __DIR__.'/common/navbar.php'; ?>
	<?php
        foreach ($options['header'] as $value) {
            require __DIR__.$value;
        }?>

	<!-- notif -->
	<div id="notif" style="position:fixed;bottom:10px;right:10px;z-index:20"></div>

	<div id="main" class="w3-content w3-padding" style="max-width:1564px">

	<!-- Project Section -->
	<?php
        if (isset($main)) {
            require __DIR__.$main;
        }
        foreach ($options['components'] as $value) {
            require __DIR__.$value;
        }
    ?>
	</div>
	<footer class="w3-container w3-black w3-padding-16">
		<hr>
		<a href="#" class="w3-button w3-black w3-padding-large w3-margin-bottom"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
		<a href="https://jgroc-de.github.io/" class="w3-button w3-black w3-padding-large w3-margin-bottom w3-right"><em class="">© jgroc-de 2018</em></a>
	</footer>
	<script src="/js/common.js"></script>
	<script src="/js/routes.js"></script>
	<?php if ($options['script']): ?>        
	<script src="<?= $options['script']; ?>"></script>
	<?php endif; ?>
	</body>
</html>
