<?php
// functions.php
require_once 'database_config.php';

// User registration
function registerUser($name, $email, $password) {
    global $conn;
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return ['success' => false, 'message' => 'Email already registered'];
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        return ['success' => true, 'user_id' => $conn->insert_id];
    } else {
        return ['success' => false, 'message' => 'Registration failed'];
    }
}

// User login
function loginUser($email, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return ['success' => true, 'user' => $user];
        }
    }
    
    return ['success' => false, 'message' => 'Invalid email or password'];
}

// Get all cars with optional filters
function getCars($type = 'all', $fuel = 'all', $brand = 'all', $min_price = 0, $max_price = 1000) {
    global $conn;
    
    $sql = "SELECT * FROM cars WHERE price BETWEEN ? AND ?";
    $params = [$min_price, $max_price];
    $types = "dd";
    
    if ($type != 'all') {
        $sql .= " AND type = ?";
        $params[] = $type;
        $types .= "s";
    }
    
    if ($fuel != 'all') {
        $sql .= " AND fuel = ?";
        $params[] = $fuel;
        $types .= "s";
    }
    
    if ($brand != 'all') {
        $sql .= " AND brand = ?";
        $params[] = $brand;
        $types .= "s";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cars = [];
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
    
    return $cars;
}

// Get single car by ID
function getCarById($id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

// Create booking
function createBooking($user_id, $car_id, $renter_name, $email, $start_date, $end_date) {
    global $conn;
    
    // Get car details
    $car = getCarById($car_id);
    if (!$car) {
        return ['success' => false, 'message' => 'Car not found'];
    }
    
    // Calculate days and total price
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $days = $start->diff($end)->days;
    if ($days <= 0) $days = 1;
    
    $total_price = $days * $car['price'];
    $car_name = $car['brand'] . ' ' . $car['model'];
    
    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, car_id, car_name, renter_name, email, start_date, end_date, total_days, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssid", $user_id, $car_id, $car_name, $renter_name, $email, $start_date, $end_date, $days, $total_price);
    
    if ($stmt->execute()) {
        $booking_id = $conn->insert_id;
        
        // Log email confirmation
        logEmail($email, "Booking Confirmation", "Your booking for $car_name from $start_date to $end_date is confirmed. Total: $$total_price");
        
        return ['success' => true, 'booking_id' => $booking_id, 'total' => $total_price];
    } else {
        return ['success' => false, 'message' => 'Booking failed'];
    }
}

// Get user bookings
function getUserBookings($user_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    
    return $bookings;
}

// Log email
function logEmail($recipient, $subject, $message) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO email_logs (recipient, subject, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $recipient, $subject, $message);
    $stmt->execute();
}

// Get email logs
function getEmailLogs($limit = 10) {
    global $conn;
    
    $result = $conn->query("SELECT * FROM email_logs ORDER BY sent_at DESC LIMIT $limit");
    
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    
    return $logs;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ];
    }
    return null;
}
?>
