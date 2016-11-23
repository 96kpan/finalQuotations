 <?php
	// Quotes Enhanced: a Dynamic Website that is Part 1 of a final project
	// as a final project, except there is no AJAX in this example.
	//
	// Author: Rick Mercer and Hassanain Jamal
	//
	// TODO: Handle the two new forms for
	// registering
	// logging in
	// flagging one quote
	// unflagging all quotes
	// logging out
	//
	class DatabaseAdaptor {
		// The instance variable used in every one of the functions in class DatbaseAdaptor
		private $DB;
		// Make a connection to an existing data based named 'quotes' that has
		// table quote. In this assignment you will also need a new table named 'users'
		public function __construct() {
			$db = 'mysql:dbname=quotes;host=127.0.0.1';
			$user = 'root';
			$password = '';
			
			try {
				$this->DB = new PDO ( $db, $user, $password );
				$this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} catch ( PDOException $e ) {
				echo ('Error establishing Connection');
				exit ();
			}
		}
		
		// Return all quote records as an associative array.
		// Example code to show id and flagged columns of all records:
		// $myDatabaseFunctions = new DatabaseAdaptor();
		// $array = $myDatabaseFunctions->getQuotesAsArray();
		// foreach($array as $record) {
		// echo $record['id'] . ' ' . $record['flagged'] . PHP_EOL;
		// }
		//
		public function getQuotesAsArray() {
			// possible values of flagged are 't', 'f';
			$stmt = $this->DB->prepare ( "SELECT * FROM quotations WHERE flagged='f' ORDER BY rating DESC, added" );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
	
		// Insert a new quote into the database
		public function addNewQuote($quote, $author) {
			$stmt = $this->DB->prepare ( "INSERT INTO quotations (added, quote, author, rating, flagged ) values(now(), :quote, :author, 0, 'f')" );
			$stmt->bindParam ( 'quote', $quote );
			$stmt->bindParam ( 'author', $author );
			$stmt->execute ();
		}
		
		// Raise the rating of the quote with the given $ID by 1
		public function raiseRating($ID) {
			$stmt = $this->DB->prepare ( "UPDATE quotations SET rating=rating+1 WHERE id= :ID" );
			$stmt->bindParam ( 'ID', $ID );
			$stmt->execute ();
		}
		
		// Lower the rating of the quote with the given $ID by 1
		public function lowerRating($ID) {
			$stmt = $this->DB->prepare ( "UPDATE quotations SET rating=rating-1 WHERE id= :ID" );
			$stmt->bindParam ( 'ID', $ID );
			$stmt->execute ();
		}
		
		// this will toggle the flag element in the database. If it is already flagged (1), then we can unflag it (0).
		// likewise, if it already unflagged (0), then we will change it to flag (1)
		public function flag($ID) {
			$stmt = $this->DB->prepare ( "UPDATE quotations SET flagged='t' WHERE id= :ID" );
			$stmt->bindParam ( 'ID', $ID );
			$stmt->execute ();
		}
		
		// Clicking unflag all makes ALL quotations show up
		public function unflagAll() {
			$stmt = $this->DB->prepare ( "update quotations set flagged='f'" );
			$stmt->execute ();
		}
		
		// find username in db
		public function getPassword($username){
			$stmt = $this->DB->prepare("SELECT password FROM users WHERE username = :username");
			$stmt->bindParam ( 'username', $username );
			$stmt->execute ();
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		}
		
		// add user
		public function addUser($username, $password){
			$stmt = $this->DB->prepare("select username from users where username = :username");
			$stmt->bindParam ('username', $username);
			$stmt->execute();
			$result = $stmt->fetchAll ( PDO::FETCH_ASSOC );
			if(count($result)!=0){
				return 1;
			}
			else{
				$hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
				$stmt = $this->DB->prepare ( "INSERT INTO users (username, password) values(:username, :password)" );
				$stmt->bindParam ( 'username', $username );
				$stmt->bindParam ( 'password', $hashed_pwd );
				$stmt->execute ();
				return 0;
			}
		}
		
		public function login($username, $password){
			$stmt = $this->DB->prepare("SELECT password FROM users WHERE username = :user");
			$stmt->bindParam ( 'user', $username );
			$stmt->execute ();
			$hash = $stmt->fetch();
			if(count($hash)!=0){
				if(password_verify($password, $hash['password'])){
					return 0;
				}
				else{
					return 1;
				}
			}
			else{
				return 1;
			}
		}
	} // end class DatabaseAdaptor
	
	$myDatabaseFunctions = new DatabaseAdaptor ();
	
	// Test code can only be used temporarily here. If kept, deleting account 'fourth' from anywhere would
	// cause these asserts to generate error messages. And when did you find out 'fourth' is registered?
	// assert ( $myDatabaseFunctions->verified ( 'fourth', '4444' ) );
	// assert ( ! $myDatabaseFunctions->canRegister ( 'fourth' ) );
	?>