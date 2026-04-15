<?php
/*

1. classe PacienteRepository.
2. Receber o objeto PDO como propriedade privada; o construtor deve receber $this->conexao = $conexao; com o metodo salvar paciente ela deve ter uma requisição SQL que vai receber os values protegidos (:nome, :cpf), preencher com segurança las lacunas do sql com o bindValue e por fim salvar o Paciente na tabela.
3. deve-se proteger a requisição SQL com o :nome e :cpf.
4. a classe PacienteRepository deve receber com segurança os dados da requisição vinda do input e preencher corretamente os campos do banco. ao final deve ternar true.
5
- criar classe PacienteRepository
- receber a propriedade privada PDO $conexao;
- criar o metodo construtor e que deve receber a $this->conexao = $conexao;
- criar metodo publico salvarPaciente(string $nome, string $cpf):bool.
- $sql vai receber a requisição "INSERT INTO paciente (nome, cpf) VALUES (:nome, :cpf)";
- stmt vai preparar o sql $this->conexao->prepare(sql);
- preencher o sql com os dados $stmt->bindValue(':nome', $nome);
$stmt->bindValue(':cpf', $cpf);

$stmt->execute():


*/


class PacienteRepository {
    private PDO $conexao;

    public function __construct(PDO $conexao) {
        $this->conexao = $conexao;
    }

    public function salvarPaciente(string $nome, string $cpf): bool {
        $sql = "INSERT INTO pacientes (nome, cpf) VALUES (:nome, :cpf)";
        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':cpf', $cpf);

        $stmt->execute();

        return true;
    }
}



//Testes
// 1. O Mock (Simulação) de um banco de dados na memória RAM
$bancoEmMemoria = new PDO('sqlite::memory:');
$bancoEmMemoria->exec("CREATE TABLE pacientes (nome TEXT, cpf TEXT)");

// 2. Instanciando o seu Repositório e injetando a conexão falsa nele
$repositorio = new PacienteRepository($bancoEmMemoria);

// 3. Testando o método blindado
$sucesso = $repositorio->salvarPaciente("João da Silva", "123.456.789-00");

if ($sucesso) {
    echo "Sucesso Absoluto: Paciente inserido com SQL blindado!";
}