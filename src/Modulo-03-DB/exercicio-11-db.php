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

    public function buscarPorCpf(string $cpf): ?array {
        $sql= "SELECT nome FROM pacientes WHERE cpf = :cpf";
        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(":cpf", $cpf);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($resultado === false)? null : $resultado;
    }

    public function buscarContato(int $id): ?array {
        $sql= "SELECT nome, cpf FROM pacientes WHERE id = :id";
        $stmt= $this->conexao->prepare($sql);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($resultado === false)? null : $resultado;
    }
}


//Testes
// Mock do banco em memória com um paciente já inserido
$banco = new PDO('sqlite::memory:');
$banco->exec("CREATE TABLE pacientes (id INT, nome TEXT, cpf TEXT)");
$banco->exec("INSERT INTO pacientes VALUES (456, 'Carlos Silva', '123.456.789-00')");

$repo = new PacienteRepository($banco);

// Teste 1: Buscar CPF que existe
$paciente = $repo->buscarPorCpf('123.456.789-00');
echo $paciente ? 'Encontrado: ' . $paciente['nome'] : 'Não encontrado';
echo '<br>';

// Teste 2: Buscar CPF que NÃO existe
$fantasma = $repo->buscarPorCpf('000.000.000-00');
echo $fantasma ? 'Encontrado: ' . $fantasma['nome'] : 'Não encontrado';
echo '<br>';

// Teste 3: Buscar ID que existe
$paciente = $repo->buscarContato(456);
echo $paciente ? 'Encontrado: ' . $paciente['nome'] . " | " . $paciente['cpf'] : 'Não encontrado';
echo '<br>';

// Teste 4: Buscar ID que NÃO existe
$fantasma = $repo->buscarContato(000);
echo $fantasma ? 'Encontrado: ' . $fantasma['nome'] : 'Não encontrado';