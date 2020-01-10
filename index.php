<?php 
require_once "inc/functions.php";
$task = $_GET['task']??'report';
$error = $_GET['error']??'0';
$info='';


if('seed'==$task)
{
seed(DB_NAME);
$info="seeding is complete";

}

if('delete'==$task)
{
  $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_STRING);
  deleteStudent($id);
  header('location:index.php?task=report');



}





$fname='';
$lname='';
$roll='';
$id='';

if(isset($_POST['submit']))
{

$fname=filter_input(INPUT_POST, 'fname',FILTER_SANITIZE_STRING);
$lname=filter_input(INPUT_POST, 'lname',FILTER_SANITIZE_STRING);
$roll =filter_input(INPUT_POST, 'roll',FILTER_SANITIZE_STRING);
$id   =filter_input(INPUT_POST, 'id',FILTER_SANITIZE_STRING);

if($id)
{

$result=updateStudent($id,$fname,$lname,$roll);

if($result)
{
 header('location:index.php?task=report');
}

  else
  {
    $error=1;
  }


}
else
{
  if($fname!=''&& $lname!='' && $roll!='')
{
    $result=addStudent($fname,$lname,$roll);


    if($result)
    {
      header('location:index.php?task=report');
    }
    else
    {
      $error=1;
    }
    
}


}



}

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  
  <title>Form Example</title>
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
      <h2>CRUD PROJECT</h2>
      <p>A simple project to perform crud operation using plain text file</p>
      <?php include_once 'inc/templates/nav.php'; ?>

 
      
    </div>

  </div>
<div class="row">
  <div class="column column-60 column-offset-20">
     <?php
            if($info!='')
                {echo "<p>$info</p>";}
            ?>

    
  </div>
  
</div>


<hr>
<?php



if('1'==$error):?>
 <div class="row">
          
      <div class="column column-60 column-offset-20">
          
        <blockquote>Duplicate Roll</blockquote>

      </div>

    </div>

  <?php endif;?>









    <?php if('report'==$task):?>
      <div class = "row">
        <div class = "column column-60 column-offset-20">
         <?php generateReport(); ?>
          

        </div>
        
      </div>
    <?php endif; ?>





     <?php if('add'== $task):?>
      <div class = "row">
        <div class = "column column-60 column-offset-20">
         <form action="index.php?task=add" method="POST">

          <label for="fname">First Name</label>
          <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" >
          <label for="lname">Last Name</label>
          <input type="text" name="lname" id="lname" value="<?php echo $lname;?>">
          <label for="roll">Roll</label>
          <input type="text" name="roll" id="roll" value="<?php echo $roll;?> ">
          <input type="submit" name="submit" value="Save">

         </form>
          
        </div>
        
      </div>
    <?php endif; ?>


<?php if('edit'== $task):
$id= filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
$student=getStudent($id);

if($student):
  ?>
      <div class = "row">
        <div class = "column column-60 column-offset-20">
         <form  method="POST">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <label for="fname">First Name</label>
          <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>" >
          <label for="lname">Last Name</label>
          <input type="text" name="lname" id="lname" value="<?php echo $student['lname']?>">
          <label for="roll">Roll</label>
          <input type="text" name="roll" id="roll" value="<?php echo $student['roll']?> ">
          <input type="submit" name="submit" value="Save">

         </form>
          
        </div>
        
      </div>
    <?php 
       endif; 
         endif; ?>




  

</div>

</body>
</html>

