<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funstore</title>
    <!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../css/template.css">
</head>
<body>
    
    <!-- sidebar -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class="bx bx-smile"></i>
            <span class="text">FunStore</span>
        </a>

        <ul class="side-menu top">
            <li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
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
		<nav>
         <i class="bx bx-menu"></i>
		 <a href="#" class="nav-link">Categories</a>
		 <form action="#">
            <div class="form-input">
				<input type="search" placeholder="Search...">
				<button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
			</div>
		 </form>
		 <input type="checkbox" id="switch-mode" hidden>
		 <label for="switch-mode" class="switch-mode"></label>
		 <a href="#" class="notification">
			<i class="bx bxs-bell"></i>
			<span class="num">8</span>
		 </a>
		 <a class="profile" href="#">
			<img src="img/people.png" alt="">
		 </a>
	    </nav>
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
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
                <li>
					<i class="bx bxs-calendar-check"></i>
					<span class="text">
						<h3>1020</h3>
						<p>New Order</p>
					</span>
				</li>

				<li>
					<i class="bx bxs-group"></i>
					<span class="text">
						<h3>2834</h3>
						<p>Visitors</p>
					</span>
				</li>
				<li>
					<i class="bx bxs-dollar-circle"></i>
					<span class="text">
						<h3>2543</h3>
						<p>Total Sales</p>
					</span>
				</li>
			</ul>


        </main>
		<!-- main -->
	</section>
	<!-- content -->




    <script src="../js/template.js"></script>
</body>
</html>