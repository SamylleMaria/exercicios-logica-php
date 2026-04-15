<?php 
/*
O Contexto:
O setor de RH do laboratório pediu uma atualização no sistema que gera os textos para a impressão dos crachás. Nós temos profissionais de saúde e da área administrativa. Todos eles são "Funcionários" da empresa (com Nome e CPF), mas os Médicos possuem um registro de conselho (CRM) e os Recepcionistas possuem um Turno de trabalho (Manhã/Noite).
Para não repetir código copiando $nome e $cpf em todas as classes de cada cargo, você vai usar a Herança para construir uma classe "Mãe" genérica e duas classes "Filhas" específicas.

O Payload de Entrada (Simulado):
Você instanciará dois objetos no final com os seguintes dados:

Médico: Nome = "Dr. Roberto", CPF = "111.111.111-11", CRM = "CRM-SP 12345"
Recepcionista: Nome = "Amanda", CPF = "222.222.222-22", Turno = "Noturno"
Regras de Negócio:

A Classe Mãe: Crie a classe Funcionario com as propriedades protected string $nome e protected string $cpf. (Dica: Ao usar protected, você tranca o dado pro lado de fora, mas libera para as filhas usarem o $this->nome livremente).
O __construct da classe Funcionario deve receber apenas nome e cpf e atribuí-los.
A Filha 1: Crie a classe Medico que herda (extends) de Funcionario. Ela precisa de uma propriedade exclusiva private string $crm.
O __construct do Medico deve exigir nome, cpf e crm. Dentro dele, você deve obrigar a classe mãe a lidar com o nome e cpf usando parent::__construct($nome, $cpf);, e em seguida salvar apenas o crm na propriedade da própria classe.
O Medico deve ter um método público getCrachaMedico(): string que retorna exatamente: "Médico(a): [NOME] - CPF: [CPF] - CRM: [CRM]".
A Filha 2: Crie a classe Recepcionista que herda de Funcionario. Ela precisa da propriedade exclusiva private string $turno.
O __construct da Recepcionista receberá nome, cpf e turno (usando o parent para os dados base).
A Recepcionista deve ter o método getCrachaRecepcionista(): string que retorna: "Atendimento: [NOME] - Turno: [TURNO]".

---------------------------------------------

Resolução:
Quais os dados de entrada?
- class Funcionario - (protected string $nome, protected string $cpf) class Medico (private string $crm), class Recepcionista (private string $turno)

O que a Classe deve fazer?
- As classes filhas devem herdar propriedades da classe mãe, alem de  ter as suas exclusivas.

Quais as restrições?
- propriedades $crm e $turno são exclusivas das classes Medico e Recepcionista respectivamente.

Qual o resultado esperado final?
- Classes Medico e Recepcionista herdem propriedades da classe mãe Funcionario, receba suas proprias propriedades e ao fim seja exbido os atributos da propriedade de cada classe filha.

Qual a sequência de passos (algoritmo)?
- Criar classe mãe Funcionario com as propriedades protected $nome e $cpf;
    - criar metodo __construct(string $nome, string $cpf) obrigatoriamente;
- criar class Medico extends Funcionario e atribuir private string $crm;
    - chamar o metodo parent::__construct($nome, $cpf);
    - criar metodo public function getCrachaMedico(): string , com $this->nome, $this->cpf, $this->crm
    - retornar a string "Médico(a): [NOME] - CPF: [CPF] - CRM: [CRM]".
- criar class Recepcionista extends Funcionario e atribuir private string $turno;
    - chamar o metodo parent::__construct($nome, $cpf);
    - criar metodo public function getCrachaRecepcionista(): string, com $this->nome, $this->turno ;
    - retornar a string "Atendimento: [NOME] - Turno: [TURNO]";

*/
 

class Funcionario {
    protected string $nome;
    protected string $cpf;

    public function __construct(string $nome, string $cpf) {
        $this->nome = $nome;
        $this->cpf = $cpf;
    }
}

class Medico extends Funcionario {
    private string $crm;

    public function __construct(string $nome, string $cpf, string $crm) {
        parent::__construct($nome, $cpf);
        $this->crm = $crm;
    }

    public function getCrachaMedico():string {
        return "Médico(a): {$this->nome} | CPF: {$this->cpf} | CRM: {$this->crm}";
    }
}

class Recepcionista extends Funcionario {
    private string $turno;

    public function __construct(string $nome, string $cpf, string $turno) {
        parent::__construct($nome, $cpf);
        $this->turno = $turno;
    }

    public function getCrachaRecepcionista(): string {
        return "Atendimento: {$this->nome} | Turno: {$this->turno}";
    }
}


// Teste
$medico = new Medico("Dr. Roberto", "111.111.111-11", "CRM-SP 12345");
echo $medico->getCrachaMedico() . "<br>";
//Esperado: Médico(a): Dr. Roberto - CPF: 111.111.111-11 - CRM: CRM-SP 12345

$recep = new Recepcionista("Amanda", "111.111.111-22", "Noturno");
echo $recep->getCrachaRecepcionista() . "<br>";
// Esperando: "Atendimento: Amanda | Turno: Noturno"