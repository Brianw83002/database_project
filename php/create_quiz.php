<?php
// create_quiz.php
// Handles POST from create_quiz.html

require_once 'connect.php'; // ✅ Include the connection function
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}
$conn = getDBConnection("quizdb"); // Pass your target DB name

// Get title (shared for all questions)
$title = trim($_POST['title'] ?? '');

// 2) Get question data from POST
$questions       = $_POST['question']        ?? [];
$correct_answers = $_POST['correct_answer']  ?? [];
$wrong1          = $_POST['wrong_answer1']   ?? [];
$wrong2          = $_POST['wrong_answer2']   ?? [];
$wrong3          = $_POST['wrong_answer3']   ?? [];

// 3) Prepare insert statement (matches new table structure)
$insertQ = $conn->prepare("
    INSERT INTO quiz_questions
      (title, question_text, correct_answer,
       wrong_answer1, wrong_answer2, wrong_answer3)
    VALUES (?, ?, ?, ?, ?, ?)
");

// 4) Insert each question
foreach ($questions as $i => $qtext) {
    $q  = trim($qtext);
    $c  = trim($correct_answers[$i] ?? '');
    $w1 = trim($wrong1[$i] ?? '');
    $w2 = trim($wrong2[$i] ?? '');
    $w3 = trim($wrong3[$i] ?? '');

    // Skip empty/incomplete questions
    if ($title === '' || $q === '' || $c === '' || $w1 === '' || $w2 === '' || $w3 === '') {
        continue;
    }

    $insertQ->bind_param('ssssss', $title, $q, $c, $w1, $w2, $w3);
    $insertQ->execute();
}
// 5) Cleanup
$insertQ->close();
$conn->close();
// 6) Redirect to display page or confirmation
header("Location: display_quiz.php");
exit;
?>
