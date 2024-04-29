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


// if (
//    !($_SESSION['username'] === 'user 1' || $_SESSION['username'] === 'user 3')
//    && !( $_SESSION['role'] === 'admin' || $_SESSION['role'] === 'stocker')
// ) {
//   // User is logged in, and the 'username' and 'role' keys exist in the session,
//   // but the conditions for access are not met
//   header('Location: 404.php');
//   exit();
// }


$today = date('Y-m-d');
$firstDayOfMonth = date('Y-m-01');

$firstDayOfWeek = date('Y-m-d', strtotime('last monday', strtotime($today))); // Get the first day of the current week (Monday)

$soldSQL = mysqli_query($conn,"SELECT * FROM sales WHERE Date BETWEEN '$firstDayOfWeek' AND '$today'");
$total_sold = mysqli_num_rows($soldSQL);


$productsSQL = mysqli_query($conn,"SELECT * FROM products");
$total_products = mysqli_num_rows($productsSQL);

$categoriesSQL = mysqli_query($conn,"SELECT * FROM categories");
$total_categories = mysqli_num_rows($categoriesSQL);

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

<!-- Add category Modal -->
<div class="modal fade" id="addcategory" role="dialog">
   <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">ADDING CATEGORY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  
                        <!-- Category Name -->
                        <div class="form-group text-light">
                           <label for="">Category Name:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                              <input type="text" class="form-control" placeholder="Enter category name" autocomplete="off" id="categoryName" required="required">            
                           </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="addcategory()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
            </div>
       </div>
   </div>

<!-- Edit category Modal -->
<div class="modal fade" id="editcategory" role="dialog">
   <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">EDITING AND UPDATING CATEGORY</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  
                        <!-- Category Name -->
                        <div class="form-group text-light">
                           <label for="">Category Name:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                              <input type="text" class="form-control" placeholder="Enter category name" autocomplete="off" id="updatecatName" required="required">            
                           </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="updateCatDetails()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddenCatdata">
                  </div>
            </div>
       </div>
   </div>





<!--Add product Modal -->
<div class="modal fade" id="addproduct" role="dialog">
            <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">ADDING PRODUCTS</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  <div class="row">
                     <div class="col">
                        <!-- Product Name -->
                        <div class="form-group text-light">
                           <label for="">Product Name:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                                    <input type="text" class="form-control" placeholder="Enter the name of Product" autocomplete="off" id="productName" required="required">            
                           </div>
                        </div>

                     </div>
                     <div class="col" id="catInput">
                        <!-- category -->
                        
                     </div>
                  </div>
                        
                        
                  <div class="row">
                     <div class="col">
                          <!-- Cost Price -->
                        <div class="form-group text-light">
                           <label for="">Cost Price:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-money-bill-wave text-light"></i>
                              </span>
                                    <input type="number" class="form-control" placeholder="Enter the cost price" id="costPrice" 
                                    autocomplete="off" step="0.01" min="0" maxlength="10"   required="required">          
                           </div>
                        </div>
                     </div>
                     <div class="col">
                          <!-- Sales price -->
                          <div class="form-group text-light">
                           <label for="">Sales Price:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-dollar-sign text-light"></i>
                              </span>
                                    <input type="number" class="form-control" placeholder="Enter the unit price" id="salesPrice" 
                                    autocomplete="off" step="0.01" min="0" maxlength="10"   required="required">          
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                  <div class="col">
                          <!-- profit -->
                          <div class="form-group text-light">
                           <label for="">Profit:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-chart-line text-light"></i>
                              </span>
                                    <input type="number" class="form-control" placeholder="Enter the profit price" id="profit" 
                                    autocomplete="off"  min="0" maxlength="10"   readonly>          
                           </div>
                        </div>
                     </div>
                     <div class="col">
                         <!-- Quantity -->
                         <div class="form-group text-light">
                           <label for="">Quantity:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                   <i class="fas fa-sort-amount-up text-light"></i>                              
                              </span>
                                 <input type="number" class="form-control" placeholder="Enter item quantity" id="quantity"  
                                 autocomplete="off" required="required">            
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                     <div class="col" id="supInput">
                        <!--Suppliers -->
                        
                     </div>

                     <div class="col">
                        <!-- Date In Stock-->
                        <div class="form-group text-light">
                                 <label for="">Date Added:</label>
                                 <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark">
                                    <i class="fas fa-calendar-days text-light"></i>
                                    </span>
                                          <input type="date" class="form-control" id="dateadded"  autocomplete="off" required="required">            
                                 </div>
                        </div>
                     </div>
                     
                  </div>

                  <div class="row">
                     <div class="col">
                          <!-- Date In Stock-->
                        <div class="form-group text-light">
                           <label for="">Expire Date:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                              <i class="fas fa-calendar-days text-light"></i>
                              </span>
                               <input type="date" class="form-control" id="expiredate"  autocomplete="off" required="required">            
                           </div>
                        </div>
                     </div>

                     <div class="col">
                          <!-- Expire Date -->
                          <div class="form-group text-light">
                              <label for="">Description:</label>
                              <div class="input-group mb-3">
                                 <textarea rows="3" cols="30" name="feedback" id="description">
                                 </textarea>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
            </form>
               <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="addproducts()" id="saveBtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
               </div>
            </div> 
         </div>
