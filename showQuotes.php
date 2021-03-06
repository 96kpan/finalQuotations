<!-- 
This is the home page for Final Project, Part 1, Fall 2016 Quotes Enhanced.  

Any user can flag quotes, add quotes, or register as a user.  If registered and logged in, the
user can unflag all quotes to see all quotes in the data base. Yes some of the behavior is 
contrived, in order to review many concepts in the context of a larger web service.  

File name quotes.php 

Show the home page view with tabs to login, registration, and to add a new quote and most importantly to
show all unflagged quotes in the data base sorted by ranking
    
Author: Rick Mercer
-->

<?php

require_once './DataBaseAdaptor.php';

$arrayOfQuotes = $myDatabaseFunctions->getQuotesAsArray ();

?>

<h1>Quotes</h1>

<form action="controller.php" method="post">
	&nbsp;&nbsp;&nbsp;
	<button name="action" value="register">Register</button>
	&nbsp;&nbsp;&nbsp;
	<button name="action" value="login">Login</button>
	&nbsp;&nbsp;&nbsp;
	<button name="action" value="addQuote">Add Quote</button>
	<?php

	session_start ();

	if (isset ( $_SESSION ['key'] )) {

	?>
	&nbsp;&nbsp;&nbsp;
	<button name="action" value="unflag">Unflag All</button>
	&nbsp;&nbsp;&nbsp;
	<button name="action" value="logout">Logout</button>
	<?php

	}

	?>
</form>

<!-- Add a horizontal menu -->


<!--  Show all quotes on a separate row -->
<?php foreach($arrayOfQuotes as $quote) { ?>

<div class="container">
		 <?= '"'. $quote['quote'] . '"' ?>  
     <br>
	<p class="author"> 
     &nbsp;&nbsp;--
     <?= $quote['author'] ?>  
     <br>
	</p>

	<form action="controller.php" method="post">
		<input type="hidden" name="ID" value="<?= $quote['id']?>">
		&nbsp;&nbsp;&nbsp;
		<button name="action" value="increase">+</button>

		<span id="rating"> <?= $quote['rating']?> </span>
		<button name="action" value="decrease">-</button>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="flag"> </span>
		<button name="action" value="flag">Flag</button>
	</form>

</div>
<br>

<?php } // End for loop  ?>

</body>
</html>