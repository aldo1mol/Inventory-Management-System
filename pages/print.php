<?php
session_start();
include "../include/config.php";


// if (
//     isset($_SESSION['username']) && isset($_SESSION['role']) &&
//     (
//         ($_SESSION['username'] !== 'user 1' && $_SESSION['username'] !== 'user 2')
//         ||
//         ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'vendor')
//     )
// ) {
//     // User is logged in, and the 'username' and 'role' keys exist in the session,
//     // but the conditions for access are not met
//     header('Location: 404.php');
//     exit();
// }

?>


<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RMS</title>
	<link rel="shortcut icon" href="https://boxicons.com/?query=shopping+bag">
    <!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
    <!-- <link rel="stylesheet" href="../lib/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
	<link rel="stylesheet" href="../css/template.css">
    <link rel="stylesheet" href="../css/print.css">
    <style>
 #customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 500px;
    margin-top: 0;
    margin-left: 0;
  }
  
  #customers td, #customers th {
    /* border: 1px solid #ddd; */
    border: none;
    padding: 8px;
  }
  
  #customers tr:nth-child(even){background-color: #f2f2f2;}
  
  #customers tr:hover {background-color: #ddd;}
  
  #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }
    </style>
 </head>
    <body>
         
                  <div id="printTable">
                   
                  </div>
              <a href="" id="printButton" style="margin-left: 50px;" class="btn btn-primary my-5 w-25">Print</a>   

 <!-- <script src="../lib/bootstrap.min.js"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.6.4.js"></script>
    <script src="../js/template.js"></script>
    <script>
    // display database table
    $(document).ready(function(){
        displayPrint();
    });

    // display function
    function displayPrint(){
    var displayPrint="true";
    $.ajax({
        url:"printTable.php",
        type:'POST',
        data:{
        displaySend:displayPrint
        },
        success:function(data,status){
        $('#printTable').html(data);
        }
    })
    }

// PRINT TABLE
    $(document).ready(function() {
    // Function to print the table
    function printTable() {
        var printContents = document.getElementById("printTable").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    // Bind the function to the click event of the print button
    $('#printButton').on('click', function() {
        printTable();
    });
});


// display customer input
$(document).ready(function(){
    displayCNInput();
});

// display function
function displayCNInput(){
var displayCNInput="true";
$.ajax({
    url:"printCN.php",
    type:'POST',
    data:{
    displayCustomer:displayCNInput
    },
    success:function(data,status){
    $('#CN').html(data);
    }
})
}


// served by
 // display Category Input
 $(document).ready(function(){
        displaySB();
    });

    // display function
    function displaySB(){
    var displaySB="true";
    $.ajax({
        url:"printServe.php",
        type:'POST',
        data:{
        displaySB:displaySB
        },
        success:function(data,status){
        $('#SB_input').html(data);
        }
    })
}
 </script>
     
    </body>
</html>