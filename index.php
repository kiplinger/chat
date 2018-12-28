<html>
<head>
<link rel="stylesheet" href="style.css"> 
</head>

<?php

//This part of the code writes the comment to a text file

$name =  $comment =  ""; // Creates the variables and makes them blank

if ($_SERVER["REQUEST_METHOD"] == "POST") { // If the post button is pressed

function format($data) {
	$data = trim($data); // Trims the data 
	$data = stripslashes($data); // Un-quotes the data (Do not change this)
	$data = htmlspecialchars($data); // Protects against characters that would break the code
	return $data; // Gives back the data
  
}

$comment = format($_POST["comment"]); // Formats the comment
$name = format($_POST["name"]); // Formats the name
 
if($comment != "") { // If the user has typed something into the comment box
	if($name == "")     { // If there is no name
	$name = "Anonymous"; // Set the name to Anonymous
}
// These just turn ASCII emoticons in to unicode ones
$comment = str_replace("&gt;:(","&#128545;",$comment);
$comment = str_replace(":(","&#128577;",$comment);
$comment = str_replace(":)","&#128522;",$comment);
$comment = str_replace(";)","&#128521;",$comment);
$comment = str_replace(":v","&#128527;",$comment);
$comment = str_replace(":D","&#128516;",$comment);

$date = date("d.m.Y"); // Generate the current date
$file = file_get_contents("chat.txt"); // Defines the file in wich comments are stored
$datarray = unserialize($file); // Turns the files contents into an array

$full = array // Combines all the data into an array
($date, $name, $comment);
$datarray[] = $full; // Adds this array to a bigger array of all the comments
$newfile = serialize($datarray); // Turns the array into a string we can store

file_put_contents("chat.txt", $newfile); // Stores the string into the file

function Redirect($url, $permanent = false) // Refreshes the page so the comment appears(and removes the old data so you dont post the same comment again on refresh)
{
    if (headers_sent() == false)
    {
        header('Location: ' . $url, true, ($permanent == true) ? 301 : 302);
    }

    exit();
}

Redirect('index.php', false);
}
}
// The bottom html code is the comment submitting box

?>

<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input name="name" placeholder="Name" style="width: 14em; height: 2em;" id="name"></input><br>
<textarea name="comment" placeholder="Comment" style="width: 50em;  height: 8em;" id="comment"></textarea><br>
<input type="submit" name="submit" value="Submit">
</form>
<hr>
<br>
<br>

<?php

// This part of the code displays all of the comments
$file = file_get_contents("chat.txt"); // Defines the file that stores the comments
$datarray = unserialize($file); // Turns the contents of the file into an array
$max = count($datarray); // Sets the ammount of comments
 for ($row = $max-1; $row > -1; $row--) {
	 
	 echo "<div class='Container'><p class='NameAndDate'>" .$datarray[$row][0]. " | " .$datarray[$row][1]. " said:</p><div class='Comment'>" .$datarray[$row][2]. "</div></div>"; // The template of the comment
	 
}

?>
</div>
</body>
</html>