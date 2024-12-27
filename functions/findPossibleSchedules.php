<?php
    function findPossibleSchedules($data,$timestamps) {
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




