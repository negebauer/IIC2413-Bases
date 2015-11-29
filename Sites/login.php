<?php

    try {
        $db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
        }
    catch(PDOException $e) {
        echo $e->getMessage();
        }

        echo "<script type='text/javascript'>alert('Holaaaa!!!!');</script>";
function verificar_login($user,$password, $db,&$result) 
    { 
        $sql = 'SELECT * FROM usuario WHERE username = \'$user\' and password = \'$password\''; 
        $rec = $db -> query($sql); 


        foreach ($rec as $user) {
            echo "<script type='text/javascript'>alert('$user');</script>";
        }

        if (!$rec) {
            return False;
        } else {
            return True;
        }
        
    } 

/*Luego haremos una serie de condicionales que identificaran el momento en el boton de login es presionado y cuando este sea presionado llamaremos a la función verificar_login() pasandole los parámetros ingresados:*/

if(!isset($_SESSION['userid'])) //para saber si existe o no ya la variable de sesión que se va a crear cuando el usuario se logee
{ 
    if(isset($_POST['login'])) //Si la primera condición no pasa, haremos otra preguntando si el boton de login     fue presionado
    { 
        if(verificar_login($_POST['user'],$_POST['password'],$db,$result) == 1) //Si el boton fue presionado llamamos a la función verificar_login() dentro de otra condición preguntando si resulta verdadero y le pasamos los valores ingresados como parámetros.
        { 
            /*Si el login fue correcto, registramos la variable de sesión y al mismo tiempo refrescamos la pagina index.php.*/ 
            $_SESSION['userid'] = $result->idusuario; 
            $_SESSION['user'] = 'Holaa!!!!!'
            header("location:saludo.php"); 
        } 
        else 
        { 
            echo '<div class="error">Su usuario es incorrecto, intente nuevamente.</div>'; //Si la función verificar_login() no pasa, que se muestre un mensaje de error. 
        } 
    } 
?> 
<form action="" method="post" class="login"> 
    <div><label>Username</label><input name="user" type="text" ></div> 
    <div><label>Password</label><input name="password" type="password"></div> 
    <div><input name="login" type="submit" value="login"></div> 
</form> 
<?php 
} else { 
    // Si la variable de sesión ‘userid’ ya existe, que muestre el mensaje de saludo. 
    echo 'Su usuario ingreso correctamente.'; 
    echo '<a href="logout.php">Logout</a>'; 
} 
?> 