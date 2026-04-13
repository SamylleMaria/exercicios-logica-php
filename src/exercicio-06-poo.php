<?php
/*
O Contexto:
Desenvolvedores juniores estão alterando o status dos exames no sistema pulando regras de auditoria. Eles acessam a propriedade do exame e escrevem qualquer coisa, como "Cancelado" (o que exige outra rotina) ou até erros de digitação ("Em AnaliZe"). O Diretor Médico exigiu que a manipulação do status do exame seja estritamente controlada.

O Payload de Entrada (Simulado):
Tentativas de uso da classe:

-Nome do Exame ao criar: "Hemograma"
-Tentativas de mudança de status enviadas pela API: "Em Analise", "Concluido", "Cancelado".


Regras de Negócio:

- Crie a classe Exame.
E-la deve ter duas propriedades estritamente privadas: $nome e $status.
- O __construct deve exigir apenas o nome do exame no momento da criação.
- O $status deve "nascer" automaticamente preenchido com a string "Pendente" (dentro do próprio construtor, sem receber de fora).
- Crie um método público (Getter) chamado getStatusAtual() para que o sistema possa ler o status do exame e imprimi-lo na tela.
- Crie um método público (Setter) chamado alterarStatus($novoStatus).
- Regra de Ouro (Dentro do Setter): Este método só pode permitir que o status seja alterado se o $novoStatus for exatamente "Em Analise" ou "Concluido".
- Se qualquer outra string for enviada (ex: "Cancelado"), o método deve gerar um HTTP 400 (usando http_response_code), imprimir um JSON de erro {"mensagem": "Status invalido."} e interromper o script com die().

--------------------------------------------

Resolução:
Quais os dados de entrada?
 - Classe Exame com as propriedades $nome e $status;
O que a Classe/Função deve fazer?
 - A classe exame deve usar o construct exigindo apenas o nome do exame e por padrão ja deve ter o $status "Pendente"; Deve ter um metoto getStatusAtual() para ler o status do exame. um metodo alterarStatus($$novoStatus); 
Quais as restrições?
 - O o metodo alterarStatus so pode permitir a alteração para "em Analise" ou "Concluido".
Qual o resultado esperado final?
 - O Exame 'Hemograma' deve exibir o status padronizado "Pendente", "Em Analise" ou "Concluido". No caso de status diferente deve gerar um codigo 400 e interromper o script com die(json_encode(['mensagem'=>'Status Inválido']));
Qual a sequência de passos (algoritmo)?
    - Criar a classe Exame com as propriedades privadas $nome e $status;
    - criar um método com o __construct onde $this->nome = $nome e $this->status = 'Pendente' como padrão. 
    - criar um metodo public getStatusAtual() onde $this->status retorna uma string com o status.
    - criar um metodo publico alterarStatus($novoStatus);
    - com um if ($novoStatus !== 'Em Analise' && 'Concluido') { interrompe com die(json_encode(['mensagem'=>'Status Inválido']))}
    - Caso contrário getStatusAtual(string $novoStatus):string { return $this->status}
    
*/

class Exame {
    
    private string $nome;
    private string $status;
    
    public function __construct(string $nomeExame) {
        
        $this->nome = $nomeExame;
        $this->status = 'Pendente';
        }
        
        public function getStatusAtual():string {
            return $this->status;
            }
            
        public function alterarStatusAtual(string $novoStatus):void {
            if ($novoStatus !== 'Em Analise' && $novoStatus !== 'Concluido'){
            http_response_code(400);

            die(json_encode(['mensagem'=>'Status Inválido']));
        }
        $this->status = $novoStatus;
        
    }
}

$exame = new Exame('Hemograma');


echo "Teste 1 (Esperado: Pendente) -> Retornou: " . $exame->getStatusAtual() . "<br>";

$exame->alterarStatusAtual('Em Analise');
echo "Teste 2 (Esperado: Em Analise) -> Retornou: " . $exame->getStatusAtual() . "<br>";

$exame->alterarStatusAtual('Concluido');
echo "Teste 3 (Esperado: Concluido) -> Retornou: " . $exame->getStatusAtual() . "<br>";

$exame->alterarStatusAtual('Cancelado'); 
echo "Teste 5 (Forcando erro...)\n";

