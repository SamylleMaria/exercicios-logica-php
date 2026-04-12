<?php
/*
O CONTEXTO - Validador de Laudos Médicos
O sistema recebe um laudo médico para ser publicado.
Se o laudo for da categoria "Biopsia", ele obrigatoriamente precisa ter a assinatura do médico preenchida.
Se for "Biopsia" e não tiver assinatura (ou a assinatura vier em branco), o sistema deve recusar a publicação informando o laboratório que a assinatura é obrigatória.
Para qualquer outra categoria, ou para biópsias devidamente assinadas, o sistema deve aprovar a publicação, retornando uma mensagem de sucesso que inclua o número de identificação daquele laudo.

O PAYLOAD
$dadosLaudo = [
    'id_exame' => 9942,
    'categoria' => 'Biopsia',
    'resultado_texto' => 'Material analisado sem alterações malignas evidentes',
    // 'assinatura_medico' => 'Dr. Roberto Souza - CRM 5544'
];


---------------------------------------------------------------

Resolução:
1.Quais os dados de entrada?
 - Entrada: array $dadosLaudo;

2.O que devo fazer com estes dados?
 - Validar os dados do array verificando se existe a chave 'categoria' com o valor 'Biopsia'. Em caso de 'Biopsia';
 - verificar se existe a chave 'assinatura_medico' e se ela está vazia.
 - Em caso de não existir ou esteja vazia ela deve ser rejeitada com um um alerta de "assinatura obrigatória".

3.Quais as restrições do problema?
 - Se 'categoria' => 'Biopsia' ela exige que exista a chave 'assinatura_medico' e não pode ser vazia.

4.Qual o resultado esperado?
 - Validar os laudos com Biopsia e recusar ou aprovar a publicação com uma mensagem JSON de alerta ou de sucesso incluindo o id do laudo.

5.Qual a sequência de passos (algoritmo) para chegar ao resultado?
- criar função validarLaudo(array $dadosLaudo) : string;
- informar que está enviando um JSON com header('Content-Type: application/json');
- validar se $dadosLaudo['categoria'] === 'Biopsia'.
    - Se verdadeiro, verificar com isset($dadosLaudo['assinatura_medico') existe e se ela é diferente de uma chave vazia;
        - Se falso deve retornar um http_response_code(400) com uma mensagem JSON informando que a assinatura é obrigatória;
        - Se verdadeiro ela vai retornar um http_response_code(200) com um JSON com uma mensagem de sucesso incluindo o $id_exame.
- Se diferente de Biopsia ela vai retornar um http_response_code(200) com um JSON com uma mensagem de sucesso incluindo o $id_exame.


*/

function validarLaudo(array $dadosLaudo): string {
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($dadosLaudo['categoria']) || $dadosLaudo['categoria'] ==='') {
        http_response_code(400);
        return json_encode(['mensagem' => 'A categoria do exame é obrigatória']);
        }
        
    if ($dadosLaudo['categoria'] === 'Biosia') {
        if (!isset($dadosLaudo['assinatura_medico']) || $dadosLaudo['assinatura_medico'] ==='') {
        http_response_code(400);
        return json_encode(['mensagem' => 'A assinatura do médio é obrigatória para Biopsia']);   
        }
    }

    http_response_code(400);
    $mensagem = "Exame ID:" . $dadosLaudo['id_exame'] . " Aprovado.";
    return json_encode(['mensagem' => $mensagem]);
}


$dadosLaudo = [
    'id_exame' => 9942,
    'categoria' => 'Biopsia',
    'resultado_texto' => 'Material analisado sem alterações malignas evidentes',
    'assinatura_medico' => 'Dr. Roberto Souza - CRM 5544'
];

echo validarLaudo($dadosLaudo);