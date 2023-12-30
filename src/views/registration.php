<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Register</title>
      <link rel="stylesheet" href="public/css/registration.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
   </head>
   <body>
      <header>
         <div class="logo">
            <img src="public/media/logo.png">
            <a href="#" class="logo-text">ChoreUp!</a>
         </div>
         <input type="checkbox" id="menu-bar">
         <label for="menu-bar" id="menu-label">&#9776;</label>
         <nav class="navbar">
            <ul>
               <li><a href="#">Login</a></li>
               <li><a href="#">Registration</a></li>
            </ul>
         </nav>
      </header>
      <div class="container1">
         <img src="public/media/register.svg">
         <h2>Organize your household<br> with ChoreUp!</h2>
      </div>
      
      <div class="container2">
         <form class="login-box" action="registration" method="POST">
            <h1>Join us!</h1>
            <div class="messages">
            <?php
               if(isset($messages)){
                  foreach($messages as $message) {
                     echo $message;
                  }
                }
            ?>
            </div>
            <div class="textbox">
               <input type="text" placeholder="email" name="email" value="">
            </div>
            <div class="textbox">
                <input type="text" placeholder="first name" name="name" value="">
             </div>
            <div class="textbox">
               <input type="password" placeholder="password" name="password" value="">
            </div>
            <input class="btn" type="submit" name="submit" value="Register">
         </form>
      </div>
   </body>
</html>