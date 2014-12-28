<?php
    /**
     * Class dealing with users
     *
     * @package RecipeWebiste
     * @subpackage User
     * @since 1.0.0
     */
    class User
    {
        function __construct() { 
            require_once 'class.database.php'; 

            require_once 'class.utilities.php';
            $this->Utilities = new Utilities();

            require_once 'class.encryption.php';
            $this->Encryption = new Encryption();
        }

        function __destruct() { }
        function __clone() { }

        /**
         * Creates a user in the database
         * @param string $username Username of the user
         * @param string $email Email address of the user
         * @param string $name Name of the user
         * @param string $password Password of the user
         * @param string $password2 Re-entered password of the user
         * @param int $is_admin 1 for admin, 0 for user
         * @return array Array with status and messages
         * @access public
         * @since 1.0.0
         */
        public function CreateUser($username, $email, $name, $password, $password2, $is_admin) {
            $messages = array();
            $result = true;

            if ($username == '') {
                array_push($messages, 'Username is required');
                $result = false;
            }

            if ($email == '') {
                array_push($messages, 'Email is required');
                $result =  false;
            }

            if ($name == '') {
                array_push($messages, 'Name is required');
                $result =  false;
            }

            if ($password == '' || $password2 == '') {
                array_push($messages, 'Password is required');
                $result =  false;
            } elseif ($password != $password2) {
                array_push($messages, 'Passwords do not match');
                $result = false;
            } elseif (strlen($password) < 8) {
                array_push($messages, 'Password must be at lesat 8 characters');
                $result = false;
            }

            if ($result) {
                $username = Database::EscapeInput($username);
                $email = Database::EscapeInput($email);
                $name = Database::EscapeInput($name);
                $password = $this->Encryption->EncryptString($password);

                if ($is_admin == "true") {
                    $is_admin = 1;
                } else {
                    $is_admin = 0;
                }

                $query = "INSERT INTO User (Username, Email, Name, Password, IsAdmin) VALUES ('$username', '$email', '$name', '$password', $is_admin)";

                if (Database::ExecuteNonQuery($query)) {
                    return array('result' => 'SUCCESS', 'messages' => array());
                } else {
                    return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                }
            } else {
                return array('result' => 'ERROR', 'messages' => $messages);
            }
        }
        
        /**
         * Gets all the active users
         * @return array Array with users, or FALSE if error
         * @access public
         * @since 1.0.0
         */
        public function GetUsers() {
            $query = "SELECT UserId, Username, Name, Email FROM User WHERE IsActive = 1 ORDER BY Name";
            $result = Database::Query($query);

            if ($result && $result->num_rows > 0) {
                $users = array();
                while ($row = $result->fetch_assoc()) {
                    $user['user_id'] = $row['UserId'];
                    $user['username'] = $row['Username'];
                    $user['name'] = $row['Name'];
                    $user['email'] = $row['Email'];

                    array_push($users, $user);
                }

                return $users;
            } else {
                return false;
            }
        }

        /**
         * Creates a user in the database
         * @param int $user_id User ID to delete
         * @return bool
         * @access public
         * @since 1.0.0
         */
        public function DeleteUser($user_id) {
            $user_id = Database::EscapeInput($user_id);

            $query = "UPDATE User SET IsActive = 0 WHERE UserId = $user_id";
            return Database::ExecuteNonQuery($query);
        }

        /**
         * Checks to see if username is already in use
         * @param string $username Username to check
         * @return bool
         * @access public
         * @since 1.0.0
         */
        public function IsUsernameAvailable($username) {
            $username = Database::EscapeInput($username);

            $query = "SELECT UserId FROM User WHERE Username = '$username'";
            $result = Database::Query($query);

            if (!$result || $result->num_rows > 0) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * Checks to see if email is already in use
         * @param string $email Email to check
         * @return bool
         * @access public
         * @since 1.0.0
         */
        public function IsEmailAvailable($email) {
            $email = Database::EscapeInput($email);

            $query = "SELECT UserId FROM User WHERE Email = '$email'";
            $result = Database::Query($query);

            if (!$result || $result->num_rows > 0) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * Utilities Class Object
         * @access protected
         * @var Utilities
         * @since 1.0.0
         */
        protected $Utilities;

        /**
         * Encryption Class Object
         * @access protected
         * @var Encryption
         * @since 1.0.0
         */
        protected $Encryption;
    }
?>