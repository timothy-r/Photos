<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool Photos</title>
</head>
<body>
<h1>Add a photo</h1>
<form method="POST" action="/photos" enctype="multipart/form-data">
<input name="name" type="text" placeholder="Name:"></input>
<input name="image" type="file" placeholder="Pick an image"></input>
<input name="submit" type="submit" value="Add"></input>
</form>
<a href="/photos">List</a>
</body>
</html>


