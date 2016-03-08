<?php
	header('Content-type: application/json');
	require_once __DIR__ . '/dataLayer.php';

	$action = $_POST['action'];

	switch($action)
	{
		case 'LOGIN' :
			loginAction();
			break;
		case 'REGISTER' :
			registerAction();
			break;
		case 'EDIT_PROFILE' :
			editProfileAction();
			break;
		case 'POST_COMMENT' :
			postCommentAction();
			break;
		case 'GET_COMMENTS' :
			getCommentsAction();
			break;
		case 'GET_ALL_COMMENTS' :
			getAllCommentsAction();
			break;
		default :
			echo "Error in action";
	}

	function loginAction()
	{
		$user = $_POST['userName'];
		$pass = $_POST['userPassword'];

		$result = login($user);

		if ($result['message'] == 'OK')
		{

		    	$response = array('fName' => $result['fName'], 'lName' => $result['lName']);
			    echo json_encode($response);
		}
		else
		{

			die(json_encode($result));
		}
	}

	function registerAction()
	{
		$userMail = $_POST['userMail'];
		$userName = $_POST['userName'];
		$userPassword = $_POST['userPassword'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];

		$result = register($userName, $userPassword, $userMail, $userFirstName, $userLastName);


		if ($result['message'] == 'OK')
		{
					echo json_encode($result);
		}
		else
		{
			die(json_encode($result));
		}
	}

	function editProfileAction()
	{
		$userMail = $_POST['userMail'];
		$userPassword = $_POST['userPassword'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];

		$result = editProfile($userPassword, $userMail, $userFirstName, $userLastName);


		if ($result['message'] == 'OK')
		{
			echo json_encode($result);
		}
		else
		{
			die(json_encode($result));
		}

	}

	function postCommentAction () {

		session_start();

		$commentText = $_POST['commentText'];
		$userName = $_SESSION['userName'];
		$publishDate = date("Y-m-d h:i:sa");

		$result = postComment($userName, $publishDate, $commentText);

		if ($result['message'] == 'OK')
		{
			echo json_encode($result);
		}
		else
		{
			die(json_encode($result));
		}

	}

	function getCommentsAction () {

		$result = getComments();

    if ($result["message"] == "OK") {
        echo json_encode($result);
    } else {
        die(json_encode($result));
    }

	}

	function getAllCommentsAction () {

		$result = getAllComments();

		if ($result["message"] == "OK") {
				echo json_encode($result);
		} else {
				die(json_encode($result));
		}
	}
?>
