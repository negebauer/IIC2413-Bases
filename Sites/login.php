<?php
    
    $params = "dbname=grupo5 host=localhost port=5432 user=grupo5 password=gruponico";
    $conn = pg_connect($params) or die('Hubo un problema con la conexión');

function verificar_login($user,$password,&$result) 
    { 
        $sql = "SELECT username FROM usuario WHERE username = '$user'"; 
        $q = pg_query($sql); 

        $exito = 0;
        while ($data = pg_fetch_row($q)){
            echo "<script type='text/javascript'>alert('$user');</script>";
            $exito++;
        }
        echo $exito;
        $result = $user;
        if ($exito > 0) {
            return True;
        } else {
            return False;
        }
        
    } 

/*Luego haremos una serie de condicionales que identificaran el momento en el boton de login es presionado y cuando este sea presionado llamaremos a la función verificar_login() pasandole los parámetros ingresados:*/

if(!isset($_SESSION['userid'])) //para saber si existe o no ya la variable de sesión que se va a crear cuando el usuario se logee
{ 
    if(isset($_POST['login'])) //Si la primera condición no pasa, haremos otra preguntando si el boton de login     fue presionado
    { 
        if(verificar_login($_POST['user'],$_POST['password'],$result)) //Si el boton fue presionado llamamos a la función verificar_login() dentro de otra condición preguntando si resulta verdadero y le pasamos los valores ingresados como parámetros.
        { 
            session_start();
            /*Si el login fue correcto, registramos la variable de sesión y al mismo tiempo refrescamos la pagina index.php.*/ 
            $_SESSION['userid'] = $result->idusuario; 
            $_SESSION['user'] = 'Holaa!!!!!';
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