<?php
    
function marcarConsulta($medico_id, $horario, $patient_id, $appointment_data)
{
    // Acesso ao banco de dados - Presumindo que a variável $dbh esteja definida
    global $dbh;

    try {
        // Iniciar transação para garantir a consistência dos dados
        $stmt = $dbh->prepare('
            INSERT INTO Appointment (patient_id, doctor_id, time_block, appointment_date,report) 
            VALUES (?, ?, ?, ?,?)
        ');

        $stmt->execute(array($patient_id, $medico_id, $horario, $appointment_data,''));

    } catch (PDOException $e) {
        // Em caso de erro, retorna uma mensagem de erro
        return "Erro ao adicionar agendamento: " . $e->getMessage();
    }
}


?>