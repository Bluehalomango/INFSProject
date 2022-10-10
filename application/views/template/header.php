<html>
        <head>
                <title>Generic Online Games Store</title>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
        </head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
<h1 class="navtitle" href="#">Generic Online Games Store</h1>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a href="<?php echo base_url(); ?>store"> Featured Games </a>
            <a href="<?php echo base_url(); ?>store/search"> Search </a>
            <?php if($this->session->userdata('logged_in')) : ?>
            <li class="nav-item">
            <a href="<?php echo base_url(); ?>upload"> Add Game </a>
            <a href="<?php echo base_url(); ?>account"> Account </a>
           </li>
           <?php endif; ?>
        </li>
    </ul>
    <ul class="navbar-nav my-lg-0">
    <?php if(!$this->session->userdata('logged_in')) : ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>login"> Login </a>
          </li>
          <?php endif; ?>
          <?php if($this->session->userdata('logged_in')) : ?>
            <li class="nav-item">
            <a href="<?php echo base_url(); ?>login/logout"> Logout </a>
           </li>
           <?php endif; ?>
    </ul>
</div>

</nav>


<script>
page_startup();
var timer;

function load_game(id){
    var base_url = window.location.origin;
    window.location.assign(base_url + "/INFSProject/store/game/" + id);
}

function page_startup() {
    if( <?php echo session_status() ?> == 2) {
        if (<?php echo isset($_SESSION['logged_in']); ?> == 1 ) {
            if (<?php echo ($_SESSION['logged_in']) ? (1) : (0); ?>) {
                start_timer();
                document.addEventListener("click", start_timer);
            }
        }
    }
}

function start_timer() {
	stop_timer();
    var time = 150 * 1000; //15 seconds
	timer = setTimeout(function() {
        alert("You have been logged out due to inactivity")
        window.location.href = "<?php echo base_url(); ?>login/logout";
		stop_timer();
	}, time);
}

function stop_timer() {
    clearTimeout(timer);
}

function logout() {
    stop_timer();
}

</script>
<style>

* {
	margin: 0;
	padding: 0;
}

.name {
    font-size: 50px;
    text-align: left;
}

.descript {
    margin-top: 20px;
    margin-left: 20px;
    text-align: right;
    font-size: 1.2vw;
}

.poster {
    width: 25vw;
}

.wrapper > * {
    margin-top: 10px;
}

.flex-item {
    width: 75%;
    padding: 10px;
    line-height: 150px;
}

.wrapper {
    display: flex;  
    flex-flow: row nowrap;
    padding: 0;
    margin: 0;
}

.nav-item > a {
    padding: 2vw;
    font-size: 1vw;
    color: #F2B138;
}

.navtitle {    
    font-size: 1.2vw;
    color: #F27405;
}

.wrap {
    width: 90vw;
    margin: 5%;
}

#collapse.btn.collapsed:after 
{ 
    content:'Show Result' ; 
}

#collapse.btn:after
{
    content:'Hide Result' ;
}
body {
  /*background: lightblue url("uploads/NoStrokesUnified.png") no-repeat fixed center;*/
  background: #03A6A6;
}

nav {
    background-color: #003F63 !important;
}

button {
   background-color: #003F63 !important; 
   border: none !important;
   color: white;
   padding: 10px;
   margin: 10px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 16px;
}

</style>