<?php
/*
O Contexto:
O laboratório precisa aposentar os arrays que calculam os preços dos exames e criar uma estrutura profissional em POO para representar um "Exame de Convênio".

Todo exame feito por convênio na apLIS tem três informações obrigatórias na hora de faturar:

- O nome do procedimento.
- O valor bruto do exame.
- A porcentagem de coparticipação (a fatia que o paciente tem que pagar do próprio bolso. Ex: 20%).

A aplicação precisa que essa estrutura seja capaz de:

- Dizer qual é o valor exato em Reais (R$) que o paciente terá que pagar no balcão da recepção, baseado no valor bruto e na porcentagem de coparticipação dele.

--------------------------------------------

Resolução:

Dados de entrada:
- $nomeProcedimento;
- $precoBase;
- $taxaColeta;

Qual a ação inteligente que esse molde precisa saber executar sozinho?
- um método chamado calcularTotal()

Quais as restrições da estrutura?
- ela não recebe dados de fora. Recebe os atributos do objeto instanciado

Qual o resultado esperado ao dar o comando final?
- ao instanciar um objeto, deve-se utilizar dos atributos do objeto chamando a função que calcula o valor total do exame. Mostrar na tela o valor

Qual a sequência de passos (algoritmo) para criar a Classe e depois usá-la?
- criar a classe ExameSimples;
    - adicionar os atributos:
        - public string $nomeExame
        - public float $precoBase
        - public float $taxaColeta
    - criar metodo calcularTotal()
        - Retonando o calculo $this->precoBase + $this->taxaColeta;
- instanciar objeto $exameFisico = new ExameSimples();
- atribuir o nome do exame $exameFisico->nomeExame = 'Hemograma', por exemplo; 
- atribuir os preço base e taxa da mesma maneira;

- atribuir à uma variável o $valorTotalExame = $exameFisico->calcularTotal();
- mostrar na tela o valor total.

*/

class ExameSimples {
    public string $nomeExame;
    public float $precoBase;
    public float $taxaColeta;

    function calcularTotal() {
        return $this->precoBase + $this->taxaColeta;
    }
}

$exameFisico = new ExameSimples();

#exemplo
$exameFisico->nomeExame = 'Hemograma';
$exameFisico->precoBase = 15.5;
$exameFisico->taxaColeta = 5.00;

$valorTotalExame = $exameFisico->calcularTotal();

echo $valorTotalExame;
echo "<br>";

# teste se os atributos foram devidamente atribuídos 
echo "O valor total do exame " . $exameFisico->nomeExame . " é R$ " . $valorTotalExame;
