<?php 
/** 
 * FILE: index.php 
 * FUNGSI: Controller utama yang menangani semua request 
 */ 
 
// Include file yang diperlukan 
require_once 'config/database.php'; 
require_once 'models/EmployeeModel.php'; 
 
// Inisialisasi database dan model 
$database = new Database(); 
$db = $database->getConnection(); 
$employeeModel = new EmployeeModel($db); 
 
// Tangani action dari URL 
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
 
switch ($action) { 
    case 'dashboard': 
        $dashboard = $employeeModel->getDashboardSummary(); 
        include 'views/dashboard.php'; 
        break; 
 
    case 'list': 
        $employees = $employeeModel->getAllEmployees(); 
        include 'views/employee_list.php'; 
        break; 
 
    case 'create': 
        if ($_POST) { 
            // Proses form submission 
            $data = [ 
                'first_name' => $_POST['first_name'], 
                'last_name' => $_POST['last_name'], 
                'email' => $_POST['email'], 
                'department' => $_POST['department'], 
                'position' => $_POST['position'], 
                'salary' => $_POST['salary'], 
                'hire_date' => $_POST['hire_date'] 
            ]; 
             
            if ($employeeModel->createEmployee($data)) { 
                header("Location: index.php?action=list&message=created"); 
            } else { 
                $error = "Gagal menambah karyawan"; 
            } 
        } 
        include 'views/employee_form.php'; 
        break; 
 
    case 'edit': 
        $id = $_GET['id']; 
         
        if ($_POST) { 
            $data = [ 
                'first_name' => $_POST['first_name'], 
                'last_name' => $_POST['last_name'], 
                'email' => $_POST['email'], 
                'department' => $_POST['department'], 
                'position' => $_POST['position'], 
                'salary' => $_POST['salary'], 
                'hire_date' => $_POST['hire_date'] 
            ]; 
             
            if ($employeeModel->updateEmployee($id, $data)) { 
                header("Location: index.php?action=list&message=updated"); 
            } else { 
                $error = "Gagal mengupdate karyawan"; 
            } 
        } 
        $employee = $employeeModel->getEmployeeById($id); 
        include 'views/employee_form.php'; 
        break; 
 
    case 'delete': 
        $id = $_GET['id']; 
        if ($employeeModel->deleteEmployee($id)) { 
            header("Location: index.php?action=list&message=deleted"); 
        } else { 
            header("Location: index.php?action=list&message=delete_error"); 
        } 
        break; 
 
    case 'department_stats': 
        $stats = $employeeModel->getDepartmentStats(); 
        include 'views/department_stats.php'; 
        break; 

    case 'salary_stats':
        $query = $db->prepare("SELECT * FROM salary_stats ORDER BY department");
        $query->execute();
        $stats = $query;
        include 'views/salary_stats.php';
        break;
    
    case 'tenure_stats':
        $query = $db->prepare("SELECT * FROM tenure_stats ORDER BY level_kerja");
        $query->execute();
        $stats = $query;
        include 'views/tenure_stats.php';
        break;

    case 'employee_overview':
        $query = $db->prepare("SELECT * FROM employee_overview");
        $query->execute();
        $stats = $query;
        include 'views/employee_overview.php';
        break;
        
    case 'refresh': 
        $employeeModel->refreshDashboard(); 
        header("Location: index.php?action=dashboard&message=refreshed"); 
        break; 
 
    default: 
        $dashboard = $employeeModel->getDashboardSummary(); 
        include 'views/dashboard.php'; 
        break; 
} 
?>        