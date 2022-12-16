
  <div class="badge bg-success text-wrap mb-3" style="width: 6rem;">Contas bet365</div>

<?php
    $sql = "SELECT * FROM contas";
    $res = $conexao->query($sql);

    $qtd = $res->num_rows;
  
    if ($qtd > 0) {
            print "<table class='table table-hover table-striped table-bordered'>";
            print "<tr>";
            print "<th>". "ID" ."</td>";
            print "<th>". "Login" ."</td>";
            print "<th>". "Senha" ."</td>";
            print "<th>". "Ações" ."</td>";
            print "</tr>";
        while ($row = $res->fetch_object()) {
            print "<tr>";
            print "<td>". $row->id_conta ."</td>";
            print "<td>". $row->login_conta ."</td>";
            print "<td>". $row->senha_conta ."</td>";
            print "<td>
            <button onclick=\"location.href = '?page=editarconta&id=" . $row->id_conta . "'\" class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></button>
                    <button onclick=\"if(confirm('Tem certeza que deseja excluir?')) {location.href = '?page=salvarconta&acao=excluir&id=" . $row->id_conta . "'} else {false;};\" class='btn btn-danger'><i class='fa-solid fa-trash'></i></button>
                    </td>";
            print "</tr>";
        }
        print "</table>";
        print "<button data-bs-toggle='modal' data-bs-target='#addmodal'  class='btn btn-dark'>Adicionar</button>";
    } else {
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }

?>

<!-- <button onclick=\"location.href = '?page=editarbotao&id=" . $row->id . "'\" class='btn btn-success'>Editar</button> -->


<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>-->

<!-- MODAL ADICIONAR BOTÃO -->
<form action="?page=salvarconta" method="POST">
    <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="addmodalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addmodalLabel">Nova Conta</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php include("novaconta.php"); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </div>
      </div>
    </div>
</form>

