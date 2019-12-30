<?php
if(isset($_SESSION['admin_user_id'])){


	$t_users				= $mysqlPrefixSav . "users";
	$t_tasks_subscriptions_to_new_tasks 	= $mysqlPrefixSav . "tasks_subscriptions_to_new_tasks";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_subscriptions_to_new_tasks") or die(mysqli_error());


$query = "SELECT * FROM $t_tasks_subscriptions_to_new_tasks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{


	mysqli_query($link, "CREATE TABLE $t_tasks_subscriptions_to_new_tasks(
	   subscription_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(subscription_id), 
	   subscription_user_id INT,
	   subscription_user_email VARCHAR(250),
	   subscription_last_sendt_datetime DATETIME,
	   subscription_last_sendt_time VARCHAR(200))")
	or die(mysqli_error($link));


	// Find all admins, put them into subscription list
	$datetime = date("Y-m-d H:i:s");
	$time = time();
	$query = "SELECT user_id, user_email, user_name, user_rank FROM $t_users WHERE user_rank='admin'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_user_id, $get_user_email, $get_user_name, $get_user_rank) = $row;
		$inp_email_mysql = quote_smart($link, $get_user_email);

		mysqli_query($link, "INSERT INTO $t_tasks_subscriptions_to_new_tasks
		(subscription_id , subscription_user_id, subscription_user_email, subscription_last_sendt_datetime, subscription_last_sendt_time) 
		VALUES 
		(NULL, '$get_user_id', $inp_email_mysql, '$datetime', '$time')")
		or die(mysqli_error($link));
	}


}





}
?>