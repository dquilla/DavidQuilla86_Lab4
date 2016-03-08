function passwordMatch() {
  var password1 = $('#password1').val();
  var password2 = $('#password2').val();
	if ( password1 ==  password2) {
    alert("Registered");
		return true;
	} else {
		alert("Passwords don't match");
		return false;
	}
}


function postComment() {
  var comm = $('#commentText').val();
  var postsRiver = document.getElementById("postsRiver2");

  var name = document.createElement("P");
  name.innerHTML = "FirstName LastName";

  var imagen = document.createElement("IMG");
  imagen.src = "http://tr3.cbsistatic.com/fly/314-fly/bundles/techrepubliccore/images/icons/standard/icon-user-default.png";
  imagen.width = "60";
  imagen.height = "60";
  var comment = document.createElement("P");
  comment.innerHTML = comm;



  postsRiver.insertBefore(comment, postsRiver.firstChild);
  postsRiver.insertBefore(imagen, postsRiver.firstChild);
  postsRiver.insertBefore(name, postsRiver.firstChild);


  return false;
}
