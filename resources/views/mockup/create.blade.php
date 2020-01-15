<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <form method="post" action="/mockup" enctype="multipart/form-data">
        @csrf
        <input type="file" name="mockup">
        <input type="submit" value="Upload">
    </form>
</body>
</html>
