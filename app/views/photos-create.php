<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool Photos</title>
</head>
<body>
<h1>Add a photo</h1>
<form method="POST" action="/photos">
<input name="title" type="text" placeholder="Title:"></input>
<br/>
<input name="file" type="file" placeholder="Photo:"></input>
<br/>
<input name="submit" type="submit" value="Add"></input>
</form>
<a href="/photos">List</a>
</body>
</html>


