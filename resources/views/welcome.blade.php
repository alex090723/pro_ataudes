<!DOCTYPE html>
<html>
<head>
<title>Ataudes Josue</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: 'Roboto', sans-serif;;}
body, html {
  height: 100%;
  color: #777;
  line-height: 1.8;
}

/* Create a Parallax Effect */
.bgimg-1, .bgimg-2, .bgimg-3 {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/* First image (Logo. Full height) */
.bgimg-1 {
  background-image: url('/A_Josue.jpg'); /* Asegúrate de que la ruta de la imagen sea correcta */
  min-height: 100vh; /* Usa 100vh para cubrir toda la altura de la ventana */
  display: flex;
  align-items: center; /* Centra el contenido verticalmente */
  justify-content: center; /* Centra el contenido horizontalmente */
}

/* General Styling for Navigation Links */
.nav-link {
    display: inline-block;
    padding: 10px 15px;
    text-decoration: none;
    color: #fff; /* White text color */
    font-size: 16px; /* Adjust text size */
    font-weight: bold; /* Make text bold */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-link i {
    margin-right: 8px; /* Space between icon and text */
}

/* Hover Effect */
.nav-link:hover {
    background-color: #f00; /* Red background on hover */
    color: #fff; /* White text color on hover */
}

/* Specific Styling for Search Icon */
.search-icon {
    background-color: #333; /* Dark background for the search icon */
    border: none; /* Remove border */
}

.search-icon:hover {
    background-color: #555; /* Lighter background on hover */
}



</style>
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
    <a href="{{ route('login') }}" class="nav-link"><i class="fa fa-sign-in"></i> Iniciar Sesión</a>
<a href="{{ route('register') }}" class="nav-link"><i class="fa fa-user-plus"></i> Registrar Nuevo Usuario</a>


  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="#about" class="w3-bar-item w3-button" onclick="toggleFunction()">ABOUT</a>
    <a href="#portfolio" class="w3-bar-item w3-button" onclick="toggleFunction()">PORTFOLIO</a>
    <a href="#contact" class="w3-bar-item w3-button" onclick="toggleFunction()">CONTACT</a>
    <a href="#" class="w3-bar-item w3-button">SEARCH</a>
  </div>
</div>

<!-- First Parallax Image with Logo Text -->
<div class="bgimg-1 w3-display-container " id="home">
  <div class="w3-display-middle" style="white-space:nowrap;">
  
  </div>
</div>


 


<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">

<div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0
  </div>
  <strong>Copyright &copy; 2024 <a href="">Ataudes Josue 1:9</a>.</strong> All rights reserved.
</footer>
 
<script>
// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}

// Change style of navbar on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
    var navbar = document.getElementById("myNavbar");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";
    } else {
        navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white", "");
    }
}

// Used to toggle the menu on small screens when clicking on the menu button
function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

</body>
</html>
