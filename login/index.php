<?php @session_start();
  if(isset($_SESSION['idusuario']) and strlen($_SESSION['idusuario'])>0){
    header("location: /");
  }

 ?>
 <!DOCTYPE HTML>
 <html lang="es">
 <head>
 	<title>IPSI</title>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1">

 	<meta http-equiv="Expires" content="0">
 	<meta http-equiv="Last-Modified" content="0">
 	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
 	<meta http-equiv="Pragma" content="no-cache">

 	<link rel="stylesheet" href="librerias15/load/css-loader.css">
 	<link rel="stylesheet" type="text/css" href="style.css"/>
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 	<link rel="stylesheet" href="../librerias15/swal/dist/sweetalert2.min.css">
 	<link rel="stylesheet" href="login.css">
 </head>

 <body>


   <div class="container">
       <div class="card card-container login">

         <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
         <p id="profile-name" class="profile-name-card"></p>
         <form class="form-signin" id="acceso">
           <span id="reauth-email" class="reauth-email"></span>
           <input type="email" id="inputEmail" class="form-control" placeholder="Correo" required autofocus>
           <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
           <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Ingresar</button>
         </form>
         <!-- /form -->
       </div>

     </div>

 </body>
 	<!--   Core JS Files   -->
 	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

 	<!--   Alertas   -->
 	<script src="../librerias15/swal/dist/sweetalert2.min.js"></script>

 	<!--   iconos   -->
 	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

	<!--   Boostrap   -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

 	<!--   Propios   -->
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">
 	<script src="login.js"></script>
 </html>