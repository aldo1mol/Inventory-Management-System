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

if (!isset($_SESSION['username'])){
   // If user is not loggend in send to login page
   header('Location: ../index.php');
   exit();
}

$noteSQL = mysqli_query($conn, "SELECT * FROM `notification`"); 
$total_messages = mysqli_num_rows($noteSQL);



$RememberSQL = mysqli_query($conn,"SELECT todo FROM todo_list WHERE status = 'not-completed'");
$TodoSQL = mysqli_query($conn,"SELECT * FROM todo_list WHERE status = 'not-completed'");
$total_todos = mysqli_num_rows($TodoSQL);

$employeesSQL = mysqli_query($conn,"SELECT * FROM employees");
$total_employees = mysqli_num_rows($employeesSQL);

$usersSQL = mysqli_query($conn,"SELECT * FROM users");
$total_users = mysqli_num_rows($usersSQL);

$today = date('Y-m-d');
$firstDayOfMonth = date('Y-m-01');
$firstDayOfWeek = date('Y-m-d', strtotime('last monday', strtotime($today))); // Get the first day of the current week (Monday)

$customersSQL = mysqli_query($conn, "SELECT * FROM customers WHERE Date BETWEEN '$firstDayOfWeek' AND '$today' GROUP BY CustomerName");
$total_customers = mysqli_num_rows($customersSQL);


$productsSQL = mysqli_query($conn, "SELECT * FROM products WHERE DateInStock BETWEEN '$firstDayOfMonth' AND '$today'");
$total_products = mysqli_num_rows($productsSQL);

$salesSQL = mysqli_query($conn,"SELECT * FROM sales WHERE Date BETWEEN '$firstDayOfWeek' AND '$today' ");
$total_sales = mysqli_num_rows($salesSQL);
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

	<!-- bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">


	<!-- My CSS -->
	<!-- <link rel="stylesheet" href="../css/product.css"> -->
	<link rel="stylesheet" href="../css/dashboard.css">
	<link rel="stylesheet" href="../css/template.css">

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



      #content .notification {
  font-size: 20px;
  position: relative;
}
#content .notification .num {
  position: absolute;
  top: -6px;
  right: -6px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 2px solid #f9f9f9;
  background: #e63c3c;
  color: #f9f9f9;
  font-weight: 700;
  font-size: 12px;
  display: flex;
  justify-content: center;
  align-items: center;
}
   </style>

</head>
<body style="margin:0;">

<!-- Add todo list modal Modal -->
<div class="modal fade" id="addtodo" role="dialog">
   <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">CREATING TODO LIST</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  
                        <!-- todo -->
                        <div class="form-group text-light">
                           <label for="">Task:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                              <input type="text" class="form-control" placeholder="Type a task" autocomplete="off" id="todo" required="required">        
           
                           </div>
                        </div>

						<div class="form-group text-light">
                         <label for="">status:</label>
                         <div class="input-group mb-3">
                             <span class="input-group-text bg-dark">
                                     <i class="fas fa-user text-light"></i>
                             </span>
                             <select class="form-select" id="status">
                                 <option value="not-completed">Not Completed</option>
                                 <option value="completed">Done</option>
                             </select>           
                         </div>
                     </div>     
                  </div>
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="addtodo()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
            </div>
       </div>
   </div>


   <!-- Edit todo list  Modal -->
<div class="modal fade" id="edittodo" role="dialog">
   <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">EDITING AND UPDATING TODOLIST</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  
                        <!-- Edit Task -->
                        <div class="form-group text-light">
                           <label for="">TASK:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                              <input type="text" class="form-control"  autocomplete="off" id="updatetodo" required="required"> 
							          
                           </div>
                        </div>
						<div class="form-group text-light">
                                 <label for="">status:</label>
                                    <div class="input-group mb-3">
                                       <span class="input-group-text bg-dark">
                                             <i class="fas fa-user text-light"></i>
                                       </span>
                                       <select class="form-select" id="updatestatus">
                                          <option value="not-completed">Not Completed</option>
                                          <option value="completed">Completed</option>
                                       </select>           
                                    </div>
                              </div>          
                  </div>
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="updateTodo()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">
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











   <!-- sidebar -->
   <section class="m-0" id="sidebar">
        <a href="#" class="brand">
            <i class="bx bxs-shopping-bag"></i>
            <span class="text"><?php echo $CompName ?></span>
        </a>

        <ul class="side-menu top p-0">
            <li class="active">
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
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				 <a href="#" class="btn-download" title="Number of uncompleted todo lists.">
					<span style="color:#fff;" class="text">Reminder list</span>
					<span style="color:#fff" class="numb"><?php echo $total_todos ?></span>
				</a>
			</div>

			<ul class="box-info" title="number of users">
                <li>
					<i class="bx bxs-calendar-check"></i>
					<span class="text">
						<h3><?php echo $total_users?></h3>
						<p>Users</p>
					</span>
				</li>


				<li title="total customers this week">
					<i class="bx bxs-group"></i>
					<span class="text">
						<h3><?php echo $total_customers?></h3>
						<p>Customers This Week</p>
					</span>
				</li>
				<li title="sales this week">
					<i class="bx bxs-dollar-circle"></i>
					<span class="text">
						<h3><?php echo $total_sales ?></h3>
						<p>Sales This Week</p>
					</span>
				</li>
                <li title="number of products added this month">
					<i class="bx bxs-shopping-bag"></i>
					<span class="text">
						<h3><?php echo $total_products?></h3>
						<p>Recent Products</p>
					</span>
				</li>
                <li title="number of employees">
					<i class="bx bxs-group"></i>
					<span class="text">
					<h3><?php echo $total_employees?></h3>
						<p>Employees</p>
					</span>
				</li>
              
			</ul>
