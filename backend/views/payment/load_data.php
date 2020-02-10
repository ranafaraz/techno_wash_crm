<?PHP

if(isset($_POST['date']) && isset($_POST['id']))
{
	$date = $_POST['date'];
	$id = $_POST['id'];
	echo $date;
	echo $id;
}
?>