<?php
// functions.php
function check_txnid($tnxid){
	global $link;
	// return true;
	$valid_txnid = true;
	//get result set
	$query="SELECT * FROM `payments` WHERE txnid = '$tnxid'" ;
	$result = mysqli_query($link,$query);
	if ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
		$valid_txnid = false;
	}
	return $valid_txnid;
}

function check_price($price, $id){
	$valid_price = false;
	$query="SELECT amount FROM `products` WHERE id = '$id'";
	$result = mysqli_query($link,$query);
	if (mysqli_num_rows($result) != 0) {
		while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			$num = (float)$row['amount'];
			if($num == $price){
				$valid_price = true;
			}
		}
	}
	return $valid_price;
	
}

function updatePayments($data){
	global $link;
	
	if (is_array($data)) {
		$query="INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES (
				'".$data['txn_id']."' ,
				'".$data['payment_amount']."' ,
				'".$data['payment_status']."' ,
				'".$data['item_number']."' ,
				'".date("Y-m-d H:i:s")."'
				)";
		$sql = mysqli_query($link,$query);
		return mysqli_insert_id($link);
	}
}
