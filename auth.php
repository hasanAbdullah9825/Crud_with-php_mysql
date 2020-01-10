
<?php
session_name('au_session');
session_start(['cookie_lifetime'=>300]);
//session_destroy();
$error=false;

$fp=fopen("C:\\xampp\\htdocs\\dashboard\\Crud\\data\\users.txt","r");

$username=filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
$password=filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);

if($username&&$password)
{   $_SESSION['loggedin']=false; 
    $_SESSION['role']=false; 
    while ($data=fgetcsv($fp)) {
        if( $data[0]==$username && $data[1]==md5($password))
        {
          $_SESSION['loggedin']=true;
          $_SESSION['role']=$data[2];  
          echo "hello";
        }

       
    }


   if($_SESSION['loggedin']==false)
   {
    $error=1;
   }

}





if(isset($_GET['logout'])){
    $_SESSION['loggedin'] = false;
    session_destroy();
    header('location:index.php');
}

?>










<!DOCTYPE html>
<html>
<head>
	<title>Form example</title>

	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>
<body>
	<div class="container">
		
 <div class="row">
        <div class="column column-60 column-offset-20">

            <?php
           

            if($error)
            {
                echo "<blockquote>Username and Password did not match </blockquote>";
            }

            
            ?>
        </div>
    </div>

<div class="row" style="margin-top:100px;">
        <div class="column column-60 column-offset-20">
            
            <?php 

            if(false == $_SESSION['loggedin']):

                ?>
                <form action="auth.php" method="POST">
                    <label for=username>Username</label>
                    <input type="text" name='username' id="username">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <button type="submit" class="button-primary" name="submit">Log In</button>
                </form>
           
            <?php
            endif;
            ?>
        </div>
    </div>
</div>
</body>
</html>