<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            background-color: #f2f2f2;
            padding: 20px;
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            margin: 0 0 20px;
        }
        a.button {
            display: inline-block;
            background-color: #008CBA;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
        }
        a.button:hover {
            background-color: #006688;
        }
    </style>
</head>
<body>
<h1>Verify Your Email Address</h1>
<p>Thank you for signing up with our service. To start using your account, we need to verify your email address.</p>
<a href="{{$url}}" class="button">Verify Email Address</a>
<p>If you did not create an account with us, please ignore this email.</p>
<p>Thank you,</p>
<p>The {{config('app.name')}} Team</p>
</body>
</html>
