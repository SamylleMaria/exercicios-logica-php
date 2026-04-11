<?php
/*
DESAFIO: Cálculo de Valor de Pedido de Exames

Contexto:
Uma API recebe um pedido de exames de um paciente no formato de array ($pedido).
Esse array pode conter as seguintes informações:

- 'cpf_paciente': string (pode conter caracteres como pontos, traços e espaços)
- 'exames': array com os valores de cada exame solicitado
- 'taxa_urgencia': valor opcional que pode ou não estar presente

Objetivo:
Implementar uma função que processe esse pedido e retorne uma resposta adequada em formato JSON.

Requisitos:

1. Normalizar o CPF do paciente, removendo todos os caracteres não numéricos.

2. Validar o CPF:
   - Se o CPF não possuir exatamente 11 dígitos, retornar:
     - HTTP Status 400 (Bad Request)
     - JSON com mensagem informando que o CPF é inválido

3. Se o CPF for válido:
   - Percorrer a lista de exames e somar os valores informados
   - Obter o valor da taxa de urgência:
     - Caso não exista, considerar como 0.00
   - Calcular o valor total do pedido (exames + taxa de urgência)

4. Retornar:
   - HTTP Status 200 (OK)
   - JSON contendo:
     - mensagem de sucesso
     - valor total calculado
*/



function calcularValorPedido(array $pedido): string {
    
    header('Content-Type: application/json');
 
    $valorTotalExames = 0;
    $taxaUrgencia = 0;
    
    if (!isset($pedido['cpf_paciente'])) {
        http_response_code(400);
        return json_encode(['mensagem' => 'CPF não informado']);
    }

    $cpf = $pedido['cpf_paciente'];
    $cpfLimpo = str_replace(['.', ',',' ', '-'],'', $cpf);

    if (strlen($cpfLimpo) !== 11) {
        http_response_code(400);
        return json_encode(['mensagem' => 'CPF inválido']);
    } 

    if (!isset($pedido['exames']) || !is_array($pedido['exames'])) {
    http_response_code(400);
    return json_encode(['mensagem' => 'Exame inválido']);            
    }
    foreach ($pedido['exames'] as $exame) {
        $valorTotalExames += $exame['valor'];
    }

    $taxaUrgencia += $pedido['taxa_urgencia'] ?? 0.00;
    $valorTotalExames += $taxaUrgencia;
    
    http_response_code(200);

    return json_encode(['mensagem' => 'Pedido válido', 'valor' => $valorTotalExames]);

}

$pedidoMock = [
    'cpf_paciente' => '111.222.333-44', 
    'exames' => [
        ['nome' => 'Hemograma', 'valor' => 15.50],
        ['nome' => 'Glicemia', 'valor' => 10.00]
    ],
    'taxa_urgencia' => 50.00 
];


echo calcularValorPedido($pedidoMock);