</div>
<!-- End of add product modal -->

<!-- Edit product modal -->
<div class="modal fade" id="editproduct" role="dialog">
            <div class="modal-dialog">
               <div style="background-color: #072370;" class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">EDITING OR UPDATING PRODUCTS</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" enctype="multipart/form-data" action="">
                  <div class="modal-body">


                  <div class="row">
                     <div class="col">
                        <!-- Product Name -->
                        <div class="form-group text-light">
                           <label for="">Product Name:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-tag text-light"></i>
                              </span>
                                    <input type="text" class="form-control" placeholder="Enter the name of Product" autocomplete="off" id="updateprodName" required="required">            
                           </div>
                        </div>

                     </div>
                     <div class="col" id="updatecatInput">
                        <!-- category -->
                        
                     </div>
                  </div>
                        
                        
                  <div class="row">
                     <div class="col">
                          <!-- Cost Price -->
                        <div class="form-group text-light">
                           <label for="">Cost Price:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-money-bill-wave text-light"></i>
                              </span>
                                    <input type="number" class="form-control" placeholder="Enter the cost price" id="updateCP" 
                                    autocomplete="off" step="0.01" min="0" maxlength="10"   required="required">          
                           </div>
                        </div>
                     </div>
                     <div class="col">
                          <!-- Sales price -->
                          <div class="form-group text-light">
                           <label for="">Sales Price:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-dollar-sign text-light"></i>
                              </span>
                                    <input type="number" class="form-control" placeholder="Enter the unit price" id="updateSP" 
                                    autocomplete="off" step="0.01" min="0" maxlength="10"   required="required">          
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                  <div class="col">
                          <!-- profit -->
                          <div class="form-group text-light">
                           <label for="">Profit:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                    <i class="fas fa-chart-line text-light"></i>
                              </span>
                                    <input type="number" class="form-control" placeholder="Enter the profit price" id="updateprofit" 
                                    autocomplete="off"  min="0" maxlength="10"   readonly>          
                           </div>
                        </div>
                     </div>
                     <div class="col">
                         <!-- Quantity -->
                         <div class="form-group text-light">
                           <label for="">Quantity:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                                   <i class="fas fa-sort-amount-up text-light"></i>                              
                              </span>
                                 <input type="number" class="form-control" placeholder="Enter item quantity" id="updatequantity"  
                                 autocomplete="off" required="required">            
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                     <div class="col" id="updatesupInput">
                        <!--Suppliers -->
                        
                     </div>

                     <div class="col">
                        <!-- Date In Stock-->
                        <div class="form-group text-light">
                                 <label for="">Date Added:</label>
                                 <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark">
                                    <i class="fas fa-calendar-days text-light"></i>
                                    </span>
                                          <input type="date" class="form-control" id="updateDIS"  autocomplete="off" required="required">            
                                 </div>
                        </div>
                     </div>
                     
                  </div>

                  <div class="row">
                     <div class="col">
                          <!-- Date In Stock-->
                        <div class="form-group text-light">
                           <label for="">Expire Date:</label>
                           <div class="input-group mb-3">
                              <span class="input-group-text bg-dark">
                              <i class="fas fa-calendar-days text-light"></i>
                              </span>
                                    <input type="date" class="form-control" id="updateEXP"  autocomplete="off" required="required">            
                           </div>
                        </div>
                     </div>

                     <div class="col">
                          <!-- Expire Date -->
                          <div class="form-group text-light">
                              <label for="">Description:</label>
                              <div class="input-group mb-3">
                                 <textarea rows="3" cols="30" name="feedback" id="updateDSC">
                                 </textarea>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
            </form>
               <div class="modal-footer">
                     <button type="button"  class="btn btn-dark" onclick="updateDetails()" id="savebtn">Save</button>
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">

               </div>
            </div> 
         </div>
