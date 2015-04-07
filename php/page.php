<?php // -- LOAD PAGE CONTENT --

                function sanitize($string) {
                        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
                }

                // Sanitize $GET input & search for all extensions
                $page = glob("../pages/".sanitize($_GET["p"])."*")[0];

                // Don't show card-panel for index page
                if ( $_GET["p"] == "index" ) { include($page); }
                else if ( file_exists($page) ) {

                        // Load page into card-panel
                        echo "<div class='card-panel'>";
                        include($page);
                        echo "</div>";
                }
                // Page not found, go to index.html
                else { include("../pages/index.html"); } 
?>
