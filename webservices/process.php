<?php
@extract($_POST);
$name = stripslashes($name);
$email = stripslashes($email);
$subject = stripslashes($subject);
$text = stripslashes($text);
mail('peter.gallagher@tcd.ie',$subject,$text,"From: $name <$email>");
header("location:form.php");
?>
