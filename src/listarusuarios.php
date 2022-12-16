<div class="container">
  <div class="badge bg-primary text-wrap mb-3" style="width: 6rem;">Listagem de Usuários</div>
</div>

  <style>
    tr, td, th {
      text-align: center;
      font-size: .9rem;
    }
    a {
      text-decoration: none;
      color:inherit;
    }
    span.bonus {
      color: red;
      font-weight: 500;
    }
  </style>
<div class="container" id="allusers">
  <?php
    switch (@$_REQUEST["success"]) {
        case "userexists":
          print "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
          print "<strong>Atenção!</strong> Já existe um usuário com esse nome.";
          print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
          print "</div>";
          break;
        case "edited":
          print "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
          print "Usuário editado com sucesso!";
          print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
          print "</div>";
          break;
        case "failed":
          print "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
          print "Usuário editado com sucesso!";
          print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
          print "</div>";
          break;
        default: 
          break;

    }
if (isset($_REQUEST["userexists"])) {
  if ($_REQUEST["userexists"] == true) {
      
  }
}

      $sql = "SELECT * FROM usuarios";
      $res = $conexao->query($sql);
  
      $qtd = $res->num_rows;
  
      $sql_contas = "SELECT * FROM contas";
      $res_contas = $conexao->query($sql_contas);
  
      switch (@$_REQUEST["acc"]) {
        default:
      if ($qtd > 0) {
              print "<table class='table table-hover table-striped table-bordered' id='container_content'>";
              print "<thead>";
              print "<tr>";
              print "<th>". "Cliente" ."</td>";
              print "<th>". "Conta" ."</td>";
              print "<th>". "Saldo" ."</td>";
              print "</tr>";
              print "</thead>";
          while ($row = $res->fetch_object()) {         

              $id = $row->id;

              $nome = $row->nome;

              $credito = number_format($row->credito, 2, ',', '');

              print "<td><a href='?page=editarusuario&id=$id'><strong>$nome</strong></a> ($ $credito)</td>";

              if ($row->conta != null) {
                print "<td>$row->conta <a href='?page=salvarusuario&acao=excluirconta&id=" . $row->id . "'><i class='fa-solid fa-trash fa-2xs'></i></a></td>";
              } else {
                print "<td>---</td>";
              }
              
              if ($row->bonus != 0) {
                print "<td><span data-bs-toggle='modal' data-bs-target='#$row->conta'>$ ". number_format($row->saldo_atual, 2, ',', '') ." <span class='bonus'>*</span></span></td>";

                print "<div class='modal fade' id='$row->conta' tabindex='-1' aria-labelledby='$row->conta' aria-hidden='true'>";
                print "<div class='modal-dialog'>";
                print "<div class='modal-content'>";
                print "<div class='modal-header'>";
                print "<h1 class='modal-title fs-5' id='$row->conta'>Bônus de usuário</h1>";
                print "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                print "</div>";
                print "<div class='modal-body'>";
                print "O usuário <strong>$row->nome</strong> tem um bônus de <span class='bonus'>$ ". number_format($row->bonus, 2, ',', '') ."</span>";
                print "</div>";
                print "<div class='modal-footer'>";
                print "<button type='button' class='btn btn-primary' data-bs-dismiss='modal'>Fechar</button>";
                print "</div>";
                print "</div>";
                print "</div>";
                print "</div>";
                
              } else {
                print "<td>$ ". number_format($row->saldo_atual, 2, ',', '') ."</td>";
              }


              // print "<td>
              //         <button onclick=\"location.href = '?page=editarusuario&id=" . $row->id . "'\" class='btn btn-success'>Editar</button>
              //         <button onclick=\"if(confirm('Tem certeza que deseja excluir?')) {location.href = '?page=salvar&acao=excluir&id=" . $row->id . "'} else {false;};\" class='btn btn-danger'>Excluir</button>
              //         </td>";

              print "</tr>";
  
          }
          $sqltotal = "SELECT * FROM usuarios";
          $exectotal = $conexao->query($sqltotal);
          $dados_saldo_total = [];
    
    
    
          while($res = $exectotal->fetch_array()) {
    
            $dados_saldo_total[] = (double)$res["credito"];
            }
          
        $total = number_format(array_sum($dados_saldo_total), '2', ',', '');
        print "<td colspan='3'><strong>CRÉDITO SEMANA:</strong> $ $total</td>";
        
          $sqlmax = "SELECT max(last_update) FROM usuarios";
          $resmax = $conexao->query($sqlmax);
          $rowmax = $resmax->fetch_array();
          $date = strtotime($rowmax["0"]);
          print "</table>";
          print "<strong>Última Atualização</strong>: ". date('d/M/Y H:i:s', $date) . "<br><br>";
          print "<button data-bs-toggle='modal' data-bs-target='#exampleModal'  class='btn btn-dark'>Adicionar</button> <a href='?page=usuarios&acc=false'><button class='btn btn-secondary'>Ativos</button></a> <a href='?page=relatorio'><button class='btn btn-secondary'>Saldo Diário</button></a>";
      } else {
          print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
      }
      break;
      
      case "false":
        print "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
        print "<strong>Exibindo apenas usuários associados a uma conta bet365!</strong>";
        print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        print "</div>";
        if ($qtd > 0) {
          print "<table class='table table-hover table-striped table-bordered' id='container_content'>";
          print "<thead>";
          print "<tr>";
          print "<th>". "Cliente" ."</td>";
          print "<th>". "Conta" ."</td>";
          print "<th>". "Saldo" ."</td>";
          print "</tr>";
          print "</thead>";
        while ($row = $res->fetch_object()) {         
          
          if ($row->conta != null) {

          $id = $row->id;

          $nome = $row->nome;

          $credito = number_format($row->credito, 2, ',', '');
          
          print "<td><a href='?page=editarusuario&id=$id'><strong>$nome</strong></a> ($ $credito)</td>";

          if ($row->conta != null) {
            print "<td>$row->conta <a href='?page=salvarusuario&acao=excluirconta&id=" . $row->id . "'><i class='fa-solid fa-trash fa-2xs'></i></a></td>";
          } else {
            print "<td>---</td>";
          }

          print "<td>$ ". number_format($row->saldo_atual, 2, ',', '') ."</td>";

          print "</tr>";

      }
        }
        $sqltotal = "SELECT * FROM usuarios";
        $exectotal = $conexao->query($sqltotal);
        $dados_saldo_total = [];
    
    
    
        while($res = $exectotal->fetch_array()) {
    
          if ($res["conta"] == true) {
            $dados_saldo_total[] = (double)$res["credito"];
          }
        }
        $total = number_format(array_sum($dados_saldo_total), '2', ',', '');
        print "<td colspan='3'><strong>CRÉDITO SEMANA:</strong> $ $total</td>";
      $sqlmax = "SELECT max(last_update) FROM usuarios";
      $resmax = $conexao->query($sqlmax);
      $rowmax = $resmax->fetch_array();
      $date = strtotime($rowmax["0"]);
      print "</table>";
      print "<strong>Última Atualização</strong>: ". date('d/M/Y H:i:s', $date) . "<br><br>";
      print "<button data-bs-toggle='modal' data-bs-target='#exampleModal'  class='btn btn-dark'>Adicionar</button> <a href='?page=usuarios'><button class='btn btn-secondary'>Todos</button></a> <a href='?page=relatorio'><button class='btn btn-secondary'>Saldo Diário</button></a>";
  } else {
      print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
  }
      break;
    }
  ?>
</div>

<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>-->

<!-- Modal -->
<form action="?page=salvarusuario" method="POST">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Novo Usuário</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php include("novousuario.php"); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </div>
      </div>
    </div>
</form>