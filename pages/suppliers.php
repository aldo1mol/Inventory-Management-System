<?php
session_start();
include "../include/config.php";

$CompNameSQL = mysqli_query($conn, "SELECT CompanyName FROM settings");
$Comp_row = mysqli_fetch_assoc($CompNameSQL);
$CompName = $Comp_row['CompanyName'];

if (!isset($_SESSION['username'])){
   // If user is not loggend in send to login page
   header('Location: ../index.php');
   exit();
}

// if ($_SESSION['username'] !== 'user 1'  && $_SESSION['role'] !== 'admin') {
//    // User is logged in but is not the user with username $user and not an admin
//    header('Location: 404.php');
//    exit();
// }

$employeesSQL = mysqli_query($conn,"SELECT * FROM employees");
$total_employees = mysqli_num_rows($employeesSQL);

$suppliersSQL = mysqli_query($conn,"SELECT * FROM suppliers");
$total_suppliers = mysqli_num_rows($suppliersSQL);

$customersSQL = mysqli_query($conn,"SELECT * FROM customers GROUP BY CustomerName");
$total_customers = mysqli_num_rows($customersSQL);

$noteSQL = mysqli_query($conn, "SELECT * FROM `notification`"); 
$total_messages = mysqli_num_rows($noteSQL);
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
	<link rel="stylesheet" href="../css/employee.css">
   <style>
      .bx-dots-vertical-rounded{
         cursor: pointer;
       }

      .hide-icons{
         display: none;
      }

      .pagination{
         cursor: pointer;
      }
   </style>
</head>
<body>
<!--Add Supplier modal -->
<div class="modal fade" id="addsupplier" role="dialog">
            <div class="modal-dialog">
               <div style="background-color:#d5dee3;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-dark" id="exampleModalLabel">ADDING SUPPLIER</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">

                      
                            <div class="col">
                                    <!-- fullname -->
                                <div class="form-group text-dark">
                                     <label for="">Company Name:</label>
                                      <div class="input-group mb-3">
                                          <span class="input-group-text bg-dark">
                                                <i class="fas fa-user text-light"></i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Company name" id="companyName"  autocomplete="off" required="required">            
                                      </div>
                               </div>
                          </div>                      
                                               

                            
                            <div class="col">
                                 <!-- Contact -->
                                 <div class="form-group text-dark">
                                    <label for="">Contact:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-phone text-light"></i>
                                       </span>
                                             <input type="text" class="form-control" placeholder="Enter Company's contact" id="contact" 
                                             autocomplete="off" maxlength="10" minlength="10"  required="required">            
                                    </div>
                                 </div>
                           </div>
                              
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="addsupplier()">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
                  </div>
            </form>
            </div>
            </div>
         </div>
<!-- End - Add Supplier modal  -->


 <!-- Edit employee modal -->
 <div class="modal fade" id="editsupplier" role="dialog">
            <div class="modal-dialog">
               <div class="modal-content bg-warning">
                  <div class="modal-header">
                     <h5 class="modal-title text-light" id="exampleModalLabel">EDIT AND UPDATE SUPPLIER DETAILS</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">

                         <div class="col">
                                    <!-- fullname -->
                                <div class="form-group text-dark">
                                     <label for="">Company Name:</label>
                                      <div class="input-group mb-3">
                                          <span class="input-group-text bg-dark">
                                                <i class="fas fa-user text-light"></i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Company name" id="updateCompName"  autocomplete="off" required="required">            
                                      </div>
                               </div>
                          </div>                      
                                               

                            
                            <div class="col">
                                 <!-- Contact -->
                                 <div class="form-group text-dark">
                                    <label for="">Contact:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-phone text-light"></i>
                                       </span>
                                             <input type="text" class="form-control" placeholder="Enter Company's contact" id="updateContact" 
                                             autocomplete="off" maxlength="10" minlength="10"  required="required">            
                                    </div>
                                 </div>
                           </div>
                        

                       
                  <div class="modal-footer">
                     <button type="button" class="btn btn-dark" onclick="updateDetails()" >Update</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">
                  </div>
                  </div>
                  </form>
                </div>
               </div>
            </div>

 

