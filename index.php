<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Shoptag - The easiest way to fill out forms on mobile devices</title>

  <!-- CSS  -->
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
   <link href="css/changes.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
</head>

<!-- Check for requests from embedded contags -->
  <?php if (isset($_GET["id"])) { include("./php/embed.php"); die(); }?>

<body class="home">

  <!-- LOGGED IN ################################################-->
  <?php session_start();
	if (isset($_SESSION["id"])) {?>

 <!-- Main bar -->
  <nav id="main_nav" class="cyan lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" onclick="load('index');" class="brand-logo">SHOPTAG</a>
        <ul class="right">
          <li><a onclick="load('home');">Contags</a></li>
          <li><a onclick="load('select');">Setup</a></li>
          <li><a onclick="load('retrieve');">Check Code</a></li>
          <li><a>Hello, <?php echo $_SESSION["id"];?> !</a></li> 
        </ul>
        <ul id="nav-mobile" class="side-nav">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>

 
    <div class="container">
      <div class="nav-wrapper right_user">
        <!-- User Dropdown -->       
          <div id="dd" class="wrapper-dropdown-5" tabindex="1">

          <img class="circle"   id="userpic" src="images/user.png"><h6 id="username">Wessolly Mobile Marketing</h6>
            <ul class="dropdown">
              <li><a href="#"><i class="icon-user"></i>Profile</a></li>
              <li><a href="#"><i class="icon-cog"></i>Settings</a></li>
              <li><a href="#"><i class="icon-remove"></i>Log out</a></li>
            </ul>
          </div>
  <!-- User Dropdown -->  
        
      </div>
    </div>


  <!-- LOGGED OUT ################################################-->
  <?php } else {?>

 <!-- Main bar -->
  <nav id="main_nav" class="cyan lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" onclick="load('index');" class="brand-logo">SHOPTAG</a>
        <ul class="right">
          <li><a class="modal-trigger" href="#modal_register">Register</a></li>
          <li><a class="modal-trigger" href="#modal_register">Login</a></li>
          <li><a onclick="load('about');">About</a></li>
          <li><a onclick="load('news');">News</a></li>
          <li><a onclick="load('retrieve');">Check Code</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>

  <?php } ?> 
 <!-- ############################################################# -->











 <!-- Page content -->
 <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div class="row">
        <div class="col s12 m12">

		<div id="main_content">

			<!-- PAGES ARE LOADED INSIDE HERE -->
		</div>
		<?php include("./pages/modals.html"); ?>
	</div>
      </div>
    </div>
  </div>

  <footer class="page-footer orange">

    <div class="footer-copyright center-align">
      <div class="container">
	
	<!-- DEBUG BUTTON -->
	<?php if (isset($_SESSION["id"])) {?>
	<a onclick="logout();" style="color: yellow;">DEBUG: Logout</a> <?php } else {?>
      	<a onclick="login();" style="color: yellow;">DEBUG: Login</a> <?php }?>

	<!-- Copyright -->
	&nbsp; | &nbsp; 
	Contag &copy; 2015 by <a class="white-text text-lighten-3 right-align" href="http://www.wessolly-mobile.de">WMM</a>   
	&nbsp; | &nbsp; 
	<a href="imprint.html">Imprint</a>

      </div>
    </div>
  </footer>

<!-- JS -->
<script src="js/jquery.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
<script src="js/zeroClipboard.js"></script>
<script src="js/main.js"></script>

</body>
</html>

