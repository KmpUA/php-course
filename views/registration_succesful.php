<head>
    <link href="../css/login.css" type="text/css" rel="stylesheet">
</head>
<div style="display: flex; align-items: center; justify-content: center" class="cont">
    <button style="background-color: green" action="index.php?action=main" type="button" class="submit">Registration succesful!</button>
</div>

<script>
    document.querySelector('.img__btn').addEventListener('click', function() {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
</script>