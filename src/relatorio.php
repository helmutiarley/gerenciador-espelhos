<div class="container">
<div class="badge bg-dark text-wrap mb-3" style="width: 6rem;">Saldo Diário</div>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Atenção!</strong> Este relatório mostra apenas usuários ativos...
  </div>
  <?php
  switch(@$_REQUEST['week']) {
    case "success":
      print "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
      print "Semana cadastrada com sucesso!";
      print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
      print "</div>";
      break;
    case "fail":
      print "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
      print "Esta semana já está cadastrada. Tente outra opção!";
      print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
      print "</div>";
      break;
    default:
    break;
  }
  ?>
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
    .td-green {
        color: green;
    }
    .td-red {
        color: red;
    }
  </style>


    <div class="container" id="allusers">
    <div id="container_content">
      <?php
    
          $sql = "SELECT * FROM usuarios";
          $res = $conexao->query($sql);
    
          $qtd = $res->num_rows;
    
          $sql_contas = "SELECT * FROM contas";
          $res_contas = $conexao->query($sql_contas);
    
          $fcredito = 0;
          $fsaldo = 0;
          $fmult = 0;
          $stotal = 0;
          $bonus = 0;

          print "<div class='container d-flex justify-content-center mb-3'>";
                    print "<button type='button' class='btn btn-dark position-relative'>";
                    print "<strong>SALDO DIÁRIO</strong>";
                    print "</button>";
                    print "</div>";

            if ($qtd > 0) {
              print "<table class='table table-bordered'>";
              print "<tr>";
              print "<th>". "Cliente" ."</td>";
              print "<th>". "Saldo Banca" ."</td>";
              print "</tr>";
            while ($row = $res->fetch_object()) {
    
              if ($row->conta != null) {
    
              $id = $row->id;
    
              $nome = $row->nome;
    
                $fcredito = (float)$row->credito;
                $fsaldo = (float)$row->saldo_atual;
                $fmult = (float)$row->multiplicador;
                $bonus = (float)$row->bonus;
                $final = (float)(($fsaldo - $fcredito - $bonus) * $fmult)*(-1);
                $stotal += $final;
                
    
              $credito = number_format($row->credito, 2, ',', '');
    
              print "<td><a href='?page=editarusuario&id=$id'><strong>$nome</strong></a> ($row->conta)</td>";
    
              if ($final >= 0) {
                print "<td id='saldo' class='td-green'><strong>R$ ". number_format($final, 2, ',', '.') ."</strong></td>";
              } elseif ($final < 0) {
                print "<td id='saldo' class='td-red'><strong>R$ ". number_format($final, 2, ',', '.') ."</strong></td>";
              } 
    
    
    
              // print "<td>
              //         <button onclick=\"location.href = '?page=editarusuario&id=" . $row->id . "'\" class='btn btn-success'>Editar</button>
              //         <button onclick=\"if(confirm('Tem certeza que deseja excluir?')) {location.href = '?page=salvar&acao=excluir&id=" . $row->id . "'} else {false;};\" class='btn btn-danger'>Excluir</button>
              //         </td>";
    
              print "</tr>";
    
          }
            }
            $sqltotal = "SELECT * FROM usuarios";
            $exectotal = $conexao->query($sqltotal);
            $dados_saldo_total = [];
    
    
    
            // while($res = $exectotal->fetch_array()) {
    
            //   if ($res["conta"] == true) {
            //     $dados_saldo_total[] = (double)$res["saldo_atual"];
            //   }
            // }
            $stotal = number_format($stotal, '2', ',', '.');
            print "<td><strong>TOTAL:</strong> </td>";
            print "<td><strong>R$ $stotal</strong></td>";
          $sqlmax = "SELECT max(last_update) FROM usuarios";
          $resmax = $conexao->query($sqlmax);
          $rowmax = $resmax->fetch_array();
          $date = strtotime($rowmax["0"]);
          print "</table>";
          print "<p class='small'><strong>Última Atualização</strong>: ". date('d/M/Y H:i:s', $date) . "</p>";
          ?>
</div>
          <?php
          print "<button id='rep' value='Print' class='btn btn-info btn_print'>Exportar</button> <a href='?page=usuarios'><button class='btn btn-secondary'>Voltar</button></a>";
      } else {
          print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
      }
      ?>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fechaSemana">
  Salvar Histórico
</button>
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

<!-- FECHAMENTO SEMANAL -->
<?php include('weeks.php') ?>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="fechaSemana" tabindex="-1" aria-labelledby="fechaSemanaLabel" aria-hidden="true">
  <form action="?page=fecharsemana" method="POST">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="fechaSemanaLabel">Fechamento Semanal</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-primary" role="alert">
          Selecione a semana que desejada e clique em <strong>salvar</strong>. Após isso, o histórico estará disponível no menu <strong>Histórico Semanal</strong>.
          </div>
        <div class="form-floating">
    <select name='semana' class="form-select" id="floatingSelect" aria-label="Floating label select example">
      <?php $a = 0;
    
    while ($semanas[$a]) {
      $sem = $a+1;
      print "<option value='$sem'>". $semanas[$a][0] . " até " . $semanas[$a][1] . "</option>";
      $a++;
      // $sql = "DROP TABLE `espelho`.`semana" . $sem . "`";
      // $sql = "CREATE TABLE `espelho`.`semana" . $sem . "` (`cliente` VARCHAR(150) NOT NULL , `saldo` DOUBLE NOT NULL ) ENGINE = InnoDB;";
      // $res = $conexao->query($sql);
    } ?>
    </select>
    <label for="floatingSelect">Semana para fechamento</label>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </form>
</div>
