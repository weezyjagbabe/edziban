<?php
	require_once './models/configurations/configuration.php'; // Include the overall Configurations file
	require_once './models/classes/Session.php'; // Include session class
	require_once './models/classes/Messaging.php'; // Include the messaging class file
	
	// Check if user has logged in. Redirect to login page if user is not logged in
	if ( ( !$session -> logged_in ) ) { header( "Location: login" ); }

	require_once './models/functions/functions.php'; // Include the functions file

	$pageTitle = $pageName . " - " . 'Payswitch-Adwane'; // Set the page title
	
	require_once 'documentHeader.php'; // Include the document head
?>
