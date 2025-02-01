<?php 

require_once ('./controller.php');

if (!isset($_SESSION['id']))
{

    header("Location: login.php");

}

echo "You're logged in!"; 

?>

<p>You can log out now</p>
<form action="" method="post">
    <button type="submit" name="logout">Logout</button>
</form>