<!-- Notification modal -->
<div  class="modal fade" id="notemodal" role="dialog">
  <div class="modal-dialog">
    <div  class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalLabel">NOTIFICATION</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="note">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="clear-note">Clear Notification</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>









<section  id="sidebar">
        <a href="dashboard.php" class="brand">
            <i class="bx bxs-shopping-bag"></i>
            <span class="text"><?php echo $CompName ?></span>
        </a>

        <ul class="side-menu top p-0">
            <li >
				<a href="../pages/dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../pages/admin_prod.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="../pages/analytics.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="sale.php">
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">Sales</span>
				</a>
			</li>
			<li class="active">
				<a href="../pages/employees.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Employees</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu p-0">
			<li>
				<a href="../pages/users.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">User Settings</span>
				</a>
			</li>
			<li>
				<a href="../index.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
       </ul>
    </section>
    <!-- sidebar -->
     
    
	<!-- content -->
	<section id="content">
		<!-- navbar -->
        <?php
		   include "../include/navbar.php"
        ?>
		<!-- navbar -->

		<!-- main -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Suppliers</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Suppliers</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<!-- <a href="employees.php" class="btn-inventory bg-dark" >
                <i style="color:#fff;" class='bx bxs-group'></i>
                <span style="color:#fff;" class="text">Employees</span>
				</a>
				<a href="customers.php" class="btn-sell">
                <i style="color:#fff;" class='bx bxs-group'></i>
					<span style="color:#fff;" class="text">Customers</span>
				</a> -->
				<a href="supExport.php" class="btn-download">
					<i style="color:#fff;" class='bx bxs-cloud-download' ></i>
					<span style="color:#fff;" class="text">Export To Excel</span>
				</a>
			</div>

         <ul class="box-info">
         <a href="employees.php"><li>
         <i style="background-color: #B95F00; color: #ffff" class="bx bxs-group"></i>
					<span class="text">
						<h3><?php echo $total_employees?></h3>
						<p>Employees</p>
					</span>
				</li></a>
            <a href="suppliers.php"><li>
            <i style="background-color: #50506C; color:#ffff;" class='bx bxs-truck'></i>
					<span class="text">
						<h3><?php echo $total_suppliers?></h3>
						<p>Suppliers</p>
					</span>
				</li></a>
            <a href="customers.php"><li>
					<i class="bx bxs-calendar-check"></i>
					<span class="text">
						<h3><?php echo $total_customers?></h3>
						<p>Customers</p>
					</span>
				</li></a>
			</ul>

			<!-- Suppliers table -->
			<div class="table-data">
               <div class="recent">
                  <div class="head">
                     <h3>All Suppliers</h3>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#addsupplier">+</a> 
                     <form action="#">
                        <div class="form-input">
                           <input id="search" type="text" placeholder="Search..." class="bg-light">
                           <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
                        </div>
                     </form>
                     <i class='bx bx-filter' ></i>
                  </div>
                  <!-- Suppliers table -->
                      
                  <!-- Suppliers -->
               </div>
          </div>


        </main>
		<!-- main -->
	</section>
	<!-- content -->



    <script src="../js/template.js"></script>
    <script src="../js/employees.js"></script>
    <!-- <script src="../lib/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.6.4.js"></script>
    <script>

 // jQuery code to toggle the display of icons at the operations field
      function toggleIcons(icon) {
        $(icon).siblings().toggleClass('hide-icons');
      }





