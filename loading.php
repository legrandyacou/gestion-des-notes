<?php

require_once "session_config.php"; 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Chargement...</title>
  <link rel="stylesheet" href="doc css/chargement.css">
 <style>
     body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #fff;
    }
    .spinner {
      width: 50px;
      height: 50px;
      border: 5px solid #ddd;
      border-top-color: #3498db;
      border-radius: 50%;
      animation: tourner 1s linear infinite;
    }
    @keyframes tourner {
      to { transform: rotate(360deg); }
    }
 </style>
</head>
<body>
  <div class="spinner"></div>

  <script>
    setTimeout(function () {
      window.location.href = "index.php"; //redirection vers la page index
   }, 2000);
  </script>
</body>
</html>