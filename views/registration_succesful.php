<div style="display: flex; align-items: center; justify-content: center" class="cont">
    <button style="background-color: green; margin: 10vw" action="index.php?action=main" type="button" class="card-btn">Registration succesful!</button>
</div>

<script>
    document.querySelector('.img__btn').addEventListener('click', function() {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
</script>