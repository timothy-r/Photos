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
    <li><a href="<?php echo $photo['uri']; ?>"><?php echo $photo['name'].' ('. $photo['id'] .')'; ?></a></li>
<?php endforeach ?>

</ul>
<a href="/photos/create">Add</a>

</body>
</html>

