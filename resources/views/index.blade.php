<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>
<body>
    @foreach($books_model as $book)
        <p>{{ $book->ISBN }}</p>
    @endforeach
    <h4 class="font-light">test</h4>
</body>
</html>