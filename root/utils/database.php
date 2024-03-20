<?php
/*
* MySQL Database Connector
*/

namespace Utils\Database;

use mysqli;

/**
 * DBConnection is an abstraction of UCLan Shop
 * SQL database.
 *
 * Example usage:
 * $db = new DBConnection();
 * $hoodies = $db::getProductsOfType("Hoodie");
 */
class DBConnection {
    private $conn;

    /*
	Database definitions
	*/
    private $products_table = "tbl_products";
    private $orders_table   = "tbl_orders";
    private $offers_table   = "tbl_offers";
    private $reviews_table  = "tbl_reviews";
    private $users_table    = "tbl_users";

    /**
	 * Connect to the database using the environment configuration
	*/
    public function __construct() {
        require('env.php');

        $servername = $env['SQL_DB_HOST'];
        $username = $env['SQL_DB_USER'];
        $password = $env['SQL_DB_PASS'];
        $dbname = $env['SQL_DB_NAME'];

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Could not connect to database: " . $this->conn->connect_error);
        }
    }

    /**
	 * Clean up trailing database connections
	*/
    function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    /**
	 * Returns all products of type `$type` as an array
	*/
    public function getProductsOfType(string $type) {
        $sql_query = $this->conn->prepare("SELECT * FROM ".$this->products_table." WHERE product_type=?");
        $sql_query->execute([$type]);

        $result = $sql_query->get_result();
        $sql_query->close();
        
        return $result;
    }

    /**
	 * Returns the information of product with `$id`
     * 
     * @param string $id ID of the requested item
     * 
     * @return mysqli_result|false SQL query results or `false` if product could not be found
	*/
    public function getProductInfo(string $id) {
        $sql_query = $this->conn->prepare("SELECT * FROM ".$this->products_table." WHERE product_id=?");
        $sql_query->execute([$id]);

        $result = $sql_query->get_result();
        $sql_query->close();
        
        return $result;
    }
    
    /**
     * Returns boolean describing whether `$email` has already been registered
     * 
     * @param string $email email to check for in database
     * 
     * @return boolean whether email is in database
     */
    public function emailIsRegistered(string $email) {
        $sql_query = $this->conn->prepare("SELECT * FROM ".$this->users_table." WHERE user_email=?");
        $sql_query->execute([$email]);
        
        $result = $sql_query->get_result();
        $sql_query->close();

        return ($result->num_rows > 0);
    }
    
    /**
     * Checks the provided login credentials against the database
     * 
     * @param string $email email of user
     * 
     * @param string $password password for user
     * 
     * @return boolean whether the login attempt was successful
     */
    public function attemptLogin(string $email, string $password) {
        $sql_query = $this->conn->prepare("SELECT * FROM ".$this->users_table." WHERE user_email=?");
        $sql_query->execute([$email]);
        
        $result = $sql_query->get_result();
        $user = $result->fetch_assoc();
        $sql_query->close();
        
        // No user exists with this email
        if (! $result->num_rows > 0) { return false; }


        // Use the inbuilt `password_verify` function to check whether the plaintext
        // password matches the hashed version stored in the database.
        // PHP Docs: https://www.php.net/manual/en/function.password-verify.php
        if (!password_verify($password, $user['user_pass'])) {
            return false;
        }

        // Login was succesful, update session
        $_SESSION['user'] = $user['user_id'];
        return true;
    }

    /**
     * Get full name of user with `$id`
     * 
     * @param string $id of user
     * 
     * @return string full name from the database
     */
    public function getUserFullName(string $id) {
        $sql_query = $this->conn->prepare("SELECT user_full_name FROM ".$this->users_table." WHERE user_id=?");
        $sql_query->execute([$id]);
        
        $result = $sql_query->get_result();
        $sql_query->close();
        
        $user = $result->fetch_assoc();
        return $user['user_full_name'];
    }

    /**
     * Registers a user, then logs them into a session
     * 
     * @param string $email of user
     * 
     * @param string $name of user
     * 
     * @param string $password for user
     * 
     * @return boolean id of newly registered user, or `false` if the user was not registered
     */
    public function registerUser(string $email, string $name, string $password) {
        // The inbuilt `password_hash` function will take a plaintext string and hash it
        // using the specified hashing method. `PASSWORD_DEFAULT` uses the blowfish (bcrypt)
        // hashing algorithm and generates a random salt.
        // See PHP Docs: https://www.php.net/manual/en/faq.passwords.php
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql_query = $this->conn->prepare("INSERT INTO ".$this->users_table.
                     " (`user_id`, `user_full_name`, `user_address`, `user_email`, `user_pass`, `user_timestamp`)
                     VALUES (NULL, ?, '', ?, ?, current_timestamp())");
        $query_success = $sql_query->execute([$name, $email, $hashedPassword]);
        
        
        if (!$query_success) {
            $sql_query->close();
            return false;
        }
        
        $_SESSION['user'] = $sql_query->insert_id;

        $sql_query->close();
        return true;
    }
}
