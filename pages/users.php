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


   function generatePassword($length = 6) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $password = '';
      for ($i = 0; $i < $length; $i++) {
         $password .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $password;
   }

   // Example usage
   $password = generatePassword();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
   <!-- Addd User Modal -->
<div class="modal fade" id="adduser" role="dialog">
            <div class="modal-dialog">
               <div style="background-color:snow;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-dark" id="exampleModalLabel">ADDING USER</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">

                       
                            
                                    <!-- fullname -->
                                <div class="form-group text-dark">
                                     <label for="">Employee Name:</label>
                                      <div id="EN_input">
                                          
                                      </div>
                               </div>
                          

                          
                              <!--Role -->
                              <div class="form-group text-dark">
                                 <label for="">Role:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-user text-light"></i>
                                       </span>
                                       <select class="form-select" id="role">
                                          <option value="vendor">vendor</option>
                                          <option value="admin">admin</option>
                                          <option value="stocker">stocker</option>

                                       </select>           
                                    </div>
                              </div>
                          
                           
                                <!-- username -->
                                <div class="form-group text-dark">
                                     <label for="">Username:</label>
                                     <select class="form-select" id="username">
                                          <option value="user 1">user 1</option>
                                          <option value="user 2">user 2</option>
                                          <option value="user 3">user 3</option>
                                          <option value="user 4">user 4</option>
                                          <option value="user 5">user 5</option>
                                       </select>            
                                      </div>
                               </div>

                                <!-- password -->
                                 <div class="form-group text-dark">
                                    <label for="">Password:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                          <i class="fas fa-address-book text-light"></i>                              
                                       </span>
                                             <input type="text" class="form-control" id="password"  value="<?php echo $password ?>"  autocomplete="off" required="required">            
                                    </div>
                                 </div>
                              
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="addUser()">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
               </div>
            </form>
            </div>
            </div>
         </div>
<!-- End - Insert Employee modal  -->


<!-- Edit user modal -->
<div class="modal fade" id="edituser" role="dialog">
            <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">EDITING OR UPDATING user</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


            <!-- fullname -->
                          <div class="form-group text-light">
                                     <label for="">Employee Name:</label>
                                      <div class="input-group mb-3" id="EN_Update">
                                          
                                      </div>
                               </div>
                          

                          
                              <!--Role -->
                              <div class="form-group text-light">
                                 <label for="">Role:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-user text-light"></i>
                                       </span>
                                       <select class="form-select" id="updateRole">
                                          <option value="vendor">vendor</option>
                                          <option value="admin">admin</option>
                                          <option value="stocker">stocker</option>
                                       </select>           
                                    </div>
                              </div>
                        
                           
                                <!-- username -->
                                <div class="form-group text-light">
                                     <label for="">Username:</label>
                                     <select class="form-select" id="updateUName">
                                          <option value="user 1">user 1</option>
                                          <option value="user 2">user 2</option>
                                          <option value="user 3">user 3</option>
                                          <option value="user 4">user 4</option>
                                          <option value="user 5">user 5</option>
                                       </select>
                               </div>

                           
                           
                                <!-- password -->
                                 <div class="form-group text-light">
                                    <label for="">Password:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                          <i class="fas fa-address-book text-light"></i>                              
                                       </span>
                                             <input type="text" class="form-control" id="updatePassword"  autocomplete="off" required="required">            
                                    </div>
                                 </div>
               </div>
            </form>
               <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="updateDetails()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">

               </div>
            </div> 
         </div>
</div>
<!-- End of edit user modal -->


