<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Битва слайдов</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="app"></div>
<script src="http://localhost:8080/bitva/dist/app.js"></script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : 401951397104787,
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v4.0'
        });
    };
</script>
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
</body>
</html>
