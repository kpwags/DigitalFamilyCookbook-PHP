<?php
    /**
     * Class dealing with encryption
     *
     * @package RecipeWebiste
     * @subpackage Encryption
     * @since 1.0.0
     */
    class Encryption
    {
        function __construct() { 
            require_once 'class.utilities.php';
            $this->Utilities = new Utilities();
        }

        function __destruct() { }
        function __clone() { }

        /**
         * Encrypts a string
         * @param string $string The text to convert
         * @return string
         * @access public
         * @since 1.0.0
         */
        public function EncryptString($string = '') {
            if ($string == '') {
                $string = $this->Utilities->CreateRandomString(12);
            }

            $salt = substr(str_shuffle("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345‌​6789"), 0, 8); 

            $hashed = crypt($string, '$6$'.$salt);

            return $hashed;
        }

        /**
         * Compares a string to an encrypted string
         * @param string $string The text to convert
         * @return string
         * @access public
         * @since 1.0.0
         */
        public function Compare($input, $hashed) {
            if (crypt($input, $hashed) == $hashed) {
                return true;
            } else {
                return false;
            }
        }        

        /**
         * Utilities Class Object
         * @access protected
         * @var ovUtilities
         * @since 1.0.0
         */
        protected $Utilities;
    }
?>