// search input show and hide
      $(document).ready(function() {
         const searchButton = $('.table-data .recent .head form .form-input button');
         const searchButtonIcon = $('.table-data .recent .head form .form-input button i');
         const searchInput = $('.table-data .recent .head form .form-input input');

         // Hide the search input initially
         searchInput.hide();

         searchButton.on('click', function(e) {
            e.preventDefault();
            
            // Toggle the visibility of the search input
            searchInput.toggle();

            if (searchInput.is(':visible')) {
               searchButtonIcon.removeClass('bx-search').addClass('bx-x');
            } else {
               searchButtonIcon.removeClass('bx-x').addClass('bx-search');
            }
         });
      });





      // display database table
            $(document).ready(function(){
                displaySup();
            });

            // display function
            function displaySup(){
            var displaySup="true";
            $.ajax({
                url:"supTable.php",
                type:'POST',
                data:{
                displaySend:displaySup
                },
                success:function(data,status){
                $('#supTable').html(data);
                }
            })
            }





            
       // Add Supplier
      function addsupplier(){
       var CompNameAdd=$('#companyName').val();
       var ContactAdd=$('#contact').val();
      


       

       $.ajax({
           url:"supAdd.php",
           type:'post',
           data:{
              CompNameSend:CompNameAdd,
              ContactSend:ContactAdd              
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#addsupplier').modal('hide');
             displayEmp();
            location.reload();//refreshes the page
           }
        });
  }


   
   // Update Supplier function
   function GetDetails(updateid){
      $('#hiddendata').val(updateid);

      $.post("supUpdate.php",{updateid:updateid},function(data,status){
         var userid=JSON.parse(data);
         $('#updateCompName').val(userid.companyName);
         $('#updateContact').val(userid.contact);
      });

         $('#editsupplier').modal('show');
   }

   // onclick update event function
   function updateDetails(){
   var updateCompName=$('#updateCompName').val();
   var updateContact=$('#updateContact').val();
   

   var hiddendata=$('#hiddendata').val();

   $.post("supUpdate.php",{
      updateCompName:updateCompName,
      updateContact:updateContact,

      hiddendata:hiddendata

   },function(data,status){
   $('#editsupplier').modal('hide');
   displaySup();
   })
   }

   


   // Delete Supplier
  function DelSup(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete supplier?");
    if (confirmation) {
        $.ajax({
            url: "supDel.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displaySup();
            }
        });
    }
}




   // search bar
$(document).ready(function(){
      $("#search").on("keyup", function() {
        var input = $(this).val();
        //alert(input);
        if(input != ""){
             $.ajax({
               url:"supSearch.php",
               method:"POST",
               data:{input:input},

               success:function(data){
                  $("#supTable").html(data);
               }
             });  
        }else{
            location.reload();
             $("#supTable").css("display","block");
        }
      });
    });

   

   // Code For pagination and limit

   $(document).ready(function() {
   // Display table on page load
   displayTable(1);

   // Page navigation click event
   $(document).on("click", ".pagination li span", function(e) {
      e.preventDefault();
      var pageId = $(this).attr('id');
      displayTable(pageId);
   });

   // Limit input change event
   $(document).on("change", "#updateLimit", function() {
      var limit = $(this).val();
      updateLimit(limit, function() {
         displayTable(1, limit);
      });
   });

   // Update limit value function
   function updateLimit(limit, callback) {
      $.ajax({
         url: 'supTable.php', // Replace with the path to your PHP file
         type: 'POST',
         data: {
            updateLimit: limit
         },
         success: function(response) {
            // Update the limit value immediately
            callback();
         }
      });
   }

   // Display table function
   function displayTable(pageId, limit) {
      $.ajax({
         url: 'supTable.php', // Replace with the path to your PHP file
         type: 'POST',
         data: {
            page: pageId,
            displaySend: 1,
            limit: limit
         },
         success: function(response) {
            $('#supTable').html(response);
         }
      });
   }
});



// display Notification
$(document).ready(function(){
		   displayNote();
	   });

	   // display function
	   function displayNote(){
	   var displayNote="true";
	   $.ajax({
		   url:"notification.php",
		   type:'POST',
		   data:{
            displayMessages:displayNote
		   },
		   success:function(data,status){
		   $('#note').html(data);
		   }
	})
}


 // Delete notification
 function DeleteNote(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this notification?");
    if (confirmation) {
        $.ajax({
            url: "delNote.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayNote();
            }
        });
    }
}



 //clear notification function
 $(document).ready(function() {
			$('#clear-note').on('click', function() {
				if(confirm("Are you sure you want to clear all notifications?")) {
				$.ajax({
					url: 'clearNote.php',
					method: 'POST',
					data: {clearNote: 1},
					success: function(response){
					alert(response);
					// Reload the cart modal to show updated cart contents
					location.reload();
					}
				});
				}
			});
		});	
//   end pagination
    </script>

</body>
</html>