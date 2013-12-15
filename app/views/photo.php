<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool Photo</title>
</head>
<body>
<h1>Photo</h1>
<div><?php echo $photo['title']; ?></div>
<img src="<?php echo $photo['uri']; ?>"/>

<a href="/photos/create">Add</a>
<a href="/photos">List</a>

</body>
</html>

