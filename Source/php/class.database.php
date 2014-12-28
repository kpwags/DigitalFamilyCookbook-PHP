<?php
    /**
     * Class dealing with the connection to the MySQL DB
     *
     * @package RecipeWebiste
     * @subpackage Database
     * @since 1.0.0
     */
    class Database
    {
        function __construct() { }
        function __destruct() { }
        function __clone() { }

        /**
         * Accessor to mysqli object
         * @access public
         * @return mysqli MySQLi Object
         * @since 1.0.0
         */
        public static function DB()
        {
            require_once ('config.php');
            if (self::$instance == null || !(self::$instance instanceOf mysqli)) {  
                self::$instance = new mysqli(MYSQLHOST, MYSQLUSERNAME, MYSQLPASSWORD, MYSQLDATABASE, MYSQLPORT);
                
                if(self::$instance->connect_error){  
                    //throw new Exception('Error MySQL: ' . self::$instance->connect_error);  
                    header("Location: /db-failure");
                    exit();
                }  
            } 
            
            return self::$instance;
        }

        /**
         * Executes a DB Command that does not return any rows (i.e. INSERT, UPDATE)
         * @access public
         * @param string $query SQL Query to execute
         * @return bool true if successful, false if not
         * @since 1.0.0
         */
        public static function ExecuteNonQuery($query)
        {
            if (!$result = (self::DB()->query($query)))
            {
                // error with query
                printf("Error Message: %s\nQuery: %s", self::DB()->error, $query);
                return false;
            }
            else
            {
                return true;
            }
            
        }
        
        /**
         * Executes a DB Command and returns the rows
         * @access public
         * @param string $query SQL Query to execute
         * @return mysqli_result|false MySQL Improved Result Object with reuslt or false if error
         * @since 1.0.0
         */
        public static function Query($query)
        {
            if (!$result = (self::DB()->query($query))) {               
                // error with query
                printf("Error Message: %s\nQuery: %s",self::DB()->error, $query);
                return false;
            }
            
            return $result;
        }
        
        /**
         * Frees the results from the SQL Result Set since Stored Procedures are used.
         * @access public
         * @since 1.0.0
         */
        public static function FreeResult()
        {
            while( self::DB()->more_results() ) 
            { 
                if(self::DB()->next_result()) 
                { 
                    $result = self::DB()->use_result(); 
                    unset($result); 
                } 
            } 
        }

        /**
         * Cleans the input of a string for a SQL query
         * @access public
         * @param string $value value to clean
         * @return string Escaped/Cleaned string
         * @since 1.0.0
         */
        public static function EscapeInput($value)
        {
            return self::DB()->real_escape_string($value);
        }

        /**
         * runs an insert query, returning the ID of the row inserted
         * @access public
         * @param string $query SQL Query to execute
         * @return int|false The ID inserted, or false if error
         * @since 1.0.0
         */
        public static function Insert($query)
        {
            if (!$result = (self::DB()->query($query)))
            {
                // error with query
                printf("Error Message: %s\nQuery: %s", self::DB()->error, $query);
                return false;
            }
            else
            {
                return self::DB()->insert_id;
            }
        }
        
        /**
         * MySQLi Object
         * @access private
         * @var mysqli
         * @since 1.0.0
         */
        private static $instance;

    }
?>