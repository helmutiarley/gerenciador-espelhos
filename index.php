<?php
  include("src/config/config.php");
  include("src/protect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
	


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script> 


	<script src="https://cdn.apidelv.com/libs/awesome-functions/awesome-functions.min.js"></script> 

    <title>Backoffice</title>
    <style>
      table {
        text-align: center;
      }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/date-fns/1.30.1/date_fns.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" ></script>

    <script type="text/javascript">
	$(document).ready(function($) 
	{ 

		$(document).on('click', '.btn_print', function(event) 
		{
			event.preventDefault();

			//credit : https://ekoopmans.github.io/html2pdf.js
			
			var element = document.getElementById('container_content'); 

			//easy
			//html2pdf().from(element).save();

			//custom file name
			//html2pdf().set({filename: 'code_with_mark_'+js.AutoCode()+'.pdf'}).from(element).save();


			//more custom settings
			var opt = 
			{
			  margin:       1,
			  filename:     'Relatório Espelhos.pdf',
			  image:        { type: 'jpeg', quality: 0.98 },
			  html2canvas:  { scale: 2 },
			  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
			};

			// New Promise-based usage:
			html2pdf().set(opt).from(element).save();

			 
		});

 
 
	});
	</script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Gerenciador Espelhos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=usuarios">Listar Usuários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=relatorio">Saldo Diário</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=contas">Listar Contas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=archive">Histórico Semanal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=gb">GB (teste)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="./login/logout.php">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="text-center">
</div>

    <div class="container">
        <div class="row">
            <div class="col mt-5">
    <?php
        switch(@$_REQUEST["page"]) {
            case "novo": 
                include("src/novousuario.php");
                break;
            case "usuarios":
                include("src/listarusuarios.php");
                break;
            case "contas":
                include("src/listarcontas.php");
                break;
            case "salvarusuario";
                include("src/salvarusuario.php");
                break;
            case "removerconta";
                include("src/removeacc.php");
                break;
            case "salvarconta";
                include("src/salvarconta.php");
                break;
            case "editarusuario";
                include("src/editarusuario.php");
                break;
            case "editarhistorico";
                include("src/archivedit.php");
                break;
            case "editarconta";
                include("src/editarconta.php");
                break;
            case "relatorio";
                include("src/relatorio.php");
                break;
            case "archive";
                include("src/archive.php");
                break;
            case "fecharsemana";
                include("src/fecharsemana.php");
                break;
            case "gb";
                include("gb.php");
                break;
            default:
            print "<hr>";
        }
    ?>
            </div>
        </div>
    </div>

    <div class="container">
      <?php
        $sqlcontas = "SELECT cliente_conta FROM contas";
        $resultadocontas = $conexao->query($sqlcontas);
        $rowcontas = $resultadocontas->fetch_array();
        $res = $rowcontas["cliente_conta"];
        // while ($resultadocontas->fetch_object()) {
        //   print_r($resultadocontas);
        //   // $rowcontas = $resultadocontas->cliente_conta;
        //   // if ($rowcontas != 0) {
        //   //   echo $rowcontas;
        //   // }
        // }

        // $sql = "SELECT sum(credito) FROM usuarios";
        // $resultado = $conexao->query($sql);
        // $row = $resultado->fetch_array();
        // $sum = $row["sum(credito)"];
        // print_r($sum);
      ?>
    </div>

    

    <?php
      if ($_REQUEST == null) {
        include('src/dashboard.php');
      }
    ?>

    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
  <script>
  function getSelectValue() {
            selectedValue = document.getElementById("list").value
        }
  </script>
</body>
</html>