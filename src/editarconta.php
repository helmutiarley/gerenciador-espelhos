<div class="badge bg-secondary text-wrap mb-3" style="width: 6rem;">Contas Espelho</div>
<?php
    $sql = "SELECT * FROM contas WHERE id_conta=".$_REQUEST["id"];
    $res = $conexao->query($sql);
    $row = $res->fetch_object();
?>
<form action="?page=salvarconta" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id" value="<?php print "$row->id_conta";?>">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><strong>Login bet365</strong></span>
        <input type="text" name="login" value="<?php print "$row->login_conta";?>" class="form-control">
    </div>
    <div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1"><strong>Senha bet365</strong></span>
        <input type="text" name="senha" value="<?php print "$row->senha_conta";?>" class="form-control">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
</form>