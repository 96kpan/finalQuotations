<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this codew absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Hassanain Jamal
// 
// TODO: Add control the new expected behavior to
// register
// log in
// flag one quote
// unflag all quotes
// log out
//
session_start();

require_once './DataBaseAdaptor.php';

$action = $_POST ['action'];

if (isset ( $_POST ['author'] ) && isset ( $_POST ['quote'] )) {
	$author = $_POST ['author'];
	$quote = $_POST ['quote'];
	$myDatabaseFunctions->addNewQuote ( $quote, $author );
	header ( "Location: ./index.php?mode=showQuotes" );
} elseif (isset ( $_POST ['action'] ) && isset ( $_POST ['ID'] )) {
	$action = $_POST ['action'];
	$ID = $_POST ['ID'];
	if ($action === 'increase') {
		$myDatabaseFunctions->raiseRating ( $ID );
	}
	if ($action === 'decrease') {
		$myDatabaseFunctions->lowerRating ( $ID );
	}
	if ($action === 'flag') {
		$myDatabaseFunctions->flag ( $ID );
	}
	
	header ( "Location: ./index.php?mode=showQuotes" );
}

if ($action === 'register') {
	header ( "Location: ./register.php" );
}
if ($action === 'login') {
	header ( "Location: ./login.php" );
}
if ($action === 'addQuote') {
	header ( "Location: ./addQuote.html" );
} 
if ($action ==='unflag'){
	$myDatabaseFunctions->unflagAll();
	header ("Location: ./index.php?mode=showQuotes");
}
if ($action === 'logout'){

	unset($_SESSION['key']);
	session_destroy();
	header ("Location: ./index.php?mode=showQuotes");
}
if(isset( $_POST['username']) && isset( $_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$_SESSION['error'] = "no";
	$result = $myDatabaseFunctions->login($username, $password);
	if($result == 0){
		$_SESSION['key'] = $username;
		$_SESSION['error'] = "no";
		header ( "Location: ./index.php?mode=showQuotes" );
	}
	else{
		$_SESSION['error'] = "yes";
		header ("Location: ./login.php");
	}
}

if(isset($_POST['create_username']) && isset($_POST['create_password'])){
	$username = $_POST['create_username'];
	$password = $_POST['create_password'];
	$_SESSION['error'] = "no";
	$result = $myDatabaseFunctions->addUser($username, $password);
	if($result == 1) {
		$_SESSION['error'] = "yes";
		header ( "Location: ./register.php" );
	}
	else{
		$_SESSION['error'] = "no";
		header("Location: ./index.php?mode=showQuotes");
	}
}

?>








