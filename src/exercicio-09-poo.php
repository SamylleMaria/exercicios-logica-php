<?php
/*

O Contexto:
As máquinas que analisam o sangue no laboratório enviam os resultados brutos de Hemoglobina diretamente para a nossa API. O problema é que a máquina é instável: às vezes ela manda o campo de observações médicas, às vezes não manda (vem nulo). Além disso, baseado no nível de hemoglobina, nós precisamos que o sistema PHP, no momento em que o objeto nasce, classifique automaticamente a saúde do paciente e defina se a impressão da etiqueta deve ser marcada como Urgente.

O Payload de Entrada (Simulado):
-Você vai receber variáveis soltas simulando o que a máquina enviou:

    -Nome: "Carlos"
    -Hemoglobina: 10.5
    -Urgente (Booleano - Vira da triagem): true
    -Observacoes: null (A máquina falhou em enviar)


Regras de Negócio (Obrigatórias):

- Crie a classe ResultadoExame com 5 propriedades privadas: $paciente (string), $hemoglobina (float), $urgencia (string), $classificacao (string) e $notas (string).
- O __construct deve receber: nome, hemoglobina, o booleano de urgência, e as observações (que pode ser string ou null, então tipe como ?string).
- Regra do Null Coalescing (??): Dentro do construtor, atribua o valor recebido às $notas. Se o valor recebido for nulo, use o ?? para salvar a string padrão "Sem notas do aparelho".
- Regra do Ternário (? :): A máquina envia urgência como true ou false. Você não pode salvar booleano. Use um operador ternário em 1 linha para: se for true, salvar a string "CRITICO"; se for false, salvar "ROTINA" na propriedade $urgencia.
- Regra do if/elseif/else: O construtor deve avaliar a hemoglobina recebida para preencher a propriedade $classificacao:
    - Se for menor que 12.0: Salvar "Anemia"
    - Se for maior que 17.5: Salvar "Alta"
    - Se não for nenhum dos dois (Else): Salvar "Normal"
- Crie um Getter público getRelatorio(): string que devolva:
"Paciente: [NOME] | Nivel: [HEMOGLOBINA] ([CLASSIFICACAO]) | Prioridade: [URGENCIA] | Notas: [NOTAS]"

----------------------------------------------------------
Resolução:


Quais os dados de entrada?
- class ResultadoExame, propriedades privadas string $paciente, float $hemoglobina, string $urgencia, string $classificação e string $notas;

O que a Classe deve fazer?
- a classe deve receber nome, hemoglobina, booleano de urgencia, obseservações (deve ter tipo ?string).;
- se o valor de notas for nulo deve ser atribuido "sem notas do aparelho";
- a propriedade $urgencia recebe true ou false que vao ser substituidos por "CRITICO" ou "ROTINA".
- a hemoglobina deve receber a classificação "anemia", "alta" ou "normal".
- devolver uma string "Paciente: [NOME] | Nivel: [HEMOGLOBINA] ([CLASSIFICACAO]) | Prioridade: [URGENCIA] | Notas: [NOTAS]";

Quais as restrições?
- $notas não pode ser null; $urgencia não pode salvar o boolean;

Qual o resultado esperado final?
- Instanciar o objeto que receba:
    - $paciente (string),
    - $hemoglobina (float),
    - $urgencia (string)
        - deve receber "CRITICO" ou "ROTINA"
    -  $classificacao (string)
        - avaliar a hemoglobina e salvar "Anemia", "Alta" ou "Normal"
    -  $notas (string).
        - em caso de null deve receber por padrão "Sem notas do aparelho"

Qual a sequência de passos (algoritmo)?
1 - criar classe ResultadoExame com as propriedades privadas string $paciente, float $hemoglobina, string $urgencia, string $classificação e string $notas;
2. - criar metodo __construct que valide se $notas existem -> $notas ?? "Sem notas do aparelho"; se $urgencia for true deve receber "CRITICO" ou "ROTINA" em caso de false; se a classificação for < 12.0  deve receber "Anemia", ou se for > 17.5 deve receber "Alta" ou caso esteja fora dos parametros anteriores (else) deve receber "Normal".
3. - Criar metodo publico getRelatorio(): string que retorne "Paciente: [NOME] | Nivel: [HEMOGLOBINA] ([CLASSIFICACAO]) | Prioridade: [URGENCIA] | Notas: [NOTAS]"

*/

class ResultadoExame {
    private string $paciente;
    private float $hemoglobina;
    private string $urgencia;
    private string $classificacao;
    private ?string $notas;

    public function __construct(string $paciente, float $hemoglobina, bool $urgencia, ?string $notas) {
        $this->paciente = $paciente;
        $this->hemoglobina = $hemoglobina;

        $this->notas = $notas ??  "Sem notas do aparelho";

        $this->urgencia = $urgencia ?  "CRÍTICO" : "ROTINA";

        if ($hemoglobina < 12.0) {
            $this->classificacao = "Anemia";
        } else if ($hemoglobina > 17.5){   
            $this->classificacao = "Alta";
            } else {
        $this->classificacao = "Normal";
        }
    }

    public function getRelatorio(): string {

        return "Paciente: {$this->paciente} | Nivel: {$this->hemoglobina} ({$this->classificacao}) | Prioridade: {$this->urgencia} | Notas: {$this->notas}";
    }
}

// Teste 1: Paciente com Anemia, Urgente, e Sem Notas da máquina
$exame1 = new ResultadoExame("Carlos", 10.5, true, null);
echo "{$exame1->getRelatorio()} <br>";
// Esperado: Paciente: Carlos | Nivel: 10.5 (Anemia) | Prioridade: CRITICO | Notas: Sem notas do aparelho

// Teste 2: Paciente Normal, Não urgente, Com notas
$exame2 = new ResultadoExame("Julia", 14.2, false, "Leve desidratacao");
echo "{$exame2->getRelatorio()} <br>";
// Esperado: Paciente: Julia | Nivel: 14.2 (Normal) | Prioridade: ROTINA | Notas: Leve desidratacao