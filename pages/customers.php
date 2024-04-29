<?php
session_start();
include "../include/config.php";

$CompNameSQL = mysqli_query($conn, "SELECT CompanyName FROM settings");
$Comp_row = mysqli_fetch_assoc($CompNameSQL);
$CompName = $Comp_row['CompanyName'];

// if ($_SESSION['username'] !== 'user 1'  && $_SESSION['role'] !== 'admin') {
//    // User is logged in but is not the user with username $user and not an admin
//    header('Location: 404.php');
//    exit();
// }

$employeesSQL = mysqli_query($conn,"SELECT * FROM employees");
$total_employees = mysqli_num_rows($employeesSQL);

$customerSQL = mysqli_query($conn,"SELECT * FROM customers GROUP BY CustomerName");
$total_customers = mysqli_num_rows($customerSQL);

$suppliersSQL = mysqli_query($conn,"SELECT * FROM suppliers");
$total_suppliers = mysqli_num_rows($suppliersSQL);

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Boxicons -->
	<!-- My CSS -->
    <!-- <link rel="stylesheet" href="../lib/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
	<link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="../css/template.css">
    <!-- <link rel="stylesheet" href="../css/employee.css"> -->
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

 <!-- Edit employee modal -->
 <div class="modal fade" id="editemployee" role="dialog">
            <div class="modal-dialog">
               <div class="modal-content bg-warning">
                  <div class="modal-header">
                     <h5 class="modal-title text-light" id="exampleModalLabel">EDIT AND UPDATE EMPLOYEE DETAILS</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">

                       <div class="row">
                            <div class="col">
                                    <!-- fullname -->
                                <div class="form-group text-dark">
                                     <label for="">Name:</label>
                                      <div class="input-group mb-3">
                                          <span class="input-group-text bg-dark">
                                                <i class="fas fa-user text-light"></i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Enter your full name" id="updateEmpName"  autocomplete="off" required="required">            
                                      </div>
                               </div>
                          </div>

                          <div class="col">
                              <!-- gender -->
                              <div class="form-group text-dark">
                                 <label for="">Gender:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-user text-light"></i>
                                       </span>
                                       <select class="form-select" id="updategender">
                                          <option value="Female">Female</option>
                                          <option value="Male">Male</option>
                                       </select>           
                                    </div>
                              </div>
                          </div>

                       </div>
                        

                        <div class="row">
                           <div class="col">
                              <!-- Email -->
                              <div class="form-group text-dark">
                                 <label for="">Email:</label>
                                 <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark">
                                       <i class="fas fa-envelope text-light"></i>                              
                                    </span>
                                       <input type="text" class="form-control" placeholder="name@gmail.com" id="updateemail"  autocomplete="off" required="required">            
                                 </div>
                              </div>

                           </div>
                           <div class="col">
                                <!-- address -->
                                 <div class="form-group text-dark">
                                    <label for="">Address:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                          <i class="fas fa-address-book text-light"></i>                              
                                       </span>
                                             <input type="textarea" class="form-control" id="updateaddress"  autocomplete="off" required="required">            
                                    </div>
                                 </div>
                            </div>
                        </div>
                       
                        
                        

                        <div class="row">
                            
                            <div class="col">
                                 <!-- mobile -->
                                 <div class="form-group text-dark">
                                    <label for="">Mobile:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-phone text-light"></i>
                                       </span>
                                             <input type="text" class="form-control" placeholder="Enter employee's contact" id="updatephone" 
                                             autocomplete="off" maxlength="10" minlength="10"  required="required">            
                                    </div>
                                 </div>
                           </div>
                           <div class="col">
                                    <!-- Role -->
                              <div class="form-group text-dark">
                                    <label for="">Role:</label>
                                 <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark">
                                       <i class="fa-sharp fa-solid fa-briefcase"></i>                                       
                                    </span>
                                       <select class="form-select"  aria-label="Default select example" id="updaterole">
                                          <option value="Stocker">Stocker</option>
                                          <option value="Vendor">Vendor</option>
                                          <option value="branch Manager">Manager</option>
                                       </select>           
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <div class="row">
                           <div class="col">
                              <!-- Hire Date -->
                              <div class="form-group text-dark">
                                 <label for="">Hired Date:</label>
                                 <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark">
                                    <i class="fas fa-calendar-days text-light"></i>
                                    </span>
                                          <input type="date" class="form-control" id="updatehiredate"  autocomplete="off" required="required">            
                                 </div>
                              </div>
                           </div>

                           <div class="col">
                              <!-- Salary per month -->
                              <div class="form-group text-dark">
                                 <label for="">Salary per month:</label>
                                 <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark">
                                    <i class="fas fa-money-bill text-light"></i></span>
                                    <input type="number" class="form-control" placeholder="Enter salary" id="updatesalary" 
                                    autocomplete="off" step="0.01" min="0" maxlength="10"   required="required">                                 </div>
                              </div>
                           </div>
                        </div>
                       
                     </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-dark" onclick="updateDetails()" >Update</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">
                  </div>
                  
                  </form>
                </div>
               </div>
            </div>




 <!-- sidebar -->

 
    <!-- profile Modal -->
    <div class="modal fade" id="employeeprofile" role="dialog">
            <div class="modal-dialog">
               <div class="modal-content bg-primary">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Employee Profile <i class="fas fa-user-alt"></i></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body bg-dark">
                     <div class="container" id="profile">
                        <h6 class="text-light">Full Name: <input class="border-0 text-primary bg-dark" type="text" id="employeename"></h6>
                        <h6 class="text-light">Gender: <input class="border-0 text-primary bg-dark"  type="text" id="employeegender"></h6>
                        <h6 class="text-light">Email: <input class="border-0 text-primary bg-dark" type="text" id="employeeemail"></h6>
                        <h6 class="text-light">Address: <input class="border-0 text-primary bg-dark" type="text" id="employeeaddress"></h6>
                        <h6 class="text-light">Phone: <input class="border-0 text-primary bg-dark" type="text" id="employeephone"></h6>
                        <h6 class="text-light">Hire date: <input class="border-0 text-primary bg-dark" type="text" id="employeehiredate"></h6>
                        <h6 class="text-light">Role: <input class="border-0 text-primary bg-dark" type="text" id="employeerole"></h6>
                        <h6 class="text-light">Sarary/Month: <input class="border-0 text-primary bg-dark" type="text" id="customersalary"></h6>
                        <!-- <h6>Password: <input class="border-0 text-primary" type="text" id="employeepassword"></h6> -->

                     </div>

                  </div>
               <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">
               </div>
               

            </div>
               <!-- End of profile Modal -->

            </div>
         </div>
 <!-- End of profile -->






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
				<a href="../pages/customers.php">
					<i class='bx bxs-group' ></i>
					<span class="text">customers</span>
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
					<h1>Customers</h1>
					<ul class="breadcrumb">
						<li>
							<a href="employees.php">Employees</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<!-- <a href="suppliers.php" class="btn-inventory bg-dark" >
                <i style="color:#fff;" class='bx bxs-truck'></i>
                <span style="color:#fff;" class="text">Suppliers</span>
				</a>
				<a href="employees.php" class="btn-sell">
                <i style="color:#fff;" class='bx bxs-group'></i>
					<span style="color:#fff;" class="text">Employees</span>
				</a> -->
				<a href="cusExport.php" class="btn-download">
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

			<!-- Customer table -->
			<div class="table-data">
               <div class="recent">
                  <div class="head">
                     <h3>All Customers</h3>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#addemployee">+</a> 
                     <i class='bx bx-filter' ></i>
                  </div>
                  <!-- <div id="cusTable">
                   
                  </div> -->


                  <!-- Table -->
                  <table id="cusTable" class="table table-striped table-responsive" style="width:100%">
                        <thead>
                           <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Customer Name</th>
                              <th scope="col">Phone No.</th>
                              <th scope="col">Amt Spent</th>
                              <th scope="col">Served By</th> 
                              <th scope="col">Date</th> 
                              <th scope="col">Operations</th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include your MySQL connection configuration file
                            include "../include/config.php";

                            // Query to fetch data from the logbook table
                            $sql = "SELECT id,customerName,phone,AmtSpent,servedBy,`date` FROM customers ORDER BY id DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" .$row['id'] . "</td>";
                                    echo "<td>" . $row['customerName'] . "</td>";
                                    echo "<td class='text-start'>" . $row['phone'] . "</td>";
                                    echo "<td class='text-center'>" . $row['AmtSpent'] . "</td>";
                                    echo "<td>" . $row['servedBy'] . "</td>";
                                    echo "<td class='text-start'>" . $row['date'] . "</td>";
                                    // Edit and delete buttons
                                    echo "<td class='text-center'>";
                                       echo "<i class='bx bx-dots-vertical-rounded' onclick='toggleIcons(this)'></i>";
                                       echo "<a href='#' class='me-3 deleteuser hide-icons' title='Delete' onclick='DeleteUser(" . $row['id'] . ")'><i class='fas fa-trash-alt text-danger'></i></a>";
                                    echo "</td>";

                                    echo "</tr>";
                                }
                            }

                            // Close MySQL connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                  <!-- Table -->






               </div>
          </div>


        </main>
		<!-- main -->
	</section>
	<!-- content -->

    <!-- <script src="../lib/bootstrap.min.js"></script> -->
    <script src="../js/jquery-3.6.4.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    
    <!-- buttons -->
    <!-- <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>


    <script src="../js/template.js"></script>

    <script src="../js/customers.js"></script>
    <script>

 // jQuery code to toggle the display of icons at the operations field
      function toggleIcons(icon) {
        $(icon).siblings().toggleClass('hide-icons');
      }



      new DataTable('#cusTable', {
               layout: {
               topStart: {
                  buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
               }
            }
      });

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




   // Delete Customer
  function DeleteUser(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this customer?");
    if (confirmation) {
        $.ajax({
            url: "cusDelete.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayCus();
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
               url:"custSearch.php",
               method:"POST",
               data:{input:input},

               success:function(data){
                  $("#cusTable").html(data);
               }
             });  
        }else{
            location.reload();
             $("#cusTable").css("display","block");
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
         url: 'cusTable.php', // Replace with the path to your PHP file
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
         url: 'cusTable.php', // Replace with the path to your PHP file
         type: 'POST',
         data: {
            page: pageId,
            displaySend: 1,
            limit: limit
         },
         success: function(response) {
            $('#cusTable').html(response);
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

//   end pagination


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
    </script>

</body>
</html>