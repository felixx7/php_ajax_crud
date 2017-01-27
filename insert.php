<?php
	include 'config.php';
	$nama 		= $_POST['nama'];
	$email 		= $_POST['email'];
	$alamat		= $_POST['alamat'];
	$action 	= $_POST['action'];
	$id 		= $_POST['id'];

	if($action == 'add')
	{
		$sql = "INSERT INTO biodata (id, nama, email, alamat) VALUES (NULL, '$nama', '$email', '$alamat')";
		$query = mysqli_query($conn, $sql);
		if($query)
		{
			$retrive_sql = "SELECT * FROM biodata WHERE id = (SELECT MAX(id) FROM biodata)";
			$retrive_query = mysqli_query($conn, $retrive_sql);
			if($retrive_query)
			{
				$data = mysqli_fetch_assoc($retrive_query);
				echo json_encode($data);
			}
		}
		else
		{
			$data = array("valid" =>false, "msg"=>"Data not inserted.");
			echo json_encode($data);
		}
	}

	else
    {

        $sql = "UPDATE biodata SET nama = '$nama', email = '$email' , alamat = '$alamat' WHERE id = '$id' ";
        
        $query = mysqli_query($conn, $sql);
        if($query)
        {
            $data = array("valid"=>true, "msg"=>"Data successfully updated.");
            echo json_encode($data);
        }
        else
        {
            $data = array("valid"=>false, "msg"=>"Data not updated.");
            echo json_encode($data);
        }   
    }
?>