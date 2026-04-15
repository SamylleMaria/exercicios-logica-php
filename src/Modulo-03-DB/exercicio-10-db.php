<?php 

/*

O Contexto:
-Nós precisamos criar a nossa classe oficial de conexão com o banco de dados do laboratório. Essa classe será usada por todas as outras partes do sistema no futuro para salvar pacientes e exames. Ela precisa ser segura e nunca vazar credenciais se o banco cair.

O Payload de Entrada (Simulado):
-Você instanciará a classe passando credenciais falsas (para forçar o erro e testarmos o bloco catch):

    - Host/DB: "mysql:host=127.0.0.1;dbname=aplis_db"
    - Usuário: "admin_lab"
    - Senha: "senha_errada_proposital"

Regras de Negócio:

-Crie a classe ConexaoBanco.
-O construtor __construct deve receber e inicializar 3 propriedades privadas: $dsn (string), $usuario (string), $senha (string).
-Crie um método público chamado conectar(). Ele não precisa retornar nada (pois o objetivo desta task é apenas testar a barreira do try/catch na nossa simulação).
-Dentro do método conectar(), implemente a estrutura try { ... } catch (PDOException $e) { ... }.
-No bloco try, tente instanciar o objeto $pdo = new PDO(...) usando as propriedades da sua classe. Se passar, dê um echo "Conexão estabelecida!"; (isso não vai acontecer agora porque a senha é errada).
-No bloco catch, trave o sistema alterando o cabeçalho HTTP para 500 e mate o script usando JSON: {"erro": "Falha critica: O banco de dados do laboratorio esta offline."} (Lembrando do JSON_UNESCAPED_UNICODE se usar acentos).


---------------------------------------------

Resolução:
Quais os dados de entrada?
- classe ConexaoBanco, string $dsn, string $usuario, string $senha.

O que a Classe deve fazer?
- criar a conexão do banco e em caso de erro deve retornar o http 500 e com o die mostrar um JSON {"erro": "Falha critica: O banco de dados do laboratorio esta offline."}

Quais as restrições?
- em caso de erro deve mostrar apenas o Json com a mensagem.

Qual o resultado esperado final?
- Conexão com o banco de dados ou retornar um erro de conexão mostrando apenas o JSON "erro": "Falha critica: O banco de dados do laboratorio esta offline."

Qual a sequência de passos (algoritmo)?
- criar classe ConexaoBanco
- criar metodo construtor que vai receber as propriedades privadas string $this->dsn = $dsn, string $this->usuario = $usuario, string $this->senha = $senha;
- criar o metodo publico conectar() com a estrutura try e catch.
- no try deve instanciar o $pdo = new PDO recebendo as pripriedades da classe. 
    - em caso de sucesso deve dar um echo "Conexão estabelecida!";
- em caso de erro entra no catch(PDOException $e) que vai receber http_response_code(500), e vai encerrar o script com die(json_encode(["erro"]=>["Falha critica: O banco de dados do laboratorio esta offline."], JSON_UNESCAPED_UNICODE ));

*/

class ConexaoBanco {
    private string $dsn;
    private string $usuario;
    private string $senha;


    public function __construct(string $dsn, string $usuario, string $senha) {
        $this->dsn = $dsn;
        $this->usuario = $usuario;
        $this->senha = $senha;
    }

    public function conectar(): string {
        header('Content-Type: application/json');
        $dsn = $this->dsn;
        $usuario = $this->usuario;
        $senha = $this->senha;

        try {
            http_response_code(200);
            $conexao = new PDO($dsn, $usuario, $senha);
            return "Conectado com sucesso!";
        }catch(PDOException $erro) {
            http_response_code(500);

            die(json_encode(['Erro' => 'Falha critica: O banco de dados do laboratorio está offline.'], JSON_UNESCAPED_UNICODE));
        }

    }
}


//Testes - Exercicio feito para montar o erro "seguro".

// Criando o objeto com credenciais (vamos errar a senha soltando um erro fatal no PDO)
$db = new ConexaoBanco("mysql:host=127.0.0.1;dbname=aplis", "root", "senha_errada_123");

// Mandando conectar (Isso deve cair no 'catch' e exibir nosso JSON seguro)
$db->conectar();