</div>
<!-- End of edit product modal -->


<!-- product profile -->

   <!-- profile Modal -->
   <div class="modal fade" id="productprofile" role="dialog">
            <div class="modal-dialog">
               <div class="modal-content bg-primary">
                  <div class="modal-header">
                  <h5 class="modal-title text-light" id="exampleModalLabel">Product Profile <i class="fas fa-user-alt"></i></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body bg-dark">
                     <div class="container" id="profile">
                        <h6 class="text-light">Product Name: <input class="border-0 text-primary bg-dark" type="text" id="productname"></h6>
                        <h6 class="text-light">Category: <input class="border-0 text-primary bg-dark"  type="text" id="pcategory"></h6>
                        <h6 class="text-light">Cost Price: <input class="border-0 text-primary bg-dark" type="text" id="costprice"></h6>
                        <h6 class="text-light">Sales Price: <input class="border-0 text-primary bg-dark" type="text" id="salesprice"></h6>
                        <h6 class="text-light">Profit: <input class="border-0 text-primary bg-dark" type="text" id="pprofit"></h6>
                        <h6 class="text-light">Quantity: <input class="border-0 text-primary bg-dark" type="text" id="pquantity"></h6>
                        <h6 class="text-light">Supplier: <input class="border-0 text-primary bg-dark" type="text" id="psupplier"></h6>
                        <h6 class="text-light">Date Added: <input class="border-0 text-primary bg-dark" type="text" id="pdateadded"></h6>
                        <h6 class="text-light">Expire Date: <input class="border-0 text-primary bg-dark" type="text" id="pexpiredate"></h6>
                        <h6 class="text-light">Description: <input class="border-0 text-primary bg-dark" type="text" id="pdescription"></h6>

                     </div>

                  </div>
               <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                     <input type="hidden" id="hiddendata">
               </div>
             </div>
            </div>
         </div>
<!-- END OF PRODUCT PROFILE -->


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
            <!-- <li >
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="products.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="analytics.php">
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
				<a href="employees.php">
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
			</li>-->
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
					<h1>Products</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Product</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				
				
				<a href="prodExport.php" class="btn-download">
					<i style="color:#fff;" class='bx bxs-cloud-download' ></i>
					<span style="color:#fff;" class="text">Export To Excel</span>
				</a>
			</div>

			<ul class="box-info">
                <li title="number of products">
					<i class="bx bxs-shopping-bag"></i>
					<span class="text">
						<h3><?php echo $total_products?></h3>
						<p>Products</p>
					</span>
				</li>
                <li title="number of categories">
                <i class='bx bxs-category'></i>
					<span class="text">
						<h3><?php echo $total_categories?></h3>
						<p>Categories</p>
					</span>
				</li>
                <li title="within the week">
					<i class="bx bxs-calendar-check"></i>
					<span class="text">
						<h3><?php echo $total_sold?></h3>
						<p>Products Sold</p>
					</span>
				</li>
              
			</ul>

			<!-- productTable -->
			<div class="table-data">
               <div class="recent">
                  <div class="head">
                     <h3>All Products</h3>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#addproduct">+</a> 
                     <form action="#">
                        <div class="form-input">
                           <input id="search" type="text" placeholder="Search..." class="bg-light">
                           <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
                        </div>
                     </form>
                     <i class='bx bx-filter'></i>
                  </div>
                  <div id="prodTable">
                   
                  </div>
               </div>

			<!-- categories table -->

			   <div style="flex-grow: 1; flex-basis:50px;" class="recent">
                  <div class="head">
                     <h3>All Categories</h3>
                     <a href="#" data-bs-toggle="modal" data-bs-target="#addcategory">+</a> 
                     
                     <i class='bx bx-filter'></i>
                  </div>
                  <div id="catTable">
                   
                  </div>
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
                url:"prodTable.php",
                type:'POST',
                data:{
                displaySend:displayProd
                },
                success:function(data,status){
                $('#prodTable').html(data);
                }
            })
            }


			// display category table
		$(document).ready(function(){
                displayCat();
            });

            // display function
            function displayCat(){
            var displayCat="true";
            $.ajax({
                url:"catTable.php",
                type:'POST',
                data:{
                displaySend:displayCat
                },
                success:function(data,status){
                $('#catTable').html(data);
                }
            })
            }

     // display Category Input
		$(document).ready(function(){
                displayCatInput();
            });

            // display function
            function displayCatInput(){
            var displayCatInput="true";
            $.ajax({
                url:"catInput.php",
                type:'POST',
                data:{
                displayCategory:displayCatInput
                },
                success:function(data,status){
                $('#catInput').html(data);
                }
            })
            }


