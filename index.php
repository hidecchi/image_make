<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            max-width: 100%;
        }

        textarea {
            max-width: 500px;
            width: 90%;
            height: 100px;
        }
    </style>
</head>

<body>
    <main>
        <p>元画像</p>
        <img src="./sample.jpg" alt="">
        <p>文字列を入力してください</p>
        <form>
            <textarea name="text" style="font-family:sans-serif"></textarea>
            <br>
            <input type="submit" value="画像をつくる">
        </form>
        <br>
        <div></div>
    </main>
    <script>
        const div = document.querySelector('div');
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = form['text'].value;
            div.innerHTML = '<img src="./image.php?text=' + text + '">'
        })
    </script>
</body>

</html>
