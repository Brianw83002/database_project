
<?php
// create_quiz.php
// Handles POST from create_quiz.html

// 1) Database connection — adjust these to your credentials:
$servername = "127.0.0.1";  // or "localhost"
$username = "root";         // MySQL username
$password = "18245Bw!"; // MySQL password
$dbname = "users";  // The database you want to connect to (e.g., "users")

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('DB Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

// 2) Get & validate quiz title
$quiz_title = trim($_POST['quiz_title'] ?? '');
if ($quiz_title === '') {
    die('Quiz title is required.');
}

// 3) Create a new quiz record
$stmt = $conn->prepare("
    INSERT INTO quizzes (title, created_at)
    VALUES (?, NOW())
");
$stmt->bind_param('s', $quiz_title);
$stmt->execute();
$quiz_id = $stmt->insert_id;
$stmt->close();

// 4) Prepare insertion of each question
$insertQ = $conn->prepare("
    INSERT INTO quiz_questions
      (quiz_id, question_text, correct_answer,
       wrong_answer1, wrong_answer2, wrong_answer3,
       question_order)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

// 5) Loop through posted question blocks
$questions       = $_POST['question']        ?? [];
$correct_answers = $_POST['correct_answer']  ?? [];
$wrong1          = $_POST['wrong_answer1']   ?? [];
$wrong2          = $_POST['wrong_answer2']   ?? [];
$wrong3          = $_POST['wrong_answer3']   ?? [];

foreach ($questions as $i => $qtext) {
    $q  = trim($qtext);
    $c  = trim($correct_answers[$i] ?? '');
    $w1 = trim($wrong1[$i]          ?? '');
    $w2 = trim($wrong2[$i]          ?? '');
    $w3 = trim($wrong3[$i]          ?? '');
    $order = $i + 1;

    // Basic validation
    if ($q === '' || $c === '' || $w1 === '' || $w2 === '' || $w3 === '') {
        continue; // skip incomplete blocks
    }

    $insertQ->bind_param(
        'isssssi',
        $quiz_id, $q, $c, $w1, $w2, $w3, $order
    );
    $insertQ->execute();
}

$insertQ->close();
$conn->close();

// 6) Redirect to the quiz display page
header("Location: display_quiz.html?quiz_id={$quiz_id}");
exit;
?>