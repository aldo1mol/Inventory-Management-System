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
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>   
	<link rel="stylesheet" href="../css/template.css">
	<link rel="stylesheet" href="../css/product.css">
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
<!-- Insert Employee modal -->
<div class="modal fade" id="addemployee" role="dialog">
            <div class="modal-dialog">
               <div style="background-color:#d5dee3;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-dark" id="exampleModalLabel">ADDING EMPLOYEE</h5>
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
                                          <input type="text" class="form-control" placeholder="Enter employee's full name" id="EmpName"  autocomplete="off" required="required">            
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
                                       <select class="form-select" id="gender">
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
                                       <input type="email" class="form-control" placeholder="name@gmail.com" id="email"  autocomplete="off" required="required">            
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
                                             <input type="textarea" class="form-control" id="address"  autocomplete="off" required="required">            
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
                                             <input type="text" class="form-control" placeholder="Enter employee's contact" id="phone" 
                                             autocomplete="off" maxlength="10" minlength="10"  required="required">            
                                    </div>
                                 </div>
                           </div>
                           <div class="col">
                                    <!-- Job -->
                                <div class="form-group text-dark">
                                     <label for="">Job:</label>
                                      <div class="input-group mb-3">
                                          <span class="input-group-text bg-dark">
                                                <i class="fas fa-user text-light"></i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Enter employee's job" id="role"  autocomplete="off" required="required">            
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
                                          <input type="date" class="form-control" id="hiredate"  autocomplete="off" required="required">            
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
                                    <input type="number" class="form-control" placeholder="Enter salary" id="salary" 
                                    autocomplete="off" step="0.01" min="0" maxlength="10"   required="required">                                 
                                 </div>
                              </div>
                           </div>
                        </div>

                              
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="addemployee()">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
               </div>
            </form>
            </div>
            </div>
         </div>
