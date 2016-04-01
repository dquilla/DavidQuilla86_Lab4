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
      <h1> Welcome to your profile <?php echo $_SESSION['fName']; ?> <?php echo $_SESSION['lName']; ?></h1>
      <h2 style="color:#166f96"> Post a comment </h2>
        <form id="commentField">
          <textarea id="commentText" ROWS=5 required></textarea> <br>
          <input type="submit" id = "postCommentButton" value="Post Comment">
        </form>


    <br>

    <fieldset id="postsSection">
      <legend> See your own comments </legend>
    </fieldset>

    </section>

  </body>

  <script type="text/javascript">
    $('.handle').on('click', function(){
      $('nav ul').toggleClass('show');
    });
      $(document).ready(function() {

        var jsonObject = {
          "userName" : $("#userName").val(),
          "action" : "GET_COMMENTS"
        };

        $.ajax({
            type: "POST",
            url: "../Data/applicationLayer.php",
            dataType: "json",
            data: jsonObject,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            success: function(jsonData) {
              delete jsonData.message;
              $.each(jsonData, function(x, y) {
                  postPost(y['userName'], y['publishDate'], y['commentText']);
              });
            },
            error: function(errorMsg){
              //alert(errorMsg.status);
              if (errorMsg.status == 200) {
                  window.location.replace("login.html");
              } else {
                alert("There are no comments");
              }
            }
        });
      });

      $("#commentField").on("submit", function(x){
        x.preventDefault();
        var jsonObject = {
          "commentText" : $("#commentText").val(),
          "action" : "POST_COMMENT"
        };
        $.ajax({
          type: "POST",
          url: "../Data/applicationLayer.php",
          dataType: "json",
          data: jsonObject,
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          success: function(jsonData) {
          postPost(jsonData['userName'], jsonData['publishDate'], jsonData['commentText']);
        },
        error: function(errorMsg){
          alert("Error posting comments");
        }
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
    function postPost(userName, publishDate, commentText) {
      var postsRiver = document.getElementById("postsSection");
      var encierra = document.createElement("FIELDSET");

      var userElement = document.createElement("H2");
      userElement.setAttribute("class", "userName");
      userElement.innerHTML = userName;
      userElement.style.cssText = "color:#2daae1";

      var dateElement = document.createElement("H5");
      dateElement.setAttribute("class", "publishDate");
      dateElement.innerHTML = publishDate;

      var commentElement = document.createElement("H4");
      commentElement.setAttribute("class", "commentText");
      commentElement.innerHTML = commentText;

      encierra.insertBefore(commentElement, encierra.firstChild);
      encierra.insertBefore(dateElement, encierra.firstChild);
      encierra.insertBefore(userElement, encierra.firstChild);

      postsRiver.insertBefore(encierra, postsRiver.firstChild);
      postsRiver.insertBefore(document.createElement("BR"), postsRiver.firstChild);

      $('#commentField')[0].reset();
    }
  </script>

</html>
