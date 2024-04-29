<?php
session_start();
include "../include/config.php";

if (!isset($_SESSION['username'])){
   // If user is not loggend in send to login page
   header('Location: ../index.php');
   exit();
}

$CompNameSQL = mysqli_query($conn, "SELECT CompanyName FROM settings");
$Comp_row = mysqli_fetch_assoc($CompNameSQL);
$CompName = $Comp_row['CompanyName'];

// if ($_SESSION['username'] !== 'user 1'  && $_SESSION['role'] !== 'admin') {
//    // User is logged in but is not the user with username $user and not an admin
//    header('Location: 404.php');
//    exit();
// }
$today = date('Y-m-d');
$firstDayOfMonth = date('Y-m-01');

$firstDayOfWeek = date('Y-m-d', strtotime('last monday', strtotime($today))); // Get the first day of the current week (Monday)

$soldSQL = mysqli_query($conn,"SELECT * FROM sales WHERE Date BETWEEN '$firstDayOfWeek' AND '$today' GROUP BY ProductName");
$total_sold = mysqli_num_rows($soldSQL);


$grandTotalSQL = mysqli_query($conn, "SELECT SUM(TotalPrice) AS grand_total FROM `sales` WHERE Date BETWEEN '$firstDayOfWeek' AND '$today'");
$grand_total_row = mysqli_fetch_assoc($grandTotalSQL);
$grand_total = $grand_total_row['grand_total'];

$customersSQL = mysqli_query($conn,"SELECT * FROM customers WHERE Date BETWEEN '$firstDayOfWeek' AND '$today' GROUP BY CustomerName");
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

   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
	<link rel="stylesheet" href="../css/template.css">
	<link rel="stylesheet" href="../css/product.css">
</head>
<body>

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
					<i class='bx bxs-shopping-bag-alt'></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="../pages/analytics.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li class="active">
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
				<a href="users.php">
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
					<h1>Sales</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Sales</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
            <a href="admin_sell.php" class="btn-sell">
                <i style="color:#fff;" class='bx bxs-cart-alt'></i>
					<span style="color:#fff;" class="text">Sell Product</span>
				</a>

				<a href="saleExport.php" class="btn-download">
					<i style="color:#fff;" class='bx bxs-cloud-download' ></i>
					<span style="color:#fff;" class="text">Export To Excel</span>
				</a>
			</div>

			<ul class="box-info">
                <li title="within this week">
                <i class='bx bxs-cart-add' ></i>
					<span class="text">
						<h3><?php echo $total_sold?></h3>
						<p>Product Sold</p>
					</span>
				</li>
                <li title="your weekly sales">
                <i class='bx bx-target-lock'></i>
					<span class="text">
						<h3><?php echo '₵', $grand_total ?></h3>
						<p>grand sale</p>
					</span>
				</li>
                <li title="within this week">
					<i class="bx bxs-calendar-check"></i>
					<span class="text">
						<h3><?php echo $total_customers ?></h3>
						<p>Customers</p>
					</span>
				</li>
              
			</ul>

			<!-- Sale table -->
			<div class="table-data">
               <div class="recent">
                  <div class="head">
                     <h3>Sales</h3> 
                     <i class='bx bx-filter' ></i>
                  </div>
                  <!-- <div id="SaleTable">-->
                   <table id="saleTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                              <th>ID</th>
                              <th>Customer</th>
                              <th>Product</th>
                              <th>Category</th>
                              <th>Sale Price</th> 
                              <th>Quantity</th> 
                              <th>Total Price</th> 
                              <th>Profit</th> 
                              <th>Date</th> 
         
                              <!-- New column for edit and delete buttons -->
                           </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include your MySQL connection configuration file
                            include "../include/config.php";

                            // Query to fetch data from the logbook table
                            $sql = "SELECT ID,CustomerName,ProductName,Category,`SalesPrice` , Quantity, TotalPrice, Profit, Date FROM sales  ORDER BY Date DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ID'] . "</td>";
                                    echo "<td>" . $row['CustomerName'] . "</td>";
                                    echo "<td>" . $row['ProductName'] . "</td>";
                                    echo "<td>" . $row['Category'] . "</td>";
                                    echo "<td class='text-center'>" . $row['SalesPrice'] . "</td>";
                                    echo "<td class='text-center'>" . $row['Quantity'] . "</td>";
                                    echo "<td class='text-center'>" . $row['TotalPrice'] . "</td>";
                                    echo "<td class='text-start'>" . $row['Profit'] . "</td>";
                                    echo "<td class='text-start'>" . $row['Date'] . "</td>";
                  
                                    echo "</tr>";
                                }
                            }

                            // Close MySQL connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                  </div> 











               </div>
          </div>


        </main>
		<!-- main -->
	</section>
	<!-- content -->



    <script src="../js/template.js"></script>
    <script src="../js/employees.js"></script>
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
    <script>

 // jQuery code to toggle the display of icons at the operations field
      function toggleIcons(icon) {
        $(icon).siblings().toggleClass('hide-icons');
      }



      new DataTable('#saleTable', {
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





      		// display database table
		$(document).ready(function(){
                displaySale();
            });

            // display function
            function displaySale(){
            var displaySale="true";
            $.ajax({
                url:"SaleTable.php",
                type:'POST',
                data:{
                displaySend:displaySale
                },
                success:function(data,status){
                $('#SaleTable').html(data);
                }
            })
            }


   // search bar
$(document).ready(function(){
      $("#search").on("keyup", function() {
        var input = $(this).val();
        //alert(input);
        if(input != ""){
             $.ajax({
               url:"saleSearch.php",
               method:"POST",
               data:{input:input},

               success:function(data){
                  $("#SaleTable").html(data);
               }
             });  
        }else{
            location.reload();
             $("#SaleTable").css("display","block");
        }
      });
    });


   // //  code for pagination
   //  $(document).ready(function(){
   //    // Display table on page load
   //    displayTable(1);

   //    // Page navigation click event
   //    $(document).on("click", ".pagination li span", function(e){
   //       e.preventDefault();
   //       var pageId = $(this).attr('id');
   //       displayTable(pageId);
   //    });

   //    // Display table function
   //    function displayTable(pageId){
   //       $.ajax({
   //          url: 'SaleTable.php',
   //          type: 'POST',
   //          data: {page: pageId, displaySend: 1},
   //          success: function(response){
   //          $('#SaleTable').html(response);
   //          }
   //       });
   //    }
   //    }); 
   
   

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
         url: 'SaleTable.php', // Replace with the path to your PHP file
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
         url: 'SaleTable.php', // Replace with the path to your PHP file
         type: 'POST',
         data: {
            page: pageId,
            displaySend: 1,
            limit: limit
         },
         success: function(response) {
            $('#SaleTable').html(response);
         }
      });
   }
});
//   end pagination





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