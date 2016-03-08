<?php

  function connect()
  {
    $servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "LoginDB";

		$connection = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($connection->connect_error)
		{
      return null;
		}
    else
    {
      return $connection;
		}
  }

  function errors($type)
	{
		$header = "HTTP/1.1 ";

		switch($type)
		{
			case 500:	$header .= "500 Bad connection to Database";
						break;
			case 206:	$header .= "206 Wrong Credentials";
						break;
			case 406:	$header .= "406 Bad user or password";
						break;
			case 417:	$header .= "417 No content set in the cookie/session";
						break;
      case 409:	$header .= "409 Conflict, Username already in use please select another one";
            break;
			default:	$header .= "404 Request Not Found";
		}

		header($header);
		return array('message' => 'ERROR', 'code' => $type);
	}
  function login($userName)
  {
    $userPassword = $_POST['userPassword'];

    $conn = connect();
    if ($conn != null)
    {
      $sql = "SELECT userMail, userName, fName, lName, passwrd FROM Users WHERE userName = '$userName' AND passwrd = '$userPassword'";
			$result = $conn->query($sql);

			if ($result->num_rows > 0)
			{
        $row = $result->fetch_assoc();
        $response = array(
          'message' => 'OK',
          'fName' => $row['fName'],
          'lName' => $row['lName'],
          'userMail' => $row['userMail'],
          'userName' => $row['userName'],
          'password' => $row['passwrd']);
        session_start();
        $_SESSION['userName'] = $response['userName'];
        $_SESSION['fName'] = $response['fName'];
        $_SESSION['lName'] = $response['lName'];
        $_SESSION['password'] = $response['password'];
        $_SESSION['userMail'] = $response['userMail'];

        $conn->close();
        return $response;
      }
			else
			{
				$conn->close();
				return errors(406);
			}
    }
    else
    {
      $conn->close();
      return errors(500);
    }
  }
    function register($userName, $userPassword, $userMail, $userFirstName, $userLastName)
    {
      // Create connection
    	$conn = connect();

      if ($conn != null)
      {
        $sql = "SELECT userMail, userName, fName, lName, passwrd FROM Users WHERE userName = '$userName' AND passwrd = '$userPassword'";
  			$result = $conn->query($sql);

  			if ($result->num_rows > 0)
  			{
          $conn->close();
          return errors(409);

        }
  			else
  			{
          $sql = "INSERT INTO Users (fName, lName, userMail, userName, passwrd) VALUES ('$userFirstName', '$userLastName', '$userMail', '$userName', '$userPassword')";

          if (mysqli_query($conn, $sql)) {

            // $response = array('message' => 'OK', 'fName' => $row['fName'], 'lName' => $row['lName'], 'userMail' => $row['userMail'], 'userName' => $row['userName'], 'password' => $row['passwrd']);
            $response = array("message" => "OK");
            $conn->close();
            return $response;
          } else {
            $conn->close();
            return errors(500);
          }

  			}
      }
      else
      {
        $conn->close();
        return errors(500);
      }


    }
    function editProfile($userPassword, $userMail, $userFirstName, $userLastName) {

      // Create connection
    	$conn = connect();

      if ($conn != null)
      {
        session_start();
        $userName = $_SESSION['userName'];
        $sql = "UPDATE users SET fName='$userFirstName', lName='$userLastName', userMail='$userMail', passwrd='$userPassword' WHERE userName='$userName'";
        if (mysqli_query($conn, $sql)) {
          $response = array("message" => "OK");
          $_SESSION['fName'] = $userFirstName;
          $_SESSION['lName'] = $userLastName;
          $_SESSION['userMail'] = $userMail;

            $conn->close();
            return $response;
        } else {
          $conn->close();
          return errors(500);
        }

      } else {
        $conn->close();
        return errors(500);
      }

    }
    function postComment($userName, $publishDate, $commentText) {
      $conn = connect();
      if ($conn != null) {
          $sql = "INSERT INTO posts (userName, publishDate, commentText) VALUES ('$userName', '$publishDate', '$commentText')";
          if (mysqli_query($conn, $sql)) {
              $response = array(
                  "message" => "OK",
                  "userName" => $userName,
                  "publishDate" => $publishDate,
                  "commentText" => $commentText
              );
              $conn->close();
              return $response;
          } else {
              $conn->close();
              return errors(500);
          }
      } else {
          $conn->close();
          return errors(500);
      }

    }
    function getComments() {
      $conn = connect();
      if ($conn != null)
      {
        session_start();
        $userName = $_SESSION['userName'];

        $sql = "SELECT * FROM posts WHERE userName='$userName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $response = array("message" => "OK");
            while ($row = $result->fetch_assoc()) {
               $response[] = $row;
            }
            $conn->close();
            return $response;
        } else {
          $conn->close();
          return errors(500);
        }

      } else {
        $conn->close();
        return errors(500);
      }

    }
    function getAllComments() {
      $conn = connect();
      if ($conn != null)
      {
        $sql = "SELECT * FROM posts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $response = array("message" => "OK");
            while ($row = $result->fetch_assoc()) {
               $response[] = $row;
            }
            $conn->close();
            return $response;
        } else {
          $conn->close();
          return errors(500);
        }

      } else {
        $conn->close();
        return errors(500);
      }

    }
?>
