<?php
/*

O Contexto:
A empresa está enfrentando um problema em produção: desenvolvedores estão criando pacientes em branco no sistema, esquecendo de preencher os dados, o que causa falhas na geração de fichas. Precisamos criar uma estrutura segura que impeça isso de acontecer desde a raiz.

Regras de negócio:
- Criar a classe Paciente contendo dois atributos públicos: o nome e o cpf;
- A classe obrigatoriamente tem que barrar a criação de pacientes vazios. O sistema deve exigir que os dados de nome e cpf sejam informados no exato momento em que o objeto nasce;
- A classe deve ter um método chamado gerarFichaResumo(), que não recebe nada de fora, mas que usa os dados internos para retornar a string exata: "Ficha do Paciente: [NOME DO PACIENTE] - Documento: [CPF DO PACIENTE]";
- Fora da classe, crie o objeto do paciente usando o Payload, execute o método do resumo e imprima o resultado na tela;



--------------------------------------------

Resolução:

Dados de entrada: 
- $nomePaciente
- $cpfPaciente
classe Paciente.

Qual a ação inteligente que esse molde precisa executar?
- bloquear, usando o metodo Contrutor, que o objeto seja instanciado sem os atributos.

Quais as restrições da estrutura?
- não pode permitr que o paciente esteja vazio.

Qual o resultado esperado ao dar o comando final?
- só deve permitir que o objeto seja criado se tiver os atributos e imprimir os dados na tela.

Qual a sequência de passos (algoritmo) para criar a Classe e depois usá-la?
- Criar a classe Paciente;
-solicitar os atributos $nomePaciente e $cpfPaciente.
- criar o metodo com __construct(string $nomePaciente, string $cpfPaciente) atribuindo com o $this os atributos do metodo.
- Criar metodo gerarFichaResumo() que vai receber em variaveis e retorar uma string
- instanciar o $paciente com os dados 'Carlos Eduardo' com CPF '111.222.333-44', por exemplo, armazenar em uma variável e imprimir na tela.

*/

class Paciente {
    public string $nomePaciente;
    public string $cpfPaciente;

    public function __construct(string $nomePaciente, string $cpfPaciente) {
        $this->nomePaciente = $nomePaciente;
        $this->cpfPaciente = $cpfPaciente;
    }
    public function gerarFichaResumo():string {
        $fichaPaciente = $this->nomePaciente;
        $documento = $this->cpfPaciente;
        return "Paciente: " . $fichaPaciente . "<br>" . "Documento: " . $documento;
    }
}

$paciente = new Paciente('Carlos Eduardo', '111.222.333-44');

echo $paciente->gerarFichaResumo();
