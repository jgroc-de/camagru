<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description"
          content="Bienvenue sur ce petit site type image-board/instagram. Vous pouvez vous prendre en photo dans l'onglet /b et faire un petit montage avec les filtres proposés.">
    <meta name="keywords" lang="en" content="image-board photo-montage">
    <title>Camagru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" async>
    <link rel="stylesheet" href="/public/css/main.css" async>
    <link rel="stylesheet" href="/public/css/camagru.css" async>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"
          async>
    <link rel="manifest" href="/public/manifest.json">
    <link rel="modulepreload" href="/public/js/app.js">
    <script type="module" src="/public/js/app.js"></script>
    <link rel="modulepreload" href="/public/js/Library/ggAjax.js">
    <link rel="modulepreload" href="/public/js/Library/printnotif.js">
    <!-- PWA -->
    <meta name="theme-color" content="#4caf50"/>
    <!-- iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Weather PWA">
    <link rel="apple-touch-icon" href="/images/icons/icon-152x152.png">
</head>

<body>

<!-- header -->
<?php
    require __DIR__.'/components/navbar.html';
    require __DIR__.'/components/header.html';
    require __DIR__.'/form/authForm.html';
    require __DIR__.'/form/settingsForm.html';
    ?>

<!-- notif -->
<div id="notif" style="position:fixed;bottom:10px;right:10px;z-index:20"></div>

<!-- Project Section -->

<!-- commons -->
<?php
    require __DIR__.'/components/about.html';
    require __DIR__.'/components/contact.html';
?>

<footer class="w3-container w3-black w3-padding-16">
    <hr>
    <a href="#" class="w3-button w3-black w3-padding-large w3-margin-bottom">
        <i class="fa fa-arrow-up w3-margin-right" title="To the top"></i><span class="w3-hide-small">To the top</span>
    </a>
    <a href="https://jgroc-de.github.io/" class="w3-button w3-black w3-padding-large w3-margin-bottom w3-right">
        <em class="">© jgroc-de 2018</em>
    </a>
</footer>
<script>
    /*if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
          .then((reg) => {
            console.log('Service worker registered.', reg)
          })
      });
    }*/
</script>
<?php
foreach (\App\Controller\minimifier::TEMPLATES as $template) { ?>
    <template id="<?= $template; ?>_skeleton">
        <?php require __DIR__.'/components/'.$template.'.html'; ?>
    </template>
    <?php
} ?>
</body>
</html>
