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
require_once './DataBaseAdaptor.php';

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
?>