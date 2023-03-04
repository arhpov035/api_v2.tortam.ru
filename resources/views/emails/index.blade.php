<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email send</title>
</head>
<body>
<p><span style="font-weight: 500;">Название торта: </span> {{ $data['nameProduct'] }}</p>
<p><span style="font-weight: 500;">Вес торта: </span> {{ $data['weightProduct'] }}</p>
<p><span style="font-weight: 500;">Цена торта: </span> {{ $data['priceProduct'] }}</p>
<p><span style="font-weight: 500;">Email: </span> {{ $data['email'] }}</p>
<p><span style="font-weight: 500;">Телефон: </span> {{ $data['phone'] }}</p>
<p><span style="font-weight: 500;">Дата приготовления: </span> {{ $data['date'] }}</p>
</body>
</html>
