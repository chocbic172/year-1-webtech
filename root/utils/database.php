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
    private $reviews_table  = "tbl_orders";
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
}
