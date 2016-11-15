<!-- 
Filename: index.php

This file is the page manager. It is what will load the 'home' page by default.
If a url argument contains ?mode=addQoute, ?mode=login, or ?mode=register, a different
HTML page will be loaded, each of which has a form.  

When the form is submitted, the controller absorbs the form and redirects back to here usually.
If an account exists or a login fails, the controller loads the appropriate form to try again.

Authors: Hassanain Jamal and Rick Mercer

-->
<!DOCTYPE html>
<html>
<head>
<title>Rick Mercer's Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<?php
if (isset ( $_GET ['mode'] )) {
  if ($_GET ['mode'] === 'showQuotes')
    require_once ("./showQuotes.php");
  elseif ($_GET ['mode'] === 'new')
    require_once ("./addQuote.html");
  elseif ($_GET ['mode'] === 'login')
    require_once ("./login.html");
  elseif ($_GET ['mode'] === 'register')
    require_once ("./register.html");
} else // default
  require_once ("./showQuotes.php");

?>
</body>
</html>