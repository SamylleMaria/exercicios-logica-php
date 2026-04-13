<?php

/*
O Contexto:
-O nosso laboratório atende pacientes de planos de saúde (convênios). Cada contrato de convênio tem um valor base cadastrado no sistema. Tivemos um problema recente onde um erro de cálculo do financeiro enviou mensalidades negativas (ex: -150.00) para a atualização do banco, e o sistema de faturamento aceitou cegamente, quebrando o fluxo de caixa pago aos médicos conveniados.

O Payload de Entrada (Simulado):
-Você receberá tentativas de alteração do valor base do convênio:

Nome do Convênio (no nascimento): "Unimed Ouro"
- Valor inicial (no nascimento): 500.00
- Tentativas de atualização (Setters): 550.00 (Aumento anual - Válido), -100.00 (Erro do Financeiro - Inválido).

Regras de Negócio:

Crie a classe Convenio.
- Ela deve ter duas propriedades estritamente privadas: string $nomePlano e float $valorBase.
- O __construct deve exigir ambos os dados (nome e valor inicial) no momento da criação.
- Crie um Getter público (getValorBase(): float) para leitura do valor.
- Crie um Setter público (atualizarValor(float $novoValor): void).
- A Regra da Alfândega (Dentro do Setter):
- O novo valor não pode ser menor que zero (negativo).
- O novo valor não pode ser extorsivo (maior que 5000.00, que é o teto do laboratório para convênios premium).
- Se falhar nessas regras, aborte o script com die(), retorne o HTTP 400 e o JSON {"mensagem": "Valor de mensalidade fora do limite permitido."} (lembre-se do JSON_UNESCAPED_UNICODE!).
- Se passar pelas regras, atualize a propriedade privada $valorBase.



---------------------------------------------

Resolução:
Quais os dados de entrada?
- Classe convênio; propriedades privadas string $nomePlano e float $valorBrase;

O que a Classe deve fazer?
- garantir que as propriedades sejam obrigatórias, verificar se o novo valor é positivo, e se o valor é iferior ou igual ao teto 5000,00.

Quais as restrições?
- o novo valor não pode ser negativo, não pode ultrapassar o teto, as propriedades não podem ser publicas.

Qual o resultado esperado final?
- O objeto deve receber os valores positivos e até 5000,00 validados com if.
- Se for barrado pelas regras deve abortar o script com die(), retornar o HTTP 400 e o JSON com {"mensagem": "Valor de mensalidade fora do limite permitido."}
- Se passar pelas regras deve atualziar a propriedade $valorBase com $this->valorBase = $novoValor.

Qual a sequência de passos (algoritmo)?
- criar Classe Convenio;
- criar propriedades privadas string $nomePlano e float $valorBase;
- criar método __construct(string $nomePlano,float $valorBase) {
$this->nomePlano = $nomePlano; $this->atualizaValor($valorBase);}
- criar método getValorBase(): float {
return $this->valorBase }
- criar método atualizarValor(float $novoValor): void;
- comparar com if se $novoValor é positivo e se é menor ou igual a 5000.00;
    - caso seja invalidado deve-se retornar o codigo http 400 e o die com o JSON {"mensagem": "Valor de mensalidade fora do limite permitido."};
    - caso validado deve atualizar a propriedade $valorBase com $this->valorBase = $novoValor.

*/

class Convenio {
    private string $nomePlano;
    private float $valorBase;

    public function __construct(string $nomePlano, float $valorBase) {
        $this->nomePlano = $nomePlano;
        $this->atualizarValor($valorBase);
    }

    public function getValorBase(): float {
        return $this->valorBase;
    }

    public function atualizarValor(float $novoValor): void {
        if ($novoValor < 0 || $novoValor > 5000) {
            http_response_code(400);
            die(json_encode(['mensagem' => 'Valor de mensalidade fora do limite permitido.']));
        }

        $this->valorBase = $novoValor;
    }
}

// Teste 1: Nascimento Saudável
$convenio = new Convenio("Unimed Ouro", 500.00);
echo "Valor inicial: R$ " . $convenio->getValorBase() . "<br>";

// Teste 2: Atualização Válida
$convenio->atualizarValor(550.00);
echo "Novo valor (Reajuste): R$ " . $convenio->getValorBase() . "<br>";

// Teste 3: A Barreira Financeira (Vai forçar a quebra do PHP)
echo "Tentando valor negativo...<br>";
$convenio->atualizarValor(-100.00);