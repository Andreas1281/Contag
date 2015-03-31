<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Shoptag - The easiest way to fill out forms on mobile devices</title>

  <!-- CSS  -->
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body class="home">
  <!-- User-Bar -->
  <nav id="user" class="cyan darken-2" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="#" class="brand-logo"></a>
        <ul class="right">

          <li><a class="modal-trigger" href="#modal_register">Register</a></li>
          <li><a class="modal-trigger" href="#modal_register">Login</a></li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Main-Bar -->
  <nav id="main_nav" class="cyan lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="?p=index" class="brand-logo">SHOPTAG</a>
        <ul class="right">
          <li><a href="?p=index">Contags</a></li>
          <li><a href="?p=home">Home</a></li>
          <li><a href="?p=select">Select</a></li>
	  <li><a href="?p=retrieve">Check Code</a></li>
        </ul>
        <ul id="nav-mobile" class="side-nav">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>

 <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div class="row">
        <div class="col s12 m12">

		<?php // -- LOAD PAGE CONTENT --

		function sanitize($string) {
			return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
		}

		// Load modals
		include("./pages/modals.html");

		if ( isset($_GET["id"])) {
		echo sanitize($_GET["id"]);
			echo "<div class='card-panel'>";
                        include("./pages/retrieve.html");
			echo "<script>$(document).ready(function() {
				      request(".sanitize($_GET["id"])."); } </script>
                              </div>";
		}

		// Sanitize $GET input
		$page = "./pages/".sanitize($_GET["p"]).".html";

		// Don't show card-panel for index page
		if ( $_GET["p"] == "index" ) { include($page); }
		else if ( file_exists($page) ) {

			// Load page into card-panel
			echo "<div class='card-panel'>";
			include($page);
			echo "</div>";
		}
		// Page not found, go to index.html
		else { include("./pages/index.html"); } ?> 
	</div>
      </div>
    </div>
  </div>

  <footer class="page-footer orange">

    <div class="footer-copyright right-align">
      <div class="container">
      &copy; 2014 by <a class="white-text text-lighten-3 right-align" href="http://www.wessolly-mobile.de">WMM</a>   &nbsp;

      |  &nbsp; <a href="imprint.html">Imprint</a>
      </div>
    </div>
  </footer>

<!-- JS -->
<script src="js/jquery.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="js/main.js"></script>

</body>
</html>

