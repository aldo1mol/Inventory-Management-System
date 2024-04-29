<?php
session_start();
include "../include/config.php";


// if ($_SESSION['username'] !== 'user 1'  && $_SESSION['role'] !== 'admin') {
// 	// User is logged in but is not the user with username $user and not an admin
// 	header('Location: 404.php');
// 	exit();
//  }
if (!isset($_SESSION['username'])){
	// If user is not loggend in send to login page
	header('Location: ../index.php');
	exit();
 }



$noteSQL = mysqli_query($conn, "SELECT * FROM `notification`"); 
$total_messages = mysqli_num_rows($noteSQL);

$CompNameSQL = mysqli_query($conn, "SELECT CompanyName FROM settings");
$Comp_row = mysqli_fetch_assoc($CompNameSQL);
$CompName = $Comp_row['CompanyName'];

// favourite customer
$sqlfavCust = "SELECT customerName, COUNT(*) AS name_count
				FROM customers
				GROUP BY customerName
				ORDER BY name_count DESC";
$resultfavCust = mysqli_query($conn, $sqlfavCust);
$row = mysqli_fetch_assoc($resultfavCust);
$fav = $row["customerName"];

// Calculate total customers in the past month
$previousMonthStart = date('Y-m-d', strtotime('first day of last month'));
$currentMonthStart = date('Y-m-d', strtotime('first day of this month'));

$sqlPastMonth = "SELECT COUNT(*) AS total_customers_past_month
                FROM customers
                WHERE `date` >= '$previousMonthStart' AND `date` < '$currentMonthStart'";

$resultPastMonth = $conn->query($sqlPastMonth);

if ($resultPastMonth->num_rows > 0) {
    $row = $resultPastMonth->fetch_assoc();
    $totalCustomersPastMonth = $row["total_customers_past_month"];
} else {
    $totalCustomersPastMonth = 0;
}

// Calculate total customers in the current month
$sqlCurrentMonth = "SELECT COUNT(*) AS total_customers_current_month
                   FROM customers
                   WHERE `date` >= '$currentMonthStart' GROUP BY CustomerName";

$resultCurrentMonth = $conn->query($sqlCurrentMonth);

if ($resultCurrentMonth->num_rows > 0) {
    $row = $resultCurrentMonth->fetch_assoc();
    $totalCustomersCurrentMonth = $row["total_customers_current_month"];
} else {
    $totalCustomersCurrentMonth = 0;
}

// Calculate the percentage change
if ($totalCustomersPastMonth == 0) {
    $percentageChange = 0; // Avoid division by zero if there were no customers in the past month.
} else {
    $percentageChange = (($totalCustomersCurrentMonth - $totalCustomersPastMonth) / $totalCustomersPastMonth) * 100;
		//color change of percentage
	$color = $percentageChange < 0 ? 'red' : '#54de68';
}



// calculate highly sold product
$sqltotProd = "SELECT ProductName, SUM(Quantity) AS total_quantity_sold
				FROM sales
				GROUP BY ProductName
				ORDER BY total_quantity_sold DESC
				LIMIT 1;
				";
$resulttotProd = mysqli_query($conn, $sqltotProd);
$Prodrow = mysqli_fetch_assoc($resulttotProd);
$mostprod = $Prodrow["ProductName"];

// calculate least sold product
$sqltotProd = "SELECT ProductName, SUM(Quantity) AS total_quantity_sold
				FROM sales
				GROUP BY ProductName
				ORDER BY total_quantity_sold ASC
				LIMIT 1;
				";
$resulttotProd = mysqli_query($conn, $sqltotProd);
$Prodrow = mysqli_fetch_assoc($resulttotProd);
$leastprod = $Prodrow["ProductName"];


// Calculate total products sold in the past month;

$sqlProductsPastMonth = "SELECT SUM(Quantity) AS total_products_sold_past_month
                FROM sales
                WHERE `Date` >= '$previousMonthStart' AND `Date` < '$currentMonthStart' GROUP BY ProductName";

$resultProductsPastMonth = $conn->query($sqlProductsPastMonth);

if ($resultProductsPastMonth->num_rows > 0) {
    $row = $resultProductsPastMonth->fetch_assoc();
    $totalProductsSoldPastMonth = $row["total_products_sold_past_month"];
} else {
    $totalProductsSoldPastMonth = 0;
}

// Calculate total products sold in the current month
$sqlProductsCurrentMonth = "SELECT SUM(Quantity) AS total_products_sold_current_month
                   FROM sales
                   WHERE `Date` >= '$currentMonthStart' GROUP BY ProductName";

$resultProductsCurrentMonth = $conn->query($sqlProductsCurrentMonth);

