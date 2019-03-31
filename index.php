<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <?php
    if(isset($_SESSION['nao_autenticado'])):
  ?>
  <div class="notification is-danger">
     <p>ERRO: Usuário ou senha inválidos.</p>
  </div>
  <?php
    endif;
    unset($_SESSION['nao_autenticado']);
  ?>
<div class="box">
  <h2>Login</h2>
  <form action="login.php" method="POST">
     <div class="inputBox">
         <input type="text" name="usuario" required="">
         <label>Usuário</label>
     </div>
     <div class="inputBox">
         <input type="password" name="senha" required="">
         <label>senha</label>
     </div>
     <input type="submit" name="" value="Entrar">
   </form>
</div>
</body>
</html>


