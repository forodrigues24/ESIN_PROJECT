<?php
function findPossibleSchedules($data, $timestamps)
{
    $grouped = [];
    foreach ($data as $entry) {
        $id = $entry['id']; // ID do médico
        $horario = $entry['horario']; // Horário do médico
        $entrada = $entry['entrada']; // Hora de entrada
        $saida = $entry['saida']; // Hora de saída

        // Verifica se já existe uma entrada para esse id
        if (!isset($grouped[$id])) {
            // Inicializa o médico com suas informações
            $grouped[$id] = [
                'nome' => $entry['nome'],
                'especialidade' => $entry['especialidade'],
                'entrada' => $entrada,  // Mantém a entrada
                'saida' => $saida,      // Mantém a saída
                'horarios' => [], // Inicializa a lista de horários
                'horarios_possiveis' => [] // Inicializa a lista de horários possíveis
            ];
        }

        // Adiciona o horário na lista de horários do médico
        $grouped[$id]['horarios'][] = $horario;

        // Filtra os horários possíveis (horários entre entrada e saída)
        foreach ($timestamps as $timestamp) {
            $available_time = $timestamp['time_block'];

            // Verifica se o horário está entre a entrada e saída do médico
            if ($available_time >= $entrada && $available_time <= $saida) {
                // Verifica se o horário disponível não está na lista de horários já ocupados
                if (!in_array($available_time, $grouped[$id]['horarios'])) {
                    $grouped[$id]['horarios_possiveis'][] = $available_time;
                }
            }
        }

        // Agora, removemos os horários ocupados da lista de horários possíveis
        $grouped[$id]['horarios_possiveis'] = array_diff($grouped[$id]['horarios_possiveis'], $grouped[$id]['horarios']);
    }

    return $grouped;
}

function findPossibleSchedulesNurse($id,$data)
{
    $dados = consultasSemEnfermeira($data);
    $consultas_marcadas = obterConsultasPorIdData($id, $data);
    $horario = obterHorarioIdData($id, $data);

    if (empty($horario) || !isset($horario[0]['Entrada'], $horario[0]['Saida'])) {
        $_SESSION['msg'] ='Horário não disponível. Contacte a secretária.';
        header('Location: ../enfermeira.php');
    }

    // Horário de entrada e saída
    $horaEntrada = $horario[0]['Entrada'];
    $horaSaida = $horario[0]['Saida'];

    // Filtrar as consultas dentro do horário de trabalho
    $dadosFiltrados = [];
    foreach ($dados as $consulta) {
        // Considera apenas consultas dentro do horário de trabalho
        if ($consulta['time'] >= $horaEntrada && $consulta['time'] <= $horaSaida) {
            $dadosFiltrados[] = $consulta;
        }
    }


    // Obter horários das consultas já marcadas, agora verificando o valor correto
    $horariosConsultasMarcadas = [];
    foreach ($consultas_marcadas as $consulta) {
        // Assumindo que 'HorarioInicio' é o campo que contém o horário
        $horariosConsultasMarcadas[] = $consulta['time'];
    }

    // Filtrar consultas que não conflitam com as já marcadas
    $dadosFiltradosSemConflitos = [];
    foreach ($dadosFiltrados as $consulta) {
        if (!in_array($consulta['time'], $horariosConsultasMarcadas)) {
            $dadosFiltradosSemConflitos[] = $consulta;
        }
    }

    // Armazenar na sessão
    $_SESSION['consultas_sem_enfermeira'] = $dadosFiltradosSemConflitos;
    $_SESSION['consultas_da_enfermeira'] = $consultas_marcadas;
}
