let selectedValue = document.getElementById("list").value
    function copiarTexto() {
        currentdate = new Date();
        var oneJan = new Date(currentdate.getFullYear(),0,1);
        var numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
        var result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);

        let nomecliente = document.getElementById("nomecliente")
        let senhaconta = document.getElementById("senhaconta")
        let valor1 = document.getElementById("valor1")
        let mult = document.getElementById("mult")
        console.log(selectedValue)
        let valorfinal = document.getElementById("valorfinal")

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

        var string = "*[Espelhos HM(bet365) - SEMANA " + result + "]*\n\n" + saudacao + "\n\nEstamos iniciando uma nova semana. Abaixo estão as informações referentes ao seu acesso: \n\n*Login:* " + selectedValue + "\n*Senha:* " + senhaconta.value + "\n\n*Crédito:* $ " + valor1.value + " referente a R$ " + valorfinal.value + "\n\n*Multiplicador:* " + mult.value

        navigator.clipboard.writeText(string)
        alert("Copiado!")
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