<?php 
include"../include/config.php";

if(isset($_POST['updateid'])){
    $id=$_POST['updateid'];

    $sql="SELECT * FROM sales WHERE ID=$id";
    $result=mysqli_query($conn,$sql);
    $response=array();
    while($row=mysqli_fetch_assoc($result)){
        $response=$row;
    }
    echo json_encode($response);
    }else{
        $response['status']=200;
        $response['message']="Invalid or data not found";
    }
    
?>