// category input 2 for update
            $(document).ready(function(){
                updateCatInput();
            });

            // display function
            function updateCatInput(){
            var updateCatInput="true";
            $.ajax({
                url:"updateCat.php",
                type:'POST',
                data:{
                updateCategory:updateCatInput
                },
                success:function(data,status){
                $('#updatecatInput').html(data);
                }
            })
            }


            // Suppliers Input 
		   $(document).ready(function(){
                displaySupInput();
            });

            // display function
            function displaySupInput(){
               var displaySupInput="true";
               $.ajax({
                  url:"supInput.php",
                  type:'POST',
                  data:{
                  displaySuppliers:displaySupInput
                  },
                  success:function(data,status){
                  $('#supInput').html(data);
                  }
               })
            }


  // Suppliers Input 2 for update customers
  $(document).ready(function(){
                updateSupInput();
            });

            // display function
            function updateSupInput(){
               var updateSupInput="true";
               $.ajax({
                  url:"updateSup.php",
                  type:'POST',
                  data:{
                  updateSuppliers:updateSupInput
                  },
                  success:function(data,status){
                  $('#updatesupInput').html(data);
                  }
               })
            }





//  // Add product
//  function addproducts(){
//        var prodNameAdd=$('#productName').val();
//        var categoryAdd=$('#category').val();
//        var CPAdd=$('#costPrice').val();
//        var SPAdd=$('#salesPrice').val();
//        var profitAdd=$('#profit').val();
//        var quantityAdd = $('#quantity').val();
//        var supplierAdd=$('#suppliers').val();
//        var DISAdd=$('#dateadded').val();
//        var EXPAdd=$('#expiredate').val();
//        var DSCAdd=$('#description').val();




       

//        $.ajax({
//            url:"prodAdd.php",
//            type:'post',
//            data:{
//               ProdNameSend:prodNameAdd,
//               CategorySend:categoryAdd,
//               CPSend:CPAdd,
//               SPSend:SPAdd,
//               ProfitSend: profitAdd,
//               QuantitySend:quantityAdd,
//               SupplierSend:supplierAdd,
//               DISSend:DISAdd,
//               EXPSend:EXPAdd,
//               DSCSend:DSCAdd,              
//            },
//           //  success:function(data,status)
//             success:function(data,status){
//             //function to display data;
//              console.log(status);
//             $('#addproduct').modal('hide');
//              displayProd();
//             location.reload();//refreshes the page
//            }
//         });
//       }

