<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cool Photos</title>
</head>
<body>
<h1>Photos</h1>
<!-- list images here -->
<ul>
<?php foreach ($photos as $photo) : ?>
    <li><a href="/photos/<?php echo $photo->getId(); ?>"><?php echo $photo->getName(); ?></a></li>
<?php endforeach ?>

</ul>
<a href="/photos/create">Add</a>

</body>
</html>

