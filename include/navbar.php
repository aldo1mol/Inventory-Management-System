<!-- navbar -->

      <nav>
         <i class="bx bx-menu"></i>
		 <a href="#" class="nav-link"></a>
		 <form action="#">
			<p style = "color:#323232;" id="time"></p>
			<script>
			function updateTime() {
			var now = new Date();
			var time = now.toLocaleString();
			document.getElementById("time").innerHTML = time;
			}

			setInterval(updateTime, 1000); // Update the time every second
			</script>
			
		 </form>
		 <a style="margin-left: auto;" href="#" data-bs-toggle="modal" data-bs-target="#notemodal" class="notification">
			<i class="bx bxs-bell"></i>
			<span class="num"><?php echo $total_messages ?></span>
		 </a>
		<!-- displays current user -->
		<div  style="text-transform: uppercase; padding:10px; border-radius:1.3rem;" class="bg-primary text-light" >
		     <i class="bx bxs-group"></i>
		    <?php echo "<strong>" . $_SESSION['username'] . "</strong>"; ?>
	    </div>
	 </nav>