// Add product
function addproducts() {
    var prodNameAdd = $('#productName').val();
    var categoryAdd = $('#category').val();
    var CPAdd = $('#costPrice').val();
    var SPAdd = $('#salesPrice').val();
    var profitAdd = $('#profit').val();
    var quantityAdd = $('#quantity').val();
    var supplierAdd = $('#suppliers').val();
    var DISAdd = $('#dateadded').val();
    var EXPAdd = $('#expiredate').val();
    var DSCAdd = $('#description').val();

    $.ajax({
        url: "prodAdd.php",
        type: 'post',
        data: {
            ProdNameSend: prodNameAdd,
            CategorySend: categoryAdd,
            CPSend: CPAdd,
            SPSend: SPAdd,
            ProfitSend: profitAdd,
            QuantitySend: quantityAdd,
            SupplierSend: supplierAdd,
            DISSend: DISAdd,
            EXPSend: EXPAdd,
            DSCSend: DSCAdd,
        },
        success: function (data, status) {
            console.log(status);
            $('#addproduct').modal('hide');
            displayProd();
            location.reload(); // Refreshes the page

            // Notify the server that a new product has been added
            $.ajax({
                url: "newProduct.php", // Replace with the actual URL
                type: 'post',
                data: {
                    newProductAdded: prodNameAdd,
                },
                success: function (response) {
                    // Handle the response from the server if needed
                }
            });
        }
    });
  }


// check if Product quantity == 0
  $(document).ready(function () {
    // Trigger the PHP script to check product quantities
    $.ajax({
        type: 'POST', // You can use GET or POST based on your preference
        url: 'checkProductQuantity.php', // Adjust the path to your PHP script
        success: function (response) {
            // Handle the response from the PHP script
            console.log(response); // You can also display messages or perform other actions here
        },
        error: function (xhr, status, error) {
            // Handle errors, if any
            console.error("Error: " + error);
        }
    });
});



// CHECK FOR EXPIRY DATE
$(document).ready(function () {
    // Trigger the PHP script to check for products within 5 months of expiration
    $.ajax({
        type: 'GET', // You can use GET or POST based on your preference
        url: 'Expire.php', // Adjust the path to your PHP script
        success: function (response) {
            // Handle the response from the PHP script
            console.log(response); // You can also display messages or perform other actions here
        },
        error: function (xhr, status, error) {
            // Handle errors, if any
            console.error("Error: " + error);
        }
    });
});




   // Add category
 function addcategory(){
       var categoryNameAdd=$('#categoryName').val();
   
       $.ajax({
           url:"catAdd.php",
           type:'post',
           data:{
              categoryNameSend:categoryNameAdd,            
           },
          //  success:function(data,status)
            success:function(data,status){
            //function to display data;
             console.log(status);
            $('#addcategory').modal('hide');
             displayCat();
            location.reload();//refreshes the page
           }
        });
      }





  // function to calculate profit in the profit input field
   $(document).ready(function() {
      $('#costPrice, #salesPrice').on('keyup', function() {
         var cost_price = parseFloat($('#costPrice').val());
         var sales_price = parseFloat($('#salesPrice').val());
         var profit = sales_price - cost_price;
         if (!isNaN(profit)) {
         $('#profit').val(profit.toFixed(2));
         } else {
         $('#profit').val('');
         }
      });
   });



   // update using the cost price and unit price
   $(document).ready(function() {
      $('#updateCP, #updateSP').on('keyup', function() {
         var cost_price = parseFloat($('#updateCP').val());
         var sales_price = parseFloat($('#updateSP').val());
         var profit = sales_price - cost_price;
         if (!isNaN(profit)) {
         $('#updateprofit').val(profit.toFixed(2));
         } else {
         $('#updateprofit').val('');
         }
      });
   });

