<!DOCTYPE html>
<html>
<body>
    <h2>Welcome to the School, {{ $user->name }}!</h2>
    <p>Your account has been created successfully. Here are your login details:</p>
    <ul>
        <li><strong>Username / Roll Number:</strong> {{ $user->username }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please log in and change your password as soon as possible.</p>
</body>
</html>