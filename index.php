<?php
	$conn = mysqli_connect('localhost','root','','budget');
	$Payment_mode_name = array(1=>'Money',2=>'Gpay',3=>'Tata Card',4=>'Sbi Card',5=>'Netbanking',6=>'Hdfc Card');
	if($_POST['p_date']!="" && $_POST['p_item']!="" && $_POST['p_price']!="" && $_POST['p_mode']!="")
	{
		$date = $_POST['p_date'];
		$item = $_POST['p_item'];
		$price = $_POST['p_price'];
		$pmode = $_POST['p_mode'];		
		$pid = $_POST['p_id'];
		if($conn && $pid=='')
		{
			$sql = "Insert into `purchase_details` (`p_date`,`p_item`,`p_price`,`p_paymentmode`) values('$date','$item','$price','$pmode')";
			$res = mysqli_query($conn,$sql);
			if($res)
			{
				echo "Data Inserted Successfully";
				header('location: index.php');
			}
		}
		elseif ($pid!='') {

			$sql = "update `purchase_details` SET p_date='$date',p_item='$item',p_price='$price',p_paymentmode='$pmode' WHERE p_id=$pid";
			$res = mysqli_query($conn,$sql);
			if($res)
			{
				echo "Data Updated Successfully";
				header('location: index.php');
			}
		}
		
	}
	if($conn)
	{
		$datasql = "select * from `purchase_details`";
		$res_data = mysqli_query($conn,$datasql);
	}
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$record = mysqli_query($conn, "SELECT * FROM `purchase_details` WHERE `p_id`=$id");
		if ($record) {
			$fetch_res = mysqli_fetch_array($record);
		}
	}
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		$res = mysqli_query($conn, "delete FROM `purchase_details` WHERE `p_id`=$id");
		if ($res) {
			echo "Data Deleted Successfully";
			header('location: index.php');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		myproject
	</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="row">
		<div class="container">
			<div class="col-md-4"> 
			</div>
			<div class="col-md-4"> 			
				<h3 style="text-align:center">Budget Form</h3>	
				<form class="form-horizontal" method="post" action="">
					<input type="hidden" class="form-control" name="p_id" id="p_id" value="<?php echo $fetch_res['p_id'];?>">
					<div class="form-group">
						<label>Purchase Date</label>
						<input type="date" class="form-control" name="p_date" id="p_date" value="<?php echo $fetch_res['p_date'];?>" required>
					</div>
					<div class="form-group">
						<label>Purchase Items</label>
						<input type="text" class="form-control" name="p_item" id="p_item" value="<?php echo $fetch_res['p_item'];?>" required>
					</div>
					<div class="form-group">
						<label>Price</label>
						<input type="number" class="form-control" name="p_price" id="p_price" value="<?php echo $fetch_res['p_price'];?>" required>
					</div>
					<div class="form-group">
						<label>Payment Mode</label>
						<select name="p_mode" class="form-control" value="<?php echo $fetch_res['p_paymentmode'];?>" required>
							<option <?php if($fetch_res['p_paymentmode']==1){ ?> selected="selected" <?php }?> value="1">Money</option>
							<option <?php if($fetch_res['p_paymentmode']==2){ ?> selected="selected" <?php }?> value="2">Gpay</option>
							<option <?php if($fetch_res['p_paymentmode']==3){ ?> selected="selected" <?php }?> value="3">Tata Card</option>
							<option <?php if($fetch_res['p_paymentmode']==4){ ?> selected="selected" <?php }?> value="4">Sbi Card</option>
							<option <?php if($fetch_res['p_paymentmode']==5){ ?> selected="selected" <?php }?> value="5">Netbanking</option>
							<option <?php if($fetch_res['p_paymentmode']==6){ ?> selected="selected" <?php }?> value="6">Hdfc Card</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" class="form-control btn-primary" name="submit" value="submit">
					</div>
				</form>
			</div>
			<div class="col-md-4"> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3"> 
		</div>
		<div class="col-md-6"> 
			<table class="table" style="">
				<tr>
					<th>Date</th>
					<th>Items</th>
					<th>Price</th>
					<th>Mode of Payment</th>
					<th>Options</th>
				</tr>
				<?php foreach ($res_data as $key => $value) {?>
					<tr>
						<td><?php echo $value['p_date'];?></td>
						<td><?php echo $value['p_item'];?></td>
						<td><?php echo $value['p_price'];?></td>
						<td><?php echo $Payment_mode_name[$value['p_paymentmode']];?></td>
						<td>
						<a href="index.php?edit=<?php echo $value['p_id']; ?>" class="edit_btn" >Edit</a>
						</td>
						<td>
						<a href="index.php?del=<?php echo $value['p_id']; ?>" class="del_btn">Delete</a>
						</td>
					</tr>			
				<?php }?>
			</table>
		</div>
		<div class="col-md-3"> 
		</div>
	</div>
	
</body>
</html>
