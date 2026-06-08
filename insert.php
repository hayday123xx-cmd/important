<?php

// الاتصال بقاعدة البيانات hotel
$conn = new mysqli("localhost", "root", "", "hotel");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

// استقبال البيانات (نفس خاصية name في الـ HTML)
$GuestID = $_POST['GuestID'];
$GuestName = $_POST['GuestName'];
$RoomType = $_POST['RoomType']; 
$CheckInDate = $_POST['CheckInDate'];
$CheckOutDate = $_POST['CheckOutDate'];

$formatted_checkin = date('Y-m-d', strtotime($CheckInDate));
$formatted_checkout = date('Y-m-d', strtotime($CheckOutDate));

// إدخال البيانات في جدول guests
$sql_guest = "INSERT INTO guests (GuestID, GuestName, PhoneNumber, CheckInDate, CheckOutDate, Guests) 
              VALUES ('$GuestID', '$GuestName', NULL, '$formatted_checkin', '$formatted_checkout', 1)";

if($conn->query($sql_guest) === TRUE){
    
    // البحث عن غرفة متاحة
    $room_query = "SELECT RoomNo FROM rooms WHERE RoomType = '$RoomType' AND Status = 'Available' LIMIT 1";
    $result = $conn->query($room_query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $RoomNo = $row['RoomNo']; 
        
        // إدخال الحجز في جدول bookings
        $current_date = date('Y-m-d');
        $sql_booking = "INSERT INTO bookings (GuestID, RoomNo, BookingDate, CheckInTime, CheckOutTime) 
                        VALUES ('$GuestID', '$RoomNo', '$current_date', '14:00:00', '12:00:00')";
        
        if($conn->query($sql_booking) === TRUE){
            // تحديث حالة الغرفة لـ محجوزة
            $conn->query("UPDATE rooms SET Status = 'Booked' WHERE RoomNo = $RoomNo");
            echo "Booking Saved Successfully. Room Assigned: " . $RoomNo;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Sorry, no available rooms.";
    }
} else {
    echo "Error saving guest profile: " . $conn->error;
}

$conn->close();
?>