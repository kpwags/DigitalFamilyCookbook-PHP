<?php
    /**
     * Class dealing with security
     *
     * @package RecipeWebiste
     * @subpackage Security
     * @since 1.0.0
     */
    class Security
    {
        function __construct() {
            require_once 'class.database.php'; 

            require_once 'class.utilities.php';
            $this->Utilities = new Utilities();

            require_once 'class.settings.php';
            $this->Settings = new Settings();

            require_once 'class.encryption.php';
            $this->Encryption = new Encryption();

            $this->LoadLoggedInUserInfo();
        }

        function __destruct() { }
        function __clone() { }

        /**
         * Checks to make sure the user is logged in
         * @access public
         * @since 1.0.0
         */
        public function IsUserLoggedIn() {
            if (isset($_COOKIE['userid'])) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Checks to see if the user is an admin
         * @access public
         * @since 1.0.0
         */
        public function IsUserAdmin() {
            return $this->IsAdmin;
        }

        /**
         * Returns the logged in user's ID
         * @access public
         * @return int User's ID
         * @since 1.0.0
         */
        public function GetUserID() {
            if ($this->IsUserLoggedIn()) {
                return $this->UserId;
            } else {
                return "No User Logged In";
            }
        }

        /**
         * Returns the logged in user's name
         * @access public
         * @return string User's name
         * @since 1.0.0
         */
        public function GetUserName() {
            if ($this->IsUserLoggedIn()) {
                return $this->Name;
            } else {
                return "No User Logged In";
            }
        }

        /**
         * Loads the current user info
         * @access protected
         * @since 1.0.0
         */
        protected function LoadLoggedInUserInfo() {
            if (isset($_COOKIE['userid'])) {
                $query = "SELECT Name, IsAdmin, IsActive FROM User WHERE UserId = " . Database::EscapeInput($_COOKIE['userid']);
                $result = Database::Query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['IsAdmin'] == 1) {
                        $this->IsAdmin = true;
                    } else {
                        $this->IsAdmin = false;
                    }
                    $this->UserId = $_COOKIE['userid'];
                    $this->Name = $row['Name'];

                    // confirm user is still active
                    if ($row['IsActive'] == 0) {
                        $this->LogoutUser();
                    }
                } else {
                    $this->IsAdmin = false;
                    $this->UserId = false;
                    $this->Name = false;
                }
            } else {
                $this->IsAdmin = false;
                $this->UserId = false;
                $this->Name = false;
            }
        }

        /**
         * Creates the cookie logging the user in
         * @param $username string The Username/Email of the user
         * @param $password string The inputted password
         * @access public
         * @since 1.0.0
         */
        public function LoginUser($username, $password)
        {           
            $username = Database::EscapeInput($username);
            $query = "SELECT UserId, Password FROM User WHERE (Username = '$username' OR Email = '$username') AND IsActive = 1";
            $result = Database::Query($query);
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $db_password = $row['Password'];

                if ($this->Encryption->Compare($password, $db_password)) {
                    $domain = "." . $this->Utilities->GetDomain($this->Settings->GetRootURL());
                    setcookie("userid", $row['UserId'], time() + 31536000, "/");

                    return true;
                } else {
                    return false;
                }                
            } else {
                return false;
            }
            
        }
        
        /**
         * Deletes the cookie logging the user out
         * @access public
         * @since 1.0.0
         */
        public function LogoutUser()
        {            
            $domain = "." . $this->Utilities->GetDomain($this->Settings->GetRootURL());
            
            setcookie("userid", "", time() - 3600, "/");  
        }

        /**
         * Checks to make sure the user is logged in; Reroutes them if not
         * @access public
         * @since 1.0.0
         */
        public function CheckSession() {
            if (!$this->IsUserLoggedIn()) {
                header("Location: " . $this->Settings->GetRootURL() . "login");
                exit();
            }
        }

        /**
         * Checks to make sure the user is logged in and an admin; Reroutes them if not
         * @access public
         * @since 1.0.0
         */
        public function CheckAdminSession() {
            if (!$this->IsUserAdmin()) {
                header("Location: " . $this->Settings->GetRootURL() . "login");
                exit();
            }
        }

        /**
         * User ID in Database
         * @access protected
         * @var int
         * @since 1.0.0
         */
        protected $UserId;

        /**
         * User Name
         * @access protected
         * @var string
         * @since 1.0.0
         */
        protected $Name;

        /**
         * Is User Admin
         * @access protected
         * @var bool
         * @since 1.0.0
         */
        protected $IsAdmin;

        /**
         * Settings Class Object
         * @access protected
         * @var Settings
         * @since 1.0.0
         */
        protected $Settings;

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