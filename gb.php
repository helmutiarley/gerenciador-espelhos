<div class="container">
    <form action="" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Código do Bilhete</span>
            <input id="code" type="text" name="codigo" class="form-control" aria-label="código" aria-describedby="basic-addon1">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" onclick="redirectGb();">Editar</button>
        </div>
    </form>
</div>

<script>
    function redirectGb () {
        var code = document.getElementById("code").value;
        var link = "https://portal.gbsistemas.net/jogos/ref/" + code
        window.open(link, '_blank');
    }
</script>