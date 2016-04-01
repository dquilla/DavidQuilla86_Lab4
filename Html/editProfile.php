<?php
  session_start();
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Profile</title>

    <link rel="shortcut icon" type="image/png" href="../images/favicon.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <script src="../js/pageScript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.handle').on('click', function(){
          $('nav ul').toggleClass('show');
        });
      });
    </script>

  </head>

  <body>

    <nav>
      <div class="header">
        <a class="logo">Laboratory 5</a>
        <button class="handle">
          <i class="fa fa-bars"></i>
        </button>
      </div>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="profile.php">Profile of <?php echo $_SESSION['userName']; ?></a></li>
        <li><a href="editProfile.php">Edit Profile</a></li>
        <li><a id="logoutSess" href="#">Logout</a></li>
      </ul>

    </nav>

    <section id="content">
      <h1> Edit your profile </h1>
      <form>

        <fieldset>
          <legend>Edit data from <?php echo $_SESSION['userName']; ?>'s profile</legend>
          <label for="firstName">First Name</label><br>
          <input type="text" id="firstName" value = "<?php echo $_SESSION['fName']; ?>" required><br>
          <label for="lastName">Last Name</label><br>
          <input type="text" id="lastName" value = "<?php echo $_SESSION['lName']; ?>" required><br>

          <label for="mail">Email</label> <br>
          <input type="email" id="mail" value = "<?php echo $_SESSION['userMail']; ?>" required><br>

          <label for="password1">New or Old Password</label><br>
          <input type="password" id="password1" required><br>
          <label for="password2">Repeat New or Old Password</label><br>
          <input type="password" id="password2" required><br>


          <input type="submit" id = "saveChangesButton" value="Save changes">
          <input type="button" id="cancelButton" value="Cancel">
        </fieldset>

      </form>



    </section>

  </body>
  <script type="text/javascript">
    $( document ).on('ready', function() {

      var jsonObject = {
          "action" : "CHECK_SESSION"
      };

      $.ajax({
          type: "POST",
          url: "../Data/applicationLayer.php",
          dataType: "json",
          data: jsonObject,
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          success: function(jsonData) {

          },
          error: function(errorMsg){
              //alert(errorMsg.status);
              window.location.replace("login.html");
          }
      });




      $("#saveChangesButton").on("click", function(){
        var password1 = $('#password1').val();
        var password2 = $('#password2').val();
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if( $('#firstName').val() == "" || $('#lastName').val() == "" || $('#mail').val() == "" || $('#password1').val() == "" || $('#password2').val() == "") {
          alert("Fill all the fields");
          return false;
        } else {
          if(!re.test($('#mail').val())) {
            alert("Email invalido");
          } else {
            if ( password1 ==  password2) {
              var jsonObject = {
                "userMail" : $("#mail").val(),
                "userPassword" : $("#password2").val(),
                "userFirstName" : $("#firstName").val(),
                "userLastName" : $("#lastName").val(),
                "action" : "EDIT_PROFILE"
              };

              $.ajax({
                type: "POST",
                url: "../Data/applicationLayer.php",
                dataType: "json",
                data: jsonObject,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},

                success: function(jsonData) {
                  window.location.replace("profile.php");
                },
                error: function(errorMsg){

                  alert(errorMsg.statusText);
                }
              });
              alert("Changes registered");
              return true;
            } else {
              alert("Passwords don't match");
              return false;
            }
          }
        }
      });

      $("#cancelButton").on("click", function(){
        window.location.replace("profile.php");
      });

    });
    $("#logoutSess").on("click",function(){
        var jsonObject = { "action" : "LOGOUT" };
        $.ajax({
            type: "POST",
            url: "../Data/applicationLayer.php",
            dataType: "json",
            data: jsonObject,
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            success: function (jsonData) {
                window.location.replace("login.html");
            },
            error: function (errorMsg) {
                alert(errorMsg.message);

            }
        });
    });
  </script>



</html>
