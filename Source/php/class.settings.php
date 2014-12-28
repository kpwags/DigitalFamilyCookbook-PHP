<?php
    /**
     * Class dealing with settings
     *
     * @package RecipeWebiste
     * @subpackage Settings
     * @since 1.0.0
     */
    class Settings
    {
        function __construct() {
            require_once 'class.database.php';
            $this->LoadParameters();
        }
        function __destruct() { }
        function __clone() { }

        private function LoadParameters() {
            $query = "SELECT RootURL, SiteTitle FROM Settings LIMIT 0, 1";
            $result = Database::Query($query);

            if ($result) {
                $row = $result->fetch_assoc();

                $this->root_url = $row['RootURL'];
                $this->site_title = $row['SiteTitle'];

                if (substr($this->root_url, -1) != '/') {
                    $this->root_url = $this->root_url . "/";
                }
            } else {
                header('Location: /error');
                exit();
            }
        }

        public function GetRootURL() {
            return $this->root_url;
        }

        public function GetSiteTitle() {
            return $this->site_title;
        }

        private $root_url;
        private $site_title;
    }
?>