<!-- Recently added items -->
			<div class="table-data">
			<div class="recent">
                  <div class="head">
                     <h3>Recently Added Products</h3>
                    
                     <i class='bx bx-filter'></i>
                  </div>
                  <div id="RecentPtable">
                   
                  </div>
               </div>


			  <div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class='bx bx-plus' data-bs-toggle="modal" data-bs-target="#addtodo" ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<center>
						<span>
							<a href="#" style="background-color: #3C91E6;" class="btn text-light">Completed</a>
							<a href="#" style="background-color: #FD7238;" class="btn text-light">Not Completed</a>
						</span>
					</center>
					
					<ul class="todo-list mt-3" id="displaytodo">

					</ul>
				</div>
			</div>


        </main>
		<!-- main -->
	</section>
	<!-- content -->

   <!-- <script src="../lib/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.6.4.js"></script>
    <script src="../js/template.js"></script>

	<script>
// jQuery code to toggle the display of icons at the operations field
	function toggleIcons(icon) {
   		$(icon).siblings().toggleClass('hide-icons');
 	}


   // display database table
   $(document).ready(function(){
		   displayProd();
	   });

	   // display function
	   function displayProd(){
	   var displayProd="true";
	   $.ajax({
		   url:"RecentPtable.php",
		   type:'POST',
		   data:{
		   displaySend:displayProd
		   },
		   success:function(data,status){
		   $('#RecentPtable').html(data);
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




	 // display todolist table
	 $(document).ready(function(){
		   displayTodo();
	   });

	   // display function
	   function displayTodo(){
	   var displayTodo="true";
	   $.ajax({
		   url:"todoTable.php",
		   type:'POST',
		   data:{
			displayTodo:displayTodo
		   },
		   success:function(data,status){
		   $('#displaytodo').html(data);
		   }
	   })
	}


	// code for pagination and limit
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
         url: 'prodTable.php', // Replace with the path to your PHP file
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
         url: 'prodTable.php', // Replace with the path to your PHP file
         type: 'POST',
         data: {
            page: pageId,
            displaySend: 1,
            limit: limit
         },
         success: function(response) {
            $('#prodTable').html(response);
         }
      });
   }
});


 // Add todo
 function addtodo(){
       var todoAdd=$('#todo').val();
       var statusAdd=$('#status').val();
   

       $.ajax({
           url:"todoAdd.php",
           type:'post',
           data:{
              todoSend:todoAdd,
              statusSend:statusAdd,
                          
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#addtodo').modal('hide');
             displayTodo();
            location.reload();//refreshes the page
           }
        });
      }


	  //   UPDATE TODOLIST
	  function GetTodo(updateid){
		$('#hiddendata').val(updateid);

		$.post("todoUpdate.php",{updateid:updateid},function(data,status){
			var id=JSON.parse(data);
			$('#updatetodo').val(id.todo);
			$('#updatestatus').val(id.status);

		});
			$('#edittodo').modal('show');
	}

	// onclick update event function
	function updateTodo(){
      var updatetodo=$('#updatetodo').val();
	  var updatestatus=$('#updatestatus').val();
      var hiddendata=$('#hiddendata').val();

      $.post("todoUpdate.php",{
         updatetodo:updatetodo,
		 updatestatus:updatestatus,
         hiddendata:hiddendata
      },function(data,status){
      $('#edittodo').modal('hide');
      displayTodo();
      })
   }


     // Delete todo list
	 function DeleteTodo(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete from todo list?");
    if (confirmation) {
        $.ajax({
            url: "todoDel.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayTodo();
            }
        });
    }
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