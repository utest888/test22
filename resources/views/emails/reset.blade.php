<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>找回密码确认链接</title>
</head>

<body>
    <h1>您正在找回密码！</h1>
    <p>
        请点击下面的链接完成找回密码：
        <a href="{{ route('password.reset', $token) }}">
            {{ route('password.reset', $token)}}
        </a>
    </p>
    <p>
        如果这不是您本人的操作，请忽略此邮件。
    </p>
</body>

</html>