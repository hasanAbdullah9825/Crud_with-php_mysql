<?php

define('DB_NAME','C:\\xampp\\htdocs\\dashboard\\Crud\\data\\f1.txt');

function seed($filename)
{
$data=array(
	array(
		'id'=>1,
		'fname'=>"kamal",
		'lname'=>"Ahmed",
		'roll'=>12

	),

array(
		'id'=>2,
		'fname'=>"Jamal",
		'lname'=>"Ahmed",
		'roll'=>13

	),

array(
		'id'=>3,
		'fname'=>"Adrita",
		'lname'=>"Chowdhury",
		'roll'=>14

	),


array(
		'id'=>4,
		'fname'=>"Raz",
		'lname'=>"Islam",
		'roll'=>15

	),
array(
		'id'=>5,
		'fname'=>"Ayan",
		'lname'=>"Hussain",
		'roll'=>16

	)


);

$serializeData=serialize($data);
file_put_contents(DB_NAME, $serializeData,LOCK_EX);


}


function addStudent($fname,$lname,$roll)
{   
    $found=false;

    $serializeData = file_get_contents(DB_NAME);
	$students = unserialize($serializeData);
	foreach ($students as $student) {
		if($roll==$student['roll'])
		{
			$found=true;
			break;
		}
	}
     
     if(!$found)
     {
    

     $id=getId($students);

	 $student=array(
		'id'=>$id,
		'fname'=>$fname,
		'lname'=>$lname,
		'roll'=>$roll


	);
array_push($students,$student);
$serializedData=serialize($students);
file_put_contents(DB_NAME,$serializedData,LOCK_EX);
return true;

     }
     

return false;

}


function generateReport()
{

	$serializeData = file_get_contents(DB_NAME);
	$students = unserialize($serializeData);
	?>

	<table>
	<tr>
		<th>Name</th>
		<th>Roll</th>
		<?php if(isAdmin() || isEditor()):?>
		<th>Action</th>
	<?php endif;?>
	</tr>
	<?php foreach ($students as $student) {?>
		<tr>
		<td><?php printf("%s %s",$student['fname'],$student['lname']); ?></td>	
		<td><?php printf("%s",$student['roll']) ?></td>

		<?php if(isAdmin()): ?>
		<td><?php printf('<a href="index.php?task=edit&id=%s">Edit</a>|<a href="index.php?task=delete&id=%s">Delete</a>',$student['id'],$student['id']); ?></td>
		<?php elseif(isEditor()):?>
			<td><?php printf('<a href="index.php?task=edit&id=%s">Edit</a>',$student['id']); ?></td>
		<?php endif; ?>
			        

		</tr>

		
<?php
} 
?>	

	</table>
<?php	
}?>

<?php

function getStudent($id)
{
	$serializeData = file_get_contents(DB_NAME);
	$students = unserialize($serializeData);

	foreach ($students as $student)
	 {
	 	if($id==$student['id'])
	 	{
	 		return $student;
	 	}
		
	 }
	 return false;

}

function updateStudent($id,$fname,$lname,$roll)
{
	$found=false;
	$serializeData = file_get_contents(DB_NAME);
	$students = unserialize($serializeData);

	foreach ($students as $student)
	 {
		if($roll==$student['roll'] && $student['id']!=$id)
		{
			$found=true;
			break;
		}

	}


if(!$found)
{
    $students[$id-1]['fname']=$fname;
	$students[$id-1]['lname']=$lname;
	$students[$id-1]['roll']=$roll;

    $serializedData=serialize($students);
    file_put_contents(DB_NAME,$serializedData,LOCK_EX);
    return true;

}

return false;
	
}


function  deleteStudent($id)
{
	$serializeData = file_get_contents(DB_NAME);
	$students = unserialize($serializeData);

	unset($students[$id-1]);

	$serializedData=serialize($students);
    file_put_contents(DB_NAME,$serializedData,LOCK_EX);


}


function getId($students)
{
$maxId=max(array_column($students, 'id'));
return $maxId+1;

}


function isAdmin()
{
	if(isset($_SESSION['role']))
	{
		return 'admin'==$_SESSION['role'];


	}
}


function isEditor()
{
	if(isset($_SESSION['role']))
	{
		return 'editor'==$_SESSION['role'];


	}
}


