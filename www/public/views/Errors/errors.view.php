<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ code }}</title>
</head>
<body>
<a href="@path(app_home)">Retour</a>
<h3 class="text-center">{{ message }}</h3>
<p>At Line : {{ line }}</p>
<pre>
    <?php foreach ($trace as $row): ?>
        <div><?= var_export($row, true) ?></div>
    <?php endforeach; ?>
</pre>
</body>
</html>