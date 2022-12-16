  <div class="badge bg-primary text-wrap mb-3" style="width: 6rem;">Edição de Usuário</div>

  <?php
    
    
    $sql = "SELECT * FROM usuarios WHERE id=".$_REQUEST["id"];
    $res = $conexao->query($sql);
    $row = $res->fetch_object();

    $sql_contas = "SELECT * FROM contas";
    $res_contas = $conexao->query($sql_contas);
    if ($row->conta == null) {
        print "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
        print "<strong>Atenção!</strong> Este usuário não possui conta bet365.";
        print "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        print "</div>";
    }
?>

  



<link rel="stylesheet" href="../css/bootstrap.min.css">


    <form action="?page=salvarusuario" method="POST">
        <input type="hidden" name="acao" value="editar">

        <input type="hidden" name="id" value="<?php print "$row->id";?>">

        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><strong>Cliente</strong></span>
            <input id="nomecliente" type="text" name="nome" value="<?php print "$row->nome";?>" class="form-control">
        </div>

        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><strong>Senha (bet365)</strong></span>
            <?php
                $sqlsenha = "SELECT * FROM contas WHERE login_conta='$row->conta'";
                $ressenha = $conexao->query($sqlsenha);
                $rowsenha = $ressenha->fetch_object();
                
            ?>
            <input id="senhaconta" type="text" name="senhaconta" value="<?php 
                                                        if ($rowsenha == false) {
                                                            print "";
                                                        } else {
                                                            print $rowsenha->senha_conta;
                                                        }
            
                                                        ?>" class="form-control">
        </div>

        <div class="form-floating mb-3">
            <select id='list' onchange="getSelectValue()" name="conta" class="form-select" aria-label="Floating label select example">
            <?php
                print "<option value='semconta'>---</option>";
                while($row_contas = $res_contas->fetch_object()) {

                    $nome_conta = $row_contas->login_conta;

                    $sqlcheck = "SELECT * FROM usuarios WHERE conta='$nome_conta'";
                    $rescheck = $conexao->query($sqlcheck);
                    $rowcheck = $rescheck->fetch_object();

                    if ($rowcheck != null) {
                        
                        $usuariocheck = $rowcheck->nome;

                        if ($usuariocheck == $row->nome) {
                            print "<option value='$nome_conta' selected>$nome_conta ($usuariocheck)</option>";
                        } else {
                            print "<option value='$nome_conta'>$nome_conta ($usuariocheck)</option>";
                        }

                    } else {

                        print "<option value='$nome_conta'><strong>$nome_conta</strong></option>";

                    }
            }
            ?>
            </select>
            <label for="floatingSelect">Conta 365</label>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><strong>Crédito $</strong></span>
             <input id="valor1" type="text" name="credito" class="form-control"   aria-describedby="basic-addon1" value="<?php $numeroformatado = number_format($row->credito, '2', ',', ''); print $numeroformatado;?>">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><strong>Saldo Atual $</strong></span>
             <input id="valor2" type="text" name="saldoatual" class="form-control"   aria-describedby="basic-addon1" value="<?php $numeroformatado = number_format($row->saldo_atual, '2', ',', ''); print $numeroformatado;?>">
        </div>
            
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><strong>$ x</strong></span>
             <input id="mult" type="text" name="multiplicador" class="form-control"   aria-describedby="basic-addon1" value="<?php print "$row->multiplicador";?>">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><strong>Bônus $</strong></span>
             <input id="valor1" type="text" name="bonus" class="form-control"   aria-describedby="basic-addon1" value="<?php $numeroformatado = number_format($row->bonus, '2', ',', ''); print $numeroformatado;?>">
        </div>

        <div class="form-floating">
            <textarea class="form-control" name='obs' placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?php print $row->obs; ?></textarea>
            <label for="floatingTextarea2">Observações</label>
        </div>
        <textarea id="valorfinal" hidden><?php $valorfinal = ($row->credito) * ($row->multiplicador); print number_format($valorfinal, '2', ',', '.');?></textarea>
        <div class="mb-3 mt-3">
        <?php 
        
        $sqlmax = "SELECT max(last_update) FROM usuarios";
        $resmax = $conexao->query($sqlmax);
        $rowmax = $resmax->fetch_array();
        $date = strtotime($rowmax["0"]);
        
        print "<strong>Última Atualização</strong>: ". date('d/M/Y H:i:s', $date) . " <strong>($row->usertoupdate)</strong><br><br>";
        
        ?>
                <button class='btn btn-primary' type='submit'>Salvar</button>
                <button class='btn btn-secondary' type="button" onclick="copiarTexto()">Abertura</button>
                <button class='btn btn-secondary' type="button" onclick="fecharSemana()">Fechamento</button>
        </div>
    </form>
