<?php
   $conn = new mysqli('localhost','root','','ajax_crud');
   extract($_POST);
  
  //read or view user

   if (isset($_POST['readuser'])) {
   	    $data = '<table class="table table-bordered table-striped">
                  <tr>
                      <th>S.NO</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Edit</th>
                      <th>Delete</th>
                  </tr>';


                  $sql = "SELECT * FROM users";
                  $result = mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)>0) {
                  	$number = 1;
                  	while ($row = mysqli_fetch_array($result)) {
                  	$data .='<tr>
                  		    <td>'.$number.'</td>
                  		    <td>'.$row['fname'].'</td>
                  		    <td>'.$row['lname'].'</td>
                  		    <td>'.$row['email'].'</td>
                  		    <td>'.$row['mobile'].'</td>
                  		    <td>
                  		       <button class="btn btn-success" onclick ="getUser('.$row['id'].')" >Edit</button>
                  		    </td>
                  		    <td>
                  		       <button class="btn btn-danger" onclick ="deleteUser('.$row['id'].')" >Delete</button>
                  		    </td>

                  		 </tr>';
                  		 $number++;
                  	}
                  }

   	        $data.='</table>';
   	        echo $data;
   }
   
   //insert user
   if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['mobile']) ) {
   	$sql = "INSERT INTO users(fname,lname,email,mobile)VALUES('$fname','$lname','$email','$mobile')";
   	mysqli_query($conn,$sql);
   }

   //delete user

   if (isset($_POST['deleteid'])) {
   	$userid = $_POST['deleteid'];
   	$sql = "DELETE FROM users WHERE id = '$userid' ";
   	mysqli_query($conn,$sql);
   }

   //edit

   if (isset($_POST['id']) && isset($_POST['id']) != "") {
   $id = $_POST['id'];

   $sql = "SELECT * FROM users WHERE id = '$id' ";
        if (!$result = mysqli_query($conn,$sql)) {
        	exit(mysql_error());
        }

        $response = array();
        if (mysqli_num_rows($result)>0) {
        	while ($row = mysqli_fetch_assoc($result)) {
        		$response = $row;
        	}
        }
    else{
    	$response['status'] = 200;
    	$response['message'] = "Data not found";
    }
    echo json_encode($response);
   }else{
   	$response['status'] = 200;
   	$response['message'] = "Data invalid";
   }

   //update 
   if (isset($_POST['newhidden_user_id'])) {
   	$id = $_POST['newhidden_user_id'];
   	$newfname = $_POST['newfname'];
   	$newlname = $_POST['newlname'];
   	$newemail = $_POST['newemail'];
   	$newmobile = $_POST['newmobile'];

   	$sql = "UPDATE users SET fname = '$newfname',lname='$newlname',email = '$newemail',mobile='$newmobile' WHERE id ='$id' ";
   	mysqli_query($conn,$sql);

   }

?>