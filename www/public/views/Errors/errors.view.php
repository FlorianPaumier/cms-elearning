<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{code}}</title>
</head>
<body>
<h3 class="text-center">{{message}}</h3>
<p>At Line : {{line}}</p>
<pre>
    {{ trace|stackTrace }}
</pre>
</body>
</html>