<div style="display: flex; align-items: center; justify-content: center" class="cont">
    <a style="text-decoration: none; background-color: green; margin: 10vw" href="index.php?action=main" type="submit" class="card-btn">Registration succesful!</a>
</div>

<script>
    document.querySelector('.img__btn').addEventListener('click', function() {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
</script>