//   UPDATE PRODUCT 
function GetDetails(updateid){
      $('#hiddendata').val(updateid);

      $.post("prodUpdate.php",{updateid:updateid},function(data,status){
         var userid=JSON.parse(data);
         $('#updateprodName').val(userid.ProductName);
         $('#updatecategory').val(userid.Category);
         $('#updateCP').val(userid.CostPrice);
         $('#updateSP').val(userid.SalesPrice);
         $('#updateprofit').val(userid.Profit);
         $('#updatequantity').val(userid.Quantity);
         $('#updatesupplier').val(userid.Supplier);
         $('#updateDIS').val(userid.DateInStock);
         $('#updateEXP').val(userid.ExpireDate);
         $('#updateDSC').val(userid.Description);


      });

         $('#editproduct').modal('show');
   }

   // onclick update event function
   function updateDetails(){
      var updateprodName=$('#updateprodName').val();
      var updatecategory=$('#updatecategory').val();
      var updateCP=$('#updateCP').val();
      var updateSP=$('#updateSP').val();
      var updateprofit=$('#updateprofit').val();
      var updatequantity=$('#updatequantity').val();
      var updatesupplier=$('#updatesupplier').val();
      var updateDIS=$('#updateDIS').val();
      var updateEXP=$('#updateEXP').val();
      var updateDSC=$('#updateDSC').val();


      var hiddendata=$('#hiddendata').val();

      $.post("prodUpdate.php",{
         updateprodName:updateprodName,
         updatecategory:updatecategory,
         updateCP:updateCP,
         updateSP:updateSP,
         updateprofit:updateprofit,
         updatequantity:updatequantity,
         updatesupplier:updatesupplier,
         updateDIS:updateDIS,
         updateEXP:updateEXP,
         updateDSC:updateDSC,

         hiddendata:hiddendata

      },function(data,status){
      $('#editproduct').modal('hide');
      displayprod();
      })
   }




   $(document).ready(function () {
   // Bind a click event handler to the savebtn button
   $('#savebtn').click(function () {
      displayProd(); // Call the updateProd function when savebtn is clicked
   });
});



   //   UPDATE CATEGORY 
function GetCatDetails(updateCatid){
      $('#hiddenCatdata').val(updateCatid);

      $.post("catUpdate.php",{updateCatid:updateCatid},function(data,status){
         var catid=JSON.parse(data);
         $('#updatecatName').val(catid.CategoryName);

      });
         $('#editcategory').modal('show');
   }

   // onclick update event function
   function updateCatDetails(){
      var updatecatName=$('#updatecatName').val();

      var hiddenCatdata=$('#hiddenCatdata').val();

      $.post("catUpdate.php",{
         updatecatName:updatecatName,
        
         hiddenCatdata:hiddenCatdata

      },function(data,status){
      $('#editcategory').modal('hide');
      displayCat();
      })
   }


   // Delete category
   function DeleteCategory(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this category?");
    if (confirmation) {
        $.ajax({
            url: "catDelete.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayCat();
            }
        });
    }
}

   // Delete products
   function DeleteUser(deleteid) {
    // show a confirmation dialog before deleting the user
    var confirmation = confirm("Are you sure you want to delete this product?");
    if (confirmation) {
        $.ajax({
            url: "prodDelete.php",
            type: 'post',
            data: {
                deletesend: deleteid
            },
            success: function (data, status) {
                displayProd();
            }
        });
    }
}


// view profile
function viewProfile(updateid){
      $('#hiddendata').val(updateid);

      $.post("prodProfile.php",{updateid:updateid},function(data,status){
      var userid=JSON.parse(data);
      $('#productname').val(userid.ProductName);
      $('#pcategory').val(userid.Category);
      $('#costprice').val(userid.CostPrice);
      $('#salesprice').val(userid.SalesPrice);
      $('#pprofit').val(userid.Profit);
      $('#pquantity').val(userid.Quantity);
      $('#psupplier').val(userid.Supplier);
      $('#pdateadded').val(userid.DateInStock);
      $('#pexpiredate').val(userid.ExpireDate);
      $('#pdescription').val(userid.Description);

      });

      $('#productprofile').modal('show');
   }


     // search bar
$(document).ready(function(){
      $("#search").on("keyup", function() {
        var input = $(this).val();
        //alert(input);
        if(input != ""){
             $.ajax({
               url:"prodSearch.php",
               method:"POST",
               data:{input:input},

               success:function(data){
                  $("#prodTable").html(data);
               }
             });  
        }else{
            location.reload();
             $("#prodTable").css("display","block");
        }
      });
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

// display Notification
$(document).ready(function(){
		   displayNote();
	   });

	   // display function
	   function displayNote(){
	   var displayNote="true";
	   $.ajax({
		   url:"Unotification.php",
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