if ($resultProductsCurrentMonth->num_rows > 0) {
    $row = $resultProductsCurrentMonth->fetch_assoc();
    $totalProductsSoldCurrentMonth = $row["total_products_sold_current_month"];
} else {
    $totalProductsSoldCurrentMonth = 0;
}

// Calculate the percentage change for products
if ($totalProductsSoldPastMonth == 0) {
    $percentageChangeProducts = 0; // Avoid division by zero if there were no products sold in the past month.
} else {
    $percentageChangeProducts = (($totalProductsSoldCurrentMonth - $totalProductsSoldPastMonth) / $totalProductsSoldPastMonth) * 100;
	$color2 = $percentageChangeProducts < 0 ? 'red' : '#54de68';
}





// Calculate total sales revenue in the current month
$sqlSalesCurrentMonth = "SELECT SUM(TotalPrice) AS total_revenue_current_month
                FROM sales
                WHERE `Date` >= '$currentMonthStart'";

$resultSalesCurrentMonth = $conn->query($sqlSalesCurrentMonth);

if ($resultSalesCurrentMonth->num_rows > 0) {
    $row = $resultSalesCurrentMonth->fetch_assoc();
    $totalRevenueCurrentMonth = $row["total_revenue_current_month"];
} else {
    $totalRevenueCurrentMonth = 0;
}

// Calculate total sales revenue in the previous month
$sqlSalesPastMonth = "SELECT SUM(TotalPrice) AS total_revenue_past_month
                FROM sales
                WHERE `Date` >= '$previousMonthStart' AND Date < '$currentMonthStart'";

$resultSalesPastMonth = $conn->query($sqlSalesPastMonth);

if ($resultSalesPastMonth->num_rows > 0) {
    $row = $resultSalesPastMonth->fetch_assoc();
    $totalRevenuePastMonth = $row["total_revenue_past_month"];
} else {
    $totalRevenuePastMonth = 0;
}

// Calculate total profit in the current month
$sqlProfitCurrentMonth = "SELECT SUM(Profit) AS total_profit_current_month
                FROM sales
                WHERE `Date` >= '$currentMonthStart'";

$resultProfitCurrentMonth = $conn->query($sqlProfitCurrentMonth);

if ($resultProfitCurrentMonth->num_rows > 0) {
    $row = $resultProfitCurrentMonth->fetch_assoc();
    $totalProfitCurrentMonth = $row["total_profit_current_month"];
} else {
    $totalProfitCurrentMonth = 0;
}

// Calculate total profit in the previous month
// $sqlProfitPastMonth = "SELECT SUM(Profit) AS total_profit_past_month
//                 FROM sales
//                 WHERE `Date` >= '$previousMonthStart' AND `Date` < '$currentMonthStart'";

// $resultProfitPastMonth = $conn->query($sqlProfitPastMonth);

// if ($resultProfitPastMonth->num_rows > 0) {
//     $row = $resultProfitPastMonth->fetch_assoc();
//     $totalProfitPastMonth = $row["total_profit_past_month"];
// } else {
//     $totalProfitPastMonth = 0;
// }

