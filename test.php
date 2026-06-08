<?php
// 1. تفعيل إظهار الأخطاء (اتركيها كما هي لتكشف لكِ أي خطأ فوراً بدلاً من الشاشة البيضاء)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// =================================================================
// 2. إعدادات الاتصال بالسيرفر وقاعدة البيانات
// =================================================================
$servername = "localhost"; // اتركيه كما هو دائماً
$username = "root";       // اتركيه كما هو دائماً في الـ XAMPP
$password = "";           // اتركيه فارغاً كما هو دائماً في الـ XAMPP

$dbname = "hotel"; 
// *** هنا اكتب اسم قاعدة البيانات التي أنشأتيها في phpMyAdmin بين العلامتين " " ***


// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التأكد من نجاح الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// =================================================================
// 3. استقبال البيانات من نموذج الـ HTML (الفورم)
// =================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $guestname = $_POST['guestname'];  
    // *** استبدلي 'guestname' بالاسم المكتوب في خانة (name) داخل ملف الـ HTML لحقل الاسم ***

    $room_type = $_POST['room_type'];  
    // *** استبدلي 'room_type' بالاسم المكتوب في خانة (name) داخل ملف الـ HTML لحقل نوع الغرفة ***

    $checkindate = $_POST['checkindate'];  
    // *** استبدلي 'checkindate' بالاسم المكتوب في خانة (name) داخل ملف الـ HTML لحقل تاريخ الدخول ***

    $checkoutdate = $_POST['checkoutdate'];  
    // *** استبدلي 'checkoutdate' بالاسم المكتوب في خانة (name) داخل ملف الـ HTML لحقل تاريخ المغادرة ***


// =================================================================
// 4. أمر إدخال البيانات في الجداول (SQL Query)
// =================================================================
    
    $sql = "INSERT INTO booking (guest_name, room_type, check_in, check_out)
            VALUES ('$guestname', '$room_type', '$checkindate', '$checkoutdate')";
            
    // *** ركّزي هنا جداً في الاختبار: ***
    // 1. استبدلي كلمة (booking) باسم الجدول المطلوب في قاعدة البيانات.
    // 2. استبدلي الكلمات (guest_name, room_type, check_in, check_out) بأسماء الأعمدة الفليّة داخل جدولك من الـ Structure في phpMyAdmin بالظبط.
    // 3. المتغيرات التي تبدأ بـ $ في سطر VALUES اتركها كما هي لأنها تحمل البيانات التي استقبلناها في الخطوة رقم 3.


// =================================================================
// 5. تنفيذ الأمر وطباعة النتيجة
// =================================================================
    if ($conn->query($sql) === TRUE) {
        // *** هنا تكتب الرسالة التي تريدين ظهورها للمستخدم عند نجاح الحفظ ***
        echo "<h2 style='color:green; text-align:center;'>🎉 تم حفظ البيانات بنجاح في قاعدة البيانات!</h2>";
    } else {
        // في حال حدوث خطأ (مثل Unknown column) سيطبع لكِ المشكلة هنا بالتفصيل
        echo "<h2 style='color:red; text-align:center;'>خطأ في الحفظ: " . $conn->error . "</h2>";
    }
}

// إغلاق الاتصال بعد الانتهاء
$conn->close();
?>





هنا الكود
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guestname = $_POST['guestname'];
    $room_type = $_POST['room_type'];
    $checkindate = $_POST['checkindate'];
    $checkoutdate = $_POST['checkoutdate'];

    $sql = "INSERT INTO booking (guest_name, room_type, check_in, check_out)
            VALUES ('$guestname', '$room_type', '$checkindate', '$checkoutdate')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2 style='color:green; text-align:center;'>🎉 Data saved successfully!</h2>";
    } else {
        echo "<h2 style='color:red; text-align:center;'>Error: " . $conn->error . "</h2>";
    }
}

$conn->close();
?>