</div>
<script>
    let selectedValue = document.getElementById("list").value
    function copiarTexto() {
        currentdate = new Date();
        var oneJan = new Date(currentdate.getFullYear(),0,1);
        var numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
        var result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);

        let nomecliente = document.getElementById("nomecliente")
        let senhaconta = document.getElementById("senhaconta")
        let valor1 = document.getElementById("valor1")
        let mult = document.getElementsByName("multiplicador")[0]

        let valorfinal = document.getElementById("valorfinal")

        var credito = parseFloat(document.getElementById("valor1").value.replace(',', '.'))
        var saldo = parseFloat(document.getElementById("valor2").value.replace(',', '.'))
        var multip = parseFloat(document.getElementById("mult").value.replace(',', '.'))

        var referentea = credito  * multip

        var momentoAtual = new Date()

        let hora = momentoAtual.getHours()

        let saudacao = "a"

        if (hora < 12) {
            saudacao = 'Bom dia!'
        } else if (hora > 12 && hora < 18) {
            saudacao = 'Boa tarde!'
        } else {
            saudacao = 'Boa noite!'
        }

        var string = "*[Espelhos HM(bet365) - SEMANA " + result + "]*\n\n" + saudacao + "\n\nEstamos iniciando uma nova semana. Abaixo estão as informações referentes ao seu acesso: \n\n*Login:* " + selectedValue + "\n*Senha:* " + senhaconta.value + "\n\n*Crédito:* $ " + valor1.value + " referente a R$ " + referentea + "\n\n*Multiplicador:* " + mult.value

        string = window.encodeURIComponent(string)

        window.open("https://api.whatsapp.com/send?phone=&text=" + string)
        // navigator.clipboard.writeText(string)
        // alert("Copiado!")
    }

        // fechar semana

        function fecharSemana() {
            let date = new Date();
        let hoje = new Date();
        hoje.getDate()

        date.setDate(hoje.getDate() - 2) // dia 29 de dezembro

        const inicioSemana = dateFns
        .startOfWeek(date, { weekStartsOn: 0 })
        .toLocaleDateString('pt');
        const fimSemana = dateFns
        .endOfWeek(date, { weekStartsOn: 0 })
        .toLocaleDateString('pt');

        currentdate = new Date();
        var oneJan = new Date(currentdate.getFullYear(),0,1);
        var numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
        var result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);

        let nomecliente = document.getElementById("nomecliente")
        let senhaconta = document.getElementById("senhaconta")
        let valor1 = document.getElementById("valor1")
        let mult = document.getElementById("mult")
        let valorfinal = document.getElementById("valorfinal")

        var credito = parseFloat(document.getElementById("valor1").value.replace(',', '.'))
        var saldo = parseFloat(document.getElementById("valor2").value.replace(',', '.'))
        var bonus = parseFloat(document.getElementsByName("bonus")[0].value.replace(',', '.'))
        var multip = parseFloat(document.getElementById("mult").value.replace(',', '.'))

        var finalsemana = ((saldo - credito - bonus) * multip)

        console.log(finalsemana)

        var momentoAtual = new Date()

        let hora = momentoAtual.getHours()

        let saudacao = "a"

        if (hora < 12) {
            saudacao = 'Bom dia!'
        } else if (hora > 12 && hora < 18) {
            saudacao = 'Boa tarde!'
        } else {
            saudacao = 'Boa noite!'
        }

        var string = "*[Espelhos HM(bet365) - " + inicioSemana + " a " + fimSemana + "]*\n\n" + saudacao + "\n\n*Saldo PARCIAL:* " + finalsemana.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) + "\n\nEste saldo ainda passará por revisão e poderá sofrer alterações. O saldo final será enviado no fim da tarde.\n\nO relatório final incluirá SALDO ESPELHO + SALDO DO GRUPO."

        string = window.encodeURIComponent(string)

        window.open("https://api.whatsapp.com/send?phone=&text=" + string)
        // navigator.clipboard.writeText(string)
        // alert("Copiado!")
    }

        const input = document.querySelector('#valor1')

        input.addEventListener('keypress', () => {
        let texto1 = input.value;
        input.value = texto1.replace(".", ",");
        })

        const input2 = document.querySelector('#valor2')

        input2.addEventListener('keypress', () => {
        let texto = input2.value;
        input2.value = texto.replace(".", ",");
        })
</script>