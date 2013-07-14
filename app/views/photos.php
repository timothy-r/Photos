<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool Photos</title>
</head>
<body>
<h1>Photos</h1>
<!-- list photos here -->
<ul>
<?php foreach ($photos as $photo) : ?>
    <li><?php $photo->getName() ?></li>
<?php endforeach ?>

</ul>
<a href="/photos/create">Add</a>

</body>
</html>

