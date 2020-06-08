<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema de Promocion y gestion Altour">
  <meta name="author" content="Altour">
  <meta name="keyword" content="Sistema de promocion, Sistema de gestion">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sistema Altour</title>
  <link rel="stylesheet" href="css/plantilla.css">
</head>

<body class="app mt-5 d-flex align-items-center">
    <div class="container">
        @yield('login')
    </div>
    <script src="js/plantilla.js"></script>
</body>
</html>
