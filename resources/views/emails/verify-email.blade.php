<!DOCTYPE html>
<html>
<head>
    <style>
        .button {
            background-color: #3490dc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Добро пожаловать в {{ config('app.name') }}!</h1>
    <p>Пожалуйста, подтвердите ваш email адрес, нажав на кнопку ниже:</p>
    <a href="{{ $verificationUrl }}" class="button">Подтвердить Email</a>
    <p>Если вы не регистрировались в нашем сервисе, проигнорируйте это письмо.</p>
    <footer>
        © {{ date('Y') }} {{ config('app.name') }}. Все права защищены.<br>
        Наш адрес: ул. Примерная, 123, Москва, Россия
    </footer>
</body>
</html>