<!-- Edit business name Modal -->
<div class="modal fade" id="editCompName" role="dialog">
   <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">CHANGE YOUR BUSINESS NAME</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  
                        <!-- Change Business Name -->
                        <div class="form-group text-light">
                           <label for="">Business Name:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                              <input type="text" class="form-control" placeholder="Enter your new Business name" autocomplete="off" id="updatecompName" required="required">            
                           </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="updateCompDetails()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddenCompdata">
                  </div>
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
			<li>
				<a href="../pages/employees.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Employees</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu p-0">
			<li class='active'>
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
					<h1>USERS</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">users</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>

            <a href="#" class="btn-inventory bg-dark" data-bs-toggle="modal" data-bs-target="#editCompName" >
                <i style="color:red;" class='bx bxs-cog' ></i>
                <span style="color:#fff;" class="text">Change Business Name</span>
				</a>
				
				<a href="userExport.php" class="btn-download">
					<i style="color:#fff;" class='bx bxs-cloud-download' ></i>
					<span style="color:#fff;" class="text">Export To Excel</span>
				</a>
			</div>

			
			<!-- users table -->
			<div class="table-data">
               <div class="recent">
                  <div class="head">
                     <h3>All Users</h3>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#adduser">+</a> 
                     <form action="#">
                        <div class="form-input">
                           <input id="search" type="text" placeholder="Search..." class="bg-light">
                           <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
                        </div>
                     </form>
                     <i class='bx bx-filter' ></i>
                  </div>
                  <div id="userTable">
                   
                  </div>
               </div>
          </div>

                    <!--success alert -->
            <div id="updateSuccessAlert" class="alert alert-success" style="display:none;">
               Update successful.
            </div>

        </main>
		<!-- main -->
	</section>
	<!-- content -->



    <script src="../js/template.js"></script>
    <script src="../js/employees.js"></script>
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
                displayUser();
            });

            // display function
            function displayUser(){
            var displayUser="true";
            $.ajax({
                url:"userTable.php",
                type:'POST',
                data:{
                displaySend:displayUser
                },
                success:function(data,status){
                $('#userTable').html(data);
                }
            })
            }





            
       // Add User
      function addUser(){
       var FNameAdd=$('#Names').val();
       var RoleAdd=$('#role').val();
       var UNameAdd=$('#username').val();
       var PasswordAdd=$('#password').val(); 

       $.ajax({
           url:"userAdd.php",
           type:'post',
           data:{
              FNameSend:FNameAdd,
              RoleSend:RoleAdd,
              UNameSend:UNameAdd,
              PasswordSend:PasswordAdd
              
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#adduser').modal('hide');
             displayUser();
            location.reload();//refreshes the page
           }
        });
  }


   
   // Update User function
   function GetDetails(updateid){
      $('#hiddendata').val(updateid);

      $.post("userUpdate.php",{updateid:updateid},function(data,status){
         var userid=JSON.parse(data);
         $('#updateFName').val(userid.EmpName);
         $('#updateRole').val(userid.role);
         $('#updateUName').val(userid.username);
         $('#updatePassword').val(userid.password);
      });

         $('#edituser').modal('show');
   }

   // onclick update event function
   function updateDetails(){
   var updateFName=$('#updateNames').val();
   var updateRole=$('#updateRole').val();
   var updateUName=$('#updateUName').val();
   var updatePassword=$('#updatePassword').val();

   var hiddendata=$('#hiddendata').val();

   $.post("userUpdate.php",{
      updateFName:updateFName,
      updateRole:updateRole,
      updateUName:updateUName,
      updatePassword:updatePassword,

      hiddendata:hiddendata

   },function(data,status){
   $('#edituser').modal('hide');
   displayUser();
   })
   }

   


   // Delete Employee
  function DeleteUser(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this user account?");
    if (confirmation) {
        $.ajax({
            url: "userDelete.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayUser();
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
               url:"userSearch.php",
               method:"POST",
               data:{input:input},

               success:function(data){
                  $("#userTable").html(data);
               }
             });  
        }else{
            location.reload();
             $("#userTable").css("display","block");
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
         url: 'userTable.php', // Replace with the path to your PHP file
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
         url: 'userTable.php', // Replace with the path to your PHP file
         type: 'POST',
         data: {
            page: pageId,
            displaySend: 1,
            limit: limit
         },
         success: function(response) {
            $('#userTable').html(response);
         }
      });
   }
});

// onclick update event function
function updateCompDetails() {
    var updatecompName = $('#updatecompName').val();
    var hiddenCompdata = $('#hiddenCompdata').val();

    if (confirm("Are you sure you want to update the Business name?")) {
        $.post("changeComp.php", {
            updatecompName: updatecompName,
            hiddenCompdata: hiddenCompdata
        }, function(data, status) {
            $('#editCompName').modal('hide');
            displayComp();

            // Shows a Bootstrap success alert indicating the update was successful
            $('#updateSuccessAlert').fadeIn().delay(2000).fadeOut();

            // Reload the page after completing the function
            location.reload();
        });
    }
   }


//   end pagination


// Display Employee Names When Adding user
$(document).ready(function(){
	displayEName();
});

// display function
function displayEName(){
var displayEName="true";
$.ajax({
	url:"empInput.php",
	type:'POST',
	data:{
      displayEName:displayEName
	},
	success:function(data,status){
	$('#EN_input').html(data);
	}
})
}

// Update Employee Names When Adding user
$(document).ready(function(){
	displayUpdate();
});

// display function
function displayUpdate(){
var displayUpdate="true";
$.ajax({
	url:"empInUpdate.php",
	type:'POST',
	data:{
      displayUpdate:displayUpdate
	},
	success:function(data,status){
	$('#EN_Update').html(data);
	}
})
}



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


    </script>

</body>
</html>