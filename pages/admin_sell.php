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



$noteSQL = mysqli_query($conn, "SELECT * FROM `notification`"); 
$total_messages = mysqli_num_rows($noteSQL);

$badgeSQL =mysqli_query($conn,"SELECT * FROM cart");
$total_productsInCart = mysqli_num_rows($badgeSQL);
// ?>

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
		.shopping-cart{
			font-size: 30px;
		}

		.pagination{
			cursor: pointer;
		}

		/* Style for form elements */
		#sales-form {
        display: inline-block;
        margin-right: 20px; /* Add spacing between form elements */
    }

    /* Apply different styles for smaller screens */
    @media (max-width: 768px) {
        #sales-form {
            display: block; /* Display form elements vertically on smaller screens */
            margin-right: 0; /* Remove spacing between form elements */
            margin-bottom: 10px; /* Add margin between form elements */
        }
    }

	</style>
</head>
<body>
<!-- cart modal -->
<div style="z-index: 6000;"  class="modal fade" id="cartmodal" role="dialog">
  <div style="max-width: 1400px;" class="modal-dialog">
    <div  class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalLabel">PRODUCTS CART</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="cartTable" class="table-responsive">

        </div>

		<div style="display: flex; flex-direction:column; flex-wrap:wrap;" class="form-section"  >
			<form id="customer-form">
				<div class="form-group" id="sales-form">
					<label for="grand_total" class="text-light">GRAND TOTAL:</label>
					<input style="width: 130px;" type="text" id="grand_total" value="0.00" readonly>
				</div>
				<div class="form-group" id="sales-form">
					<label for="customer_name" class="text-light">CUSTOMER NAME:</label>
					<input style="width: 130px;" type="text" id="customer_name">
				</div>
				<div class="form-group" id="sales-form">
					<label for="phone" class="text-light">CONTACT:</label>
					<input type="text" id="phone" autocomplete="off" maxlength="10" minlength="10" required="required">
				</div>
			</form>
        </div>

      </div>
      <div class="modal-footer">
	     <span id="SB_input">  

		 </span>
        <a class="btn btn-primary" href="print.php">Print</a>
		<button id="save-button" class="btn btn-success">Save Data</button> 
        <button type="button" class="btn btn-danger" id="clear-cart">Clear Cart</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end of cart modal -->

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
        <a href="#" class="brand">
            <i class="bx bxs-shopping-bag"></i>
            <span class="text"><?php echo $CompName ?></span>
        </a>

        <ul class="side-menu top p-0">
            <li >
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="../pages/admin_prod.php">
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
					<h1>Products</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Product</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Point Of Sale</a>
						</li>
					</ul>
					
				</div>
				<a href="" class="shopping-cart" data-bs-toggle="modal" data-bs-target="#cartmodal">
					<i class="bx bxs-cart text-dark"></i>
					<span class="badge bg-danger"><?php echo $total_productsInCart?></span>
				</a>
				<a href="products.php" class="btn-home">
					<i class='bx bxs-home' style='color:#fffcfc'></i>
					<span style="color:#fff;" class="text">Home</span>
				</a>

		
			</div>

			<!-- productTable -->
			<div class="table-data">
				<div class="recent">
				<div class="head">
                     <h3>Sell Products</h3>   

                     <form action="#">
                        <div class="form-input">
                           <input id="search" type="text" placeholder="Search..." class="bg-light">
                           <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
                        </div>
                     </form>
                     <i class='bx bx-filter'></i>
                  </div>
                  <div id="sellTable">
                   
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
 function AddToCart(updateid) {
  // Set the hidden data value
  $('#hiddendata').val(updateid);

  // Make an AJAX call to the `cartdetails.php` file
  var cartProfileDeferred = $.ajax({
    type: 'POST',
    url: 'cartDetails.php',
    data: { updateid: updateid },
    success: function(data, status) {
      // Parse the JSON response
      var userid = JSON.parse(data);

      // Set the values of the productName, price,category, profit and quantity input fields
      $('#productName').val(userid.ProductName);
	  $('#category').val(userid.Category);
      $('#price').val(userid.SalesPrice);
	  $('#profit').val(userid.Profit);

    }
  });

  // Add the product to the cart
  cartProfileDeferred.done(function () {
    var productNameAdd = $("#productName").val();
    var categoryAdd = $("#category").val();
    var priceAdd = $("#price").val();
    var profitAdd = $("#profit").val();

    // Make an AJAX call to the `addToCart.php` file
    $.ajax({
        type: 'POST',
        url: 'addToCart.php',
        data: {
            productNameSend: productNameAdd,
            categorySend: categoryAdd,
            priceSend: priceAdd,
            profitSend: profitAdd
        },
        success: function (response) {
            // Check the response from the PHP file
            if (response.trim() == "error") {
                alert("There was an error adding the product to your cart.");
            } else if (response.trim() == "already_added") {
                alert("The product is already in your cart.");
            } else if (response.trim() == "out_of_stock") {
                alert("The product is out of stock.");
            } else if (response.trim() == "success") {
                // Update the badge to show the new total number of products
                var badge = $('.badge');
                var currentCount = parseInt(badge.text());
                badge.text(currentCount + 1);
                // alert("The product has been added to your cart.");
                displayCart();
            } else {
                alert("An unknown error occurred.");
            }
        }
    });
 });
}






		// display database table
		$(document).ready(function(){
                displayProd();
            });

            // display function
            function displayProd(){
            var displayProd="true";
            $.ajax({
                url:"sellTable.php",
                type:'POST',
                data:{
                displaySend:displayProd
                },
                success:function(data,status){
                $('#sellTable').html(data);
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
				url: 'sellTable.php', // Replace with the path to your PHP file
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
				url: 'sellTable.php', // Replace with the path to your PHP file
				type: 'POST',
				data: {
					page: pageId,
					displaySend: 1,
					limit: limit
				},
				success: function(response) {
					$('#sellTable').html(response);
				}
			});
		}
		});




		    // search bar
		$(document).ready(function(){
			$("#search").on("keyup", function() {
				var input = $(this).val();
				//alert(input);
				if(input != ""){
					$.ajax({
					url:"sellSearch.php",
					method:"POST",
					data:{input:input},

					success:function(data){
						$("#sellTable").html(data);
					}
					});  
				}else{
					location.reload();
					$("#sellTable").css("display","block");
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

	  // display cart table
		$(document).ready(function(){
                displayCart();
            });

            // display function
            function displayCart(){
            var displayCart="true";
            $.ajax({
                url:"cartTable.php",
                type:'POST',
                data:{
                displaySend:displayCart
                },
                success:function(data,status){
                $('#cartTable').html(data);
                }
            })
          }




         //clear cart function
		$(document).ready(function() {
			$('#clear-cart').on('click', function() {
				if(confirm("Are you sure you want to clear the cart?")) {
				$.ajax({
					url: 'clearCart.php',
					method: 'POST',
					data: {clearCart: 1},
					success: function(response){
					// alert(response);
					// Reload the cart modal to show updated cart contents
					location.reload();
					}
				});
				}
			});
		});	


		$(document).on('input', '#cartTable input.quantity', function() {
			var row = $(this).closest('tr');
			var price = parseFloat(row.find('td:eq(3)').text().replace('₵', ''));
			var quantity = parseFloat($(this).val());
			var profit = parseFloat(row.find('td:eq(5)').find('.profit').data('profit'));

			var total = price * quantity;
			row.find('input.total_price').val(isNaN(total) ? '' :  total.toFixed(2));

			var profit_total = quantity * profit;
			row.find('input.profit').val(isNaN(total) ? '' :  profit_total.toFixed(2));

			var grand_total = 0;
			$('input.total_price').each(function() {
				var val = parseFloat($(this).val().replace('₵', ''));
				grand_total += isNaN(val) ? 0 : val;
			});
			$('#grand_total').val( grand_total.toFixed(2));
		});
		//let us do same for amount paid and balance. but it wont enter the database. it just meant to help calculate for the balance for the vendor



        //Remove product from cart
		function DeleteCartproduct(deleteproduct) {
		// show a confirmation dialog before deleting the user
		var confirmation = confirm("Are you sure you want to remove this product from cart?");
		if (confirmation) {
			$.ajax({
				url: "cartProdDel.php",
				type: 'post',
				data: {
					del_Cart_product: deleteproduct
				},
				success: function (data, status){
					displayCart();
				}
			});
		  }
		}



  //Remove item from cart
function DeleteCartItem(deleteItem) {
  // show a confirmation dialog before deleting the user
  var confirmation = confirm("Are you sure you want to remove this item from cart?");
  if (confirmation) {
      $.ajax({
          url: "del_cart_item.php",
          type: 'post',
          data: {
              del_Cart_item: deleteItem
          },
          success: function (data, status){
            displayCart();
          }
      });
  }
}


$(document).ready(function() {
   // Clear the flag in localStorage when the page loads
    localStorage.removeItem('isButtonDisabled');

    // Handle the save button click event
    $("#save-button").click(function() {
        // Disable the button
        $(this).attr("disabled", "disabled");
        
        // Set a flag in localStorage to remember that the button is disabled
        localStorage.setItem('isButtonDisabled', 'true');
        
        // Capture the table data and send it to PHP script
        var tableData = [];

		var custName = $("#customer_name").val(); // Get customer name
        var phone = $("#phone").val(); // Get phone number

        // Validate inputs
        if (custName.trim() === "") {
            alert("Please enter customer name.");
            return;
        }

        if (phone.trim() === "") {
            alert("Please enter mobile number.");
            return;
        }

        $("#cartTable tbody tr").each(function() {
            var rowData = [];

            rowData.push($(this).find("td:eq(1)").text()); // Product Name
            rowData.push($(this).find("td:eq(2)").text()); // Category
            rowData.push($(this).find("td:eq(3)").text()); // Sales Price
            rowData.push(parseInt($(this).find(".quantity").val())); // Quantity
            rowData.push(parseFloat($(this).find(".profit").val())); // Profit
            rowData.push(parseFloat($(this).find(".total_price").val())); // Total Price
            rowData.push($(this).find("td:eq(7)").text()); // Date

            tableData.push(rowData);
        });

        var grandTotal = parseFloat($("#grand_total").val());
        var customerName = $("#customer_name").val();
        var phone = $("#phone").val();
        var servedby = $("#SB").val(); // Assuming you have an element with id "SB" for servedBy

        // Prepare the data for AJAX
        var requestData = {
            tableData: JSON.stringify(tableData), // Change key to match PHP
            grandTotal: grandTotal,
            customerName: customerName,
            phone: phone,
            servedby: servedby
        };

        // Send data to PHP script using AJAX
        $.ajax({
            type: "POST",
            url: "saveCartData.php",
            data: requestData,
            success: function(response) {
                alert(response); // Show a success message or handle the response
            }
        });
    });
});




// // Save all the data in cart table
// $(document).ready(function() {
//         // Handle the save button click event
//         $("#save-button").click(function() {
//             // Capture the table data and send it to PHP script
//             var tableData = [];

//             $("#cartTable tbody tr").each(function() {
//                 var rowData = [];

//                 rowData.push($(this).find("td:eq(1)").text()); // Product Name
//                 rowData.push($(this).find("td:eq(2)").text()); // Category
//                 rowData.push($(this).find("td:eq(3)").text());//.replace('₵', ''))); // Sales Price
//                 rowData.push(parseInt($(this).find(".quantity").val())); // Quantity
//                 rowData.push(parseFloat($(this).find(".profit").val())); // Profit
//                 rowData.push(parseFloat($(this).find(".total_price").val())); // Total Price
//                 rowData.push($(this).find("td:eq(7)").text()); // Date

//                 tableData.push(rowData);
//             });

//             var grandTotal = parseFloat($("#grand_total").val());
//             var customerName = $("#customer_name").val();
//             var phone = $("#phone").val();
// 			var servedby =  $("#SB").val();

//             // Prepare the data for AJAX
//             var requestData = {
//                 cartTable: JSON.stringify(cartTable),
//                 grandTotal: grandTotal,
//                 customerName: customerName,
//                 phone: phone,
// 				servedby:servedby
//             };

//             // Send data to PHP script using AJAX
//             $.ajax({
//                 type: "POST",
//                 url: "saveCartData.php",
//                 data: requestData,
//                 success: function(response) {
//                     alert(response); // Show a success message or handle the response
//                 }
//             });
//         });
//     });





// // Save data into the sales table
//  function saveCart(updateid) {
//   // Set the hidden data value
//   $('#hiddendata').val(updateid);

//   // Make an AJAX call to the `cartdetails.php` file
//   var cartProfileDeferred = $.ajax({
//     type: 'POST',
//     url: 'getCartDetails.php',
//     data: { updateid: updateid },
//     success: function(data, status) {
//       // Parse the JSON response
//       var userid = JSON.parse(data);

//       // Set the values of the productName,category, price, and quantity input fields
// 	  $('#productName').val(userid.ProductName);
// 	  $('#category').val(userid.Category);
//       $('#price').val(userid.SalesPrice);
//     }
//   });

//   // Add the cart details to the sales
//   cartProfileDeferred.done(function() {
// 	var custNameAdd = $("#customer_name").val();
//     var prodNameAdd = $("#productName").val();
// 	var categoryAdd = $("#category").val();
// 	var priceAdd = $("#price").val();
//     var quantityAdd =  $("#quantity").val();
//     var totalPriceAdd =  $("#total_price").val();
// 	var phoneAdd =  $("#phone").val();
// 	var gTotalAdd =  $("#grand_total").val();
// 	var servedbyAdd =  $("#SB").val();
// 	var profitAdd =  $("#profit").val();




// 	 // Validate inputs
// 	 if(custNameAdd == ""){
//             alert("Please enter customer name.");
//             return false;
//         }
    

//     // Make an AJAX call to the `add_to_sales.php` file
//     $.ajax({
//       type: 'POST',
//       url: 'saveCartData.php',
//       data: {
//         custNameSend: custNameAdd,
// 		prodNameSend: prodNameAdd,
// 		categorySend: categoryAdd,
//         priceSend: priceAdd,
//         quantitySend:quantityAdd,
//         totalPriceSend:totalPriceAdd,
// 	    phoneSend:phoneAdd,
//         gTotalSend:gTotalAdd,
//         servedbySend:servedbyAdd,
// 		profitSend:profitAdd,

//       },
//       success: function(response) {
//         // Check the response from the PHP file
//         if (response.trim() == "error") {
//           alert("There was an error saving data.");
//         } else if (response.trim() == "already_saved") {
//           alert("Already saved data.");
//         } else {
//          alert("Saved successfully.");
//         }
//       }
//     });
//   });
// }




// served by
 $(document).ready(function(){
	displaySB();
});

// display function
function displaySB(){
var displaySB="true";
$.ajax({
	url:"servedby.php",
	type:'POST',
	data:{
	displaySB:displaySB
	},
	success:function(data,status){
	$('#SB_input').html(data);
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