<?php
session_start();

// get input from HTTP parameters
$input = $_POST['search'];
$role = $_POST['role'];

// check if name or email are correct
function searchSuccess($input, $role)
{
  global $dbh;

  switch ($role) {
    case 'Paciente':
        $query = 'SELECT * FROM Person 
                  JOIN Patient ON Person.person_id = Patient.patient_id 
                  WHERE name LIKE ? OR email_address LIKE ?';
        break;

    case 'Enfermeiro(a)': 
        $query = 'SELECT * FROM Person 
                  JOIN Employee ON Person.person_id = Employee.employee_id 
                  JOIN Nurse ON Employee.employee_id = Nurse.employee_id 
                  WHERE name LIKE ? OR email_address LIKE ?';
        break;

    case 'Secretário(a)':
        $query = 'SELECT * FROM Person 
                  JOIN Employee ON Person.person_id = Employee.employee_id 
                  JOIN Secretary ON Employee.employee_id = Secretary.employee_id 
                  WHERE name LIKE ? OR email_address LIKE ?';
        break;

    case 'Admin': 
        $query = 'SELECT * FROM Person 
                  JOIN Employee ON Person.person_id = Employee.employee_id 
                  JOIN Admin ON Employee.employee_id = Admin.employee_id 
                  WHERE name LIKE ? OR email_address LIKE ?';
        break;
    }
    $stmt = $dbh->prepare($query);
    $stmt->execute(array('%' . $search . '%', '%' . $search . '%'));
    return $stmt->fetchAll();
}


try {

    $dbh = new PDO('sqlite:../sql/database.db');
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $userData = searchSuccess($input, $role);
    
    if ($userData) {
        $_SESSION['search_results'] = $userData; 
    } else {
        $_SESSION['search_results'] = [];
    }

} catch (PDOException $e) {
    // Handle errors
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
    header('Location: ../profile_template.php'); // Go back to the template with the error message
    exit();
}

header('Location: ../loginpage.php');
