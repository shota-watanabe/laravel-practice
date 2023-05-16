<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>会社登録画面</h1>

<!-- フォームエリア -->
<h2>フォーム</h2>
<form action="/companies" method="POST">
{{-- 非表示のトークン入力フィールドを生成 --}}
    @csrf
    名前:<br>
    <input name="name">
    <br>
    {{ csrf_field() }}
    <button class="btn btn-success"> 送信 </button>
</form>
</body>
</html>