<!-- End - Insert Employee modal  -->


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
                                          <input type="text" class="form-control" placeholder="Enter employee's full name" id="updateEmpName"  autocomplete="off" required="required">            
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
                                    <!-- Job -->
                                <div class="form-group text-dark">
                                     <label for="">Job:</label>
                                      <div class="input-group mb-3">
                                          <span class="input-group-text bg-dark">
                                                <i class="fas fa-user text-light"></i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Enter your employee's job" id="updaterole"  autocomplete="off" required="required">            
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

 <!-- profile -->
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
                        <h6 class="text-light">Sarary/Month: <input class="border-0 text-primary bg-dark" type="text" id="employeesalary"></h6>
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
					<h1>Employees</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Employees</a>
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
				<a href="customers.php" class="btn-sell">
                <i style="color:#fff;" class='bx bxs-group'></i>
					<span style="color:#fff;" class="text">Customers</span>
				</a> -->
				<a href="empExport.php" class="btn-download">
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

			<!-- Employee table -->
			<div class="table-data">
               <div class="recent">
                  <div class="head">
                     <h3>All Employees</h3>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#addemployee">+</a> 
                    
                     <i class='bx bx-filter' ></i>
                  </div>
                  <!-- Table -->
                  <table id="EmpTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                            <th>ID</th>
                           <th>Name</th>
                           <th>Phone No.</th>
                           <th>Email</th>
                           <th>Role</th> 
                           <th>Operations</th>
                              <!-- New column for edit and delete buttons -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include your MySQL connection configuration file
                            include "../include/config.php";

                            // Query to fetch data from the logbook table
                            $sql = "SELECT ID,EmpName,phone,Email,`Role` FROM employees ORDER BY ID DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ID'] . "</td>";
                                    echo "<td>" . $row['EmpName'] . "</td>";
                                    echo "<td class='text-start'>" . $row['phone'] . "</td>";
                                    echo "<td class='text-start'>" . $row['Email'] . "</td>";
                                    echo "<td class='text-start'>" . $row['Role'] . "</td>";
                                    // Edit and delete buttons
                                    echo "<td class='text-center'>";
                                       echo "<i class='bx bx-dots-vertical-rounded' onclick='toggleIcons(this)'></i>";
                                       echo "<a href='#' class='me-3 profile hide-icons' data-bs-target='#productsprofile' title='view profile' onclick='viewProfile(" . $row['ID'] . ")'><i class='fas fa-eye text-success'></i></a>";
                                       echo "<a href='#' class='me-3 edituser hide-icons' title='edit' data-bs-target='#editproducts' onclick='GetDetails(" . $row['ID'] . ")'><i class='fas fa-edit text-info'></i></a>";
                                       echo "<a href='#' class='me-3 deleteuser hide-icons' title='Delete' onclick='DeleteUser(" . $row['ID'] . ")'><i class='fas fa-trash-alt text-danger'></i></a>";
                                    echo "</td>";

                                    echo "</tr>";
                                }
                            }

                            // Close MySQL connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>

                 <!-- table End -->

               </div>
          </div>


        </main>
		<!-- main -->
	</section>
	<!-- content -->



    
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
    
         new DataTable('#EmpTable', {
                  layout: {
                  topStart: {
                     buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                  }
               }
            });




     // jQuery code to toggle the display of icons at the operations field
     function toggleIcons(icon) {
        $(icon).siblings().toggleClass('hide-icons');
      }


       // Add employee
      function addemployee(){
       var EmpNameAdd=$('#EmpName').val();
       var genderAdd=$('#gender').val();
       var addressAdd=$('#address').val();
       var phoneAdd=$('#phone').val();
       var hiredateAdd=$('#hiredate').val();
       var roleAdd = $('#role').val();
       var salaryAdd=$('#salary').val();
       var emailAdd=$('#email').val();
      //  var passwordAdd=$('#password').val();


       

       $.ajax({
           url:"EmpAdd.php",
           type:'post',
           data:{
              EmpNameSend:EmpNameAdd,
              genderSend:genderAdd,
              addressSend:addressAdd,
              phoneSend:phoneAdd,
              hiredateSend: hiredateAdd,
              roleSend:roleAdd,
              salarySend:salaryAdd,
              emailSend:emailAdd

            //   passwordSend:passwordAdd,
              
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#addemployee').modal('hide');
             displayEmp();
            location.reload();//refreshes the page
           }
        });
  }


   
   // Update EMPLOYEE function
   function GetDetails(updateid){
      $('#hiddendata').val(updateid);

      $.post("empUpdate.php",{updateid:updateid},function(data,status){
         var userid=JSON.parse(data);
         $('#updateEmpName').val(userid.EmpName);
         $('#updategender').val(userid.Gender);
         $('#updateemail').val(userid.Email);
         $('#updateaddress').val(userid.Address);
         $('#updatephone').val(userid.Phone);
         $('#updatehiredate').val(userid.Hire_date);
         $('#updaterole').val(userid.Role);
         $('#updatesalary').val(userid.SalaryPerMonth);
      });

         $('#editemployee').modal('show');
   }

   // onclick update event function
   function updateDetails(){
   var updateEmpName=$('#updateEmpName').val();
   var updategender=$('#updategender').val();
   var updateEmail=$('#updateemail').val();
   var updateaddress=$('#updateaddress').val();
   var updatephone=$('#updatephone').val();
   var updatehiredate=$('#updatehiredate').val();
   var updaterole=$('#updaterole').val();
   var updatesalary=$('#updatesalary').val();

   var hiddendata=$('#hiddendata').val();

   $.post("empUpdate.php",{
      updateEmpName:updateEmpName,
      updategender:updategender,
      updateEmail:updateEmail,
      updateaddress:updateaddress,
      updatephone:updatephone,
      updatehiredate:updatehiredate,
      updaterole:updaterole,
      updatesalary:updatesalary,

      hiddendata:hiddendata

   },function(data,status){
   $('#editemployee').modal('hide');
   displayEmp();
   })
   }

   


   // Delete Employee
  function DeleteUser(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this employee?");
    if (confirmation) {
        $.ajax({
            url: "empDelete.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayEmp();
            }
        });
    }
}


// view profile
   function viewEmpProfile(updateid){
      $('#hiddendata').val(updateid);

      $.post("empProfile.php",{updateid:updateid},function(data,status){
      var userid=JSON.parse(data);
      $('#employeename').val(userid.EmpName);
      $('#employeegender').val(userid.Gender);
      $('#employeeemail').val(userid.Email);
      $('#employeeaddress').val(userid.Address);
      $('#employeephone').val(userid.Phone);
      $('#employeehiredate').val(userid.Hire_date);
      $('#employeerole').val(userid.Role);
      $('#employeesalary').val(userid.SalaryPerMonth);

      });

      $('#employeeprofile').modal('show');
   }



   // search bar
$(document).ready(function(){
      $("#search").on("keyup", function() {
        var input = $(this).val();
        //alert(input);
        if(input != ""){
             $.ajax({
               url:"empSearch.php",
               method:"POST",
               data:{input:input},

               success:function(data){
                  $("#EmpTable").html(data);
               }
             });  
        }else{
            location.reload();
             $("#EmpTable").css("display","block");
        }
      });
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