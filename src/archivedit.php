<div class="badge bg-primary text-wrap mb-3" style="width: 6rem;">Edição de Usuário</div>

<?php
  $semana = $_REQUEST['semana'];
  
  $sql = "SELECT * FROM semana$semana WHERE id=".$_REQUEST["id"];
  $res = $conexao->query($sql);
  $row = $res->fetch_object();
?>

<link rel="stylesheet" href="../css/bootstrap.min.css">


  <form action="?page=salvarusuario" method="POST">
      <input type="hidden" name="acao" value="editarsemana">

      <input type="hidden" name="id" value="<?php print "$row->id";?>">
      <input type="hidden" name="semana" value="<?php print $_REQUEST['semana']?>">

      <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><strong>Cliente</strong></span>
          <input id="nomecliente" type="text" name="nome" value="<?php print "$row->cliente";?>" class="form-control">
      </div>

      <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><strong>Saldo Final R$</strong></span>
           <input id="valor2" type="text" name="saldofinal" class="form-control"   aria-describedby="basic-addon1" value="<?php $numeroformatado = number_format($row->saldo, '2', ',', ''); print $numeroformatado;?>">
      </div>

      <div class="mb-3 mt-3">
              <button class='btn btn-primary' type='submit'>Salvar</button>
      </div>
  </form>
</div>
<script>
          const input2 = document.querySelector('#valor2')

          input2.addEventListener('keypress', () => {
          let texto = input2.value;
          input2.value = texto.replace(".", ",");
          })
</script>