// Calculate the percentage change in total sales revenue and profit
if ($totalRevenuePastMonth == 0) {
    $percentageChangeSales = 0; // Avoid division by zero if there were no sales in the past month.
    $percentageChangeProfit = 0; // Avoid division by zero if there were no profits in the past month.
} else {
    $percentageChangeSales = (($totalRevenueCurrentMonth - $totalRevenuePastMonth) / $totalRevenuePastMonth) * 100;
    $color3 = $percentageChangeSales < 0 ? 'red' : '#54de68';
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RMS</title>
	<link rel="shortcut icon" href="https://boxicons.com/?query=shopping+bag">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- My CSS -->
	<link rel="stylesheet" href="../css/template.css">
	<link rel="stylesheet" href="../css/analytics.css">

	    <!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

<style>
	main .box-info {
  display: flex;
  flex-direction: column;
  margin-top: 36px;
}
main .box-info li {
  padding: 24px;
  background: #f9f9f9;
  border-radius: 20px;
  display: flex;
  align-items: center;
  grid-gap: 24px;
}
main .box-info li .text h3 {
  font-size: 24px;
  font-weight: 600;
}
main .box-info li .bx {
  width: 80px;
  height: 80px;
  border-radius: 10px;
  background: #eee;
  font-size: 36px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.custinfo{
	padding-right: 100px;
}


</style>

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




 <!-- sidebar -->
<section id="sidebar">
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
			<li class="active">
				<a href="../pages/analytics.php">
					<i class='bx bxs-doughnut-chart'></i>
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
		<ul class="side-menu p-0 ">
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
					<h1>Analytics</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Analytics</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
                <li style="background-color: #000;">
					<i style="background-color: tomato; color:#000;" class="bx bxs-group"></i>
					<span style="color: #fff;">
						<h4 style="border-bottom: 2px solid tomato;"> CUSTOMERS </h4>
						<div style="display: flex; flex-wrap:wrap;" class="box">

						<div style="color: #54de68;"  class="custinfo">
								<h5 title="Total number of customers this month">Customers</h5>
                                 <center>(<?php echo $totalCustomersCurrentMonth ?>)</center> 
							</div>
						    <div style="color: tomato;" class="custinfo">
								<h5 title="Number of customers last Month">Last Month Customers</h5>
                                 <center>(<?php echo $totalCustomersPastMonth ?>)</center> 
							</div>
							
							<div style="color:  #3594d3;" class="custinfo">
								<h5 title="The customer with the most product purchase">Favourite Customer</h5>
								 <center>(<?php echo $fav ?>)</center> 
							</div>

							<div style="color:snow;" class="custinfo">
								<h5 title="Customers improvement compared to last month">Improvement</h5>
                                <center style="color: <?php echo $color; ?>">(<?php echo number_format($percentageChange,2)."%" ?>)</center>
							</div>
						</div>
						
					</span>
				</li>
	

                
				<li style="background-color: #000;">
					<i style="background-color: tomato; color:#000;" class="bx bxs-shopping-bag"></i>
					<span style="color: #fff;">
						<h4 style="border-bottom: 2px solid tomato;"> PRODUCTS </h4>
						<div style="display: flex; flex-wrap:wrap;"  class="box">

						    <div style="color: #54de68;"  class="custinfo">
								<h5 title="current month">Products Sold</h5>
                                 <center>(<?php echo $totalProductsSoldCurrentMonth ?>)</center> 
							</div>

							<!-- <div style="color: tomato;  class="custinfo">
								<h5 title="last month">Products last month</h5>
                                 <center>(<?php echo $totalProductsSoldPastMonth ?>)</center> 
							</div> -->

							<div style="color: tomato;" class="custinfo">
								<h5 title="Highly purchased product">Least Purchased</h5>
								 <center>(<?php echo $leastprod ?>)</center> 
							</div>
							
							<div style="color:  #3594d3;" class="custinfo">
								<h5 title="Highly purchased product">Most Purchased</h5>
								 <center>(<?php echo $mostprod ?>)</center> 
							</div>
							
							<div style="color: snow;" class="custinfo">
								<h5 title="Percentage improved">Improvement</h5>
                                 <center style="color: <?php echo $color2; ?>;">(<?php echo number_format($percentageChangeProducts,2)."%" ?>)</center> 
							</div>


							
							
						</div>
						
					</span>
				</li>
	
			<!-- Sales -->
				<li style="background-color: #000;">
					<i style="background-color: tomato; color:#000;" class="bx bxs-dollar-circle"></i>
					<span style="color: #fff;">
						<h4 style="border-bottom: 2px solid tomato;"> REVENUE </h4>
						<div style="display: flex; flex-wrap:wrap;" class="box">

						    <div style="color: #54de68;"  class="custinfo">
								<h5 title="total sales made within the month">Total Sales(₵)</h5>
                                 <center>(<?php echo number_format($totalRevenueCurrentMonth, 2) ?>)</center> 
							</div>

							<div style="color: tomato;" class="custinfo">
								<h5 title="Total sales made last month">Sales Last Month(₵)</h5>
								 <center>(<?php echo number_format($totalRevenuePastMonth, 2) ?>)</center> 
							</div>

							<div style="color: #3594d3;" class="custinfo">
								<h5 title="The profit made for the month">Profit(₵)</h5>
                                 <center>(<?php echo number_format($totalProfitCurrentMonth, 2) ?>)</center> 
							</div>
							
							<div style="color: snow;" class="custinfo">
								<h5 title="comparation of previous month and this month for total sales">Improvement</h5>
                                 <center style="color: <?php echo $color3; ?>">(<?php echo number_format($percentageChangeSales,2)."%" ?>)</center>
							</div>

							
						</div>
						
					</span>
				</li>
              
			</ul>
			<!-- analytics -->
             <!-- charts -->
				<!-- <div class="chart_container">
					<div class="chart_box">
						<canvas id="barChart"></canvas>
					</div>
				</div> -->

				
            <!-- end of analytics -->
        </main>
		<!-- main -->
	</section>
	<!-- content -->
<script src="../js/template.js"></script>
<script src="../js/jquery-3.6.4.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
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