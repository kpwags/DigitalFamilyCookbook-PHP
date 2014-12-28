<?php
    /**
     * Class dealing with the connection to the MySQL DB
     *
     * @package RecipeWebiste
     * @subpackage Utilities
     * @since 1.0.0
     */
    class Utilities
    {
        function __construct() { }
        function __destruct() { }
        function __clone() { }

        /**
         * Converts text into URL-Safe Text
         * @param string $str The text to convert
         * @param string $replacement_character The character used to replace (defaults to the dash '-')
         * @return string
         * @access public
         * @since 1.0.0
         */
        public function ConvertToUrl($str, $replacement_character = '-') {
            $str = strtolower(trim($str));
            $str = preg_replace('/[^a-z0-9-]/', $replacement_character, $str);
            $str = preg_replace('/-+/', $replacement_character, $str);
            return $str;
        }

        /**
         * Creates a random string of characters
         * @param int $length The length of the string to be returned
         * @param string $charset Characters available
         * @return string
         * @access public
         * @since 1.0.0
         */
        function CreateRandomString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@$%_=-#') {
            $str = '';
            $count = strlen($charset);
            while ($length--) {
                $str .= $charset[mt_rand(0, $count-1)];
            }
            return $str;
        }

        /**
         * Returns the base domain of a given URL
         * @param string $input The full URL
         * @return string
         * @access public
         * @since 1.0.0
         */
        public function GetDomain($input)
        {
            $input = trim($input, '/');
            if (!preg_match('#^http(s)?://#', $input)) {
                $input = 'http://' . $input;
            }

            $urlParts = parse_url($input);

            // remove www
            $domain = preg_replace('/^www\./', '', $urlParts['host']);

            return $domain;
        }

        /**
         * Calculate the pagination limits
         * @param int $page Current Page
         * @param int $count Total number of objects
         * @param int $pagination_override (OPTIONAL) Override the number of items per page
         * @return array Array containing offset, limit, and last page
         * @access public
         * @since 1.0.0
         */
        public function CalculateLimits($page, $count, $pagination_override = false)
        {            
            if ($pagination_override) {
                $pagination = $pagination_override;
            } else {
                $pagination = 25;
            }
            
            $last_page = ceil($count / $pagination) ;
            if ($last_page < 1) {
                $last_page = 1;
            }

            /* Checks to make sure $page is within range */
            $page = (int)$page ;
            if($page < 1) {
                $page = 1 ;
            } elseif ($page > $last_page) {
                $page = $last_page ;
            }

            $limit = ($page - 1) * $pagination;
            
            return array('offset' => $limit, 'limit' => $pagination, 'lastpage' =>$last_page);
        }
    }
?>