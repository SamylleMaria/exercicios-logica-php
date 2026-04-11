<?php
/*
O Contexto:
O laboratório precisa gerar a etiqueta do tubo de ensaio de um paciente. O sistema precisa garantir que o paciente tem um convênio médico válido cadastrado antes de imprimir.

O Payload de Entrada:
$dadosPaciente = [
    'nome' => 'Maria Silva',
    'ano_nascimento' => 1985,
    'convenios' => [
        'Unimed',
        'Bradesco Saude'
    ],
    'exame_solicitado' => 'Hemograma Completo'
];

Regras de Negócio (O que deve acontecer):

O laboratório só atende pacientes que tenham pelo menos um convênio na sua lista de convênios. 
Se a pessoa não tiver convênio, a API tem que barrar a operação imediatamente, respondendo que deu um erro do lado do cliente e enviando uma mensagem JSON clara: "Paciente sem convenio ativo".
Se a pessoa tiver convênio aprovado, a API deve devolver uma mensagem de sucesso JSON com os dados para a impressora: "Etiqueta liberada para Maria Silva".


---------------------------------------------------------------

Resolução:
1.Quais os dados de entrada?
 - array $dadosPaciente;

2.O que devo fazer com estes dados?
 - validar se o paciente tem um convenio válido;

3.Quais as restrições do problema?
 - precisa ter pelo menos um convenio válido;

4.Qual o resultado esperado?
 - Se o paciente não tiver convenio: barrar a operação devolvendo um JSON com a mensagem "Paciente sem convênio ativo"; Se tiver convenio válido: devolver um JSON com a mensagem de sucesso "Etiqueta liberada para $dadosPaciente['nome']".

5.Qual a sequência de passos (algoritmo) para chegar ao resultado?
 - Criar a função gerarEtiqueta(array $dadosPaciente) : string;
 - header('Content-Type: application/json') informando que será enviado um JSON;
 - Validar se $dadosPaciente['convenios'] não está vazia;
 - Se vazia: retornar a resposta http 400 e um json_encode com a mensagem "Paciente sem convênio ativo";
 - Se há dados: retornar a resposta http 200 e um json_encode com a mensagem "Etiqueta liberada para $dadosPaciente['nome']".

*/


function gerarEtiqueta(array $dadosPaciente) : string {
    header('Content-Type: application/json; charset=utf-8');
    
    if (!isset($dadosPaciente['convenios']) || $dadosPaciente['convenios'] === []) {
        http_response_code(400);
        return json_encode(['mensagem' => 'Paciente sem convênio ativo']);
    } else {
        http_response_code(200);
        $resposta = "Etiqueta liberada para " . $dadosPaciente['nome'];
        return json_encode(['mensagem' => $resposta]);
    }


}

$dadosPaciente = [
    'nome' => 'Maria Silva',
    'ano_nascimento' => 1985,
    'convenios' => [
        // 
    ],
    'exame_solicitado' => 'Hemograma Completo'
];

echo gerarEtiqueta($dadosPaciente);
