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
<?php
    include("weeks.php");
    if (!isset($_POST['semana'])) {
        print "<div class='alert alert-primary' role='alert'>";
        print "Selecione a semana desejada para que os dados sejam exibidos...";
        print "</div>";
    }
    if (isset($_POST['week'])) {
        $weektoremove = $_POST['week'];
        $sqlchecktrunc = "TRUNCATE TABLE semana" . $weektoremove;

        print "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
        print "<strong>Histórico excluído com sucesso...</strong>";
        print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        print "</div>";
        try {
            $restrunc = $conexao->query($sqlchecktrunc);
        } catch (Exception $e) {
            print "Erro: ('{$e->getMessage()}')\n{$e}\n";
        }
    }
?>
<form action="?page=archive" method="POST">
    <div class="form-floating">
    <select name='semana' class="form-select" id="floatingSelect" aria-label="Floating label select example">
          <?php $a = 0;
        print "<option value='1'>---</option>";
        while ($semanas[$a]) {
          $sem = $a+1;
          print "<option value='$sem'>". $semanas[$a][0] . " até " . $semanas[$a][1] . "</option>";
          $a++;
          // $sql = "DROP TABLE `espelho`.`semana" . $sem . "`";
          // $sql = "CREATE TABLE `espelho`.`semana" . $sem . "` (`cliente` VARCHAR(150) NOT NULL , `saldo` DOUBLE NOT NULL ) ENGINE = InnoDB;";
          // $res = $conexao->query($sql);
        } ?>
    </select>
    <label for="floatingSelect">Histórico Semanal</label>
    </div>
    <div class="d-grid gap-2">
    <button type="submit" class="btn btn-dark mt-3 mb-3">Exibir Histórico</button>
    </div>
</form>
            <?php
            $stotal = 0;
            if (isset($_POST['semana'])) {
                $semana = $_POST['semana'] - 1;
                $data1 = $semanas[$semana][0];
                $data2 = $semanas[$semana][1];
                
                $sqlcheck = "SELECT * FROM semana".$_POST['semana'];
                $rescheck = $conexao->query($sqlcheck);
                $rowcheck = $rescheck->num_rows;

                $semana = $_POST['semana'];

                if ($rowcheck > 0) {
                    print "<div class='container d-flex justify-content-center'>";
                    print "<button type='button' class='btn btn-dark position-relative' disabled>";
                    print "<strong>" . $data1 . "</strong> até <strong>" . $data2 . "</strong><svg width='1em' height='1em' viewBox='0 0 16 16' class='position-absolute top-100 start-50 translate-middle mt-1' fill='#212529' xmlns='http://www.w3.org/2000/svg'><path d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/></svg>";
                    print "</button>";
                    print "</div>";

                    print "<table class='table table-bordered table-stripped table-hover mt-3'>";
                
                    print "<thead>";
                    print "<tr>";
                    print "<th class='table-active'>Cliente</td>";
                    print "<th class='table-active'>Saldo</td>";
                    print "</tr>";
                    print "</thead>";
                    print "<tbody>";
                while($row = $rescheck->fetch_object()) {
                    print "<tr>";
                    print "<td><a href='?page=editarhistorico&id=$row->id&semana=$semana'>$row->cliente</a></td>";
                    if ($row->saldo >= 0) {
                        print "<td id='saldo' class='td-green'>R$ ". number_format($row->saldo, 2, ',', '.') ."</td>";
                    } elseif ($row->saldo < 0) {
                        print "<td id='saldo' class='td-red'>R$ ". number_format($row->saldo, 2, ',', '.') ."</td>";
                    }
                    print "</tr>";
                }
                    $sqlcontas = "SELECT * FROM semana$semana";
                    $rescontas = $conexao->query($sqlcontas);
                    
                    $total = 0;
                    while($rowtotal = $rescontas->fetch_object()) {
                        $total = $total + $rowtotal->saldo;
                    }

                print "<tr><td><strong>TOTAL:</strong> </td>";
                if ($total > 0) {
                    print "<td class='td-green'><strong>R$ " . number_format($total, '2', ',', '.') . "</strong></td></tr>";
                } elseif ($total < 0) {
                    print "<td class='td-red'><strong>R$ " . number_format($total, '2', ',', '.') . "</strong></td></tr>";
                }
                
                print "<tr>";
                print "<td colspan='2'>";
                
                print "<form action='?page=archive' method='POST'>";
                print "<input type='text' name='week' value='$semana' hidden>";
                print "<button type='submit' class='btn btn-danger btn-sm'>Excluir Histórico</button>
                ";
                print "</form>";
                print "</td>";
                print "</tr>";
                print "</tbody";
                print "</table>";
                } else {
                    print "<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>";
                    print "<strong>Ops...</strong> Não existe histórico para a semana selecionada...";
                    print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                    print "</div>";
                }
                
                
                
            } else {
                return;
            }
            ?>