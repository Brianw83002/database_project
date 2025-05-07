<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid access.');
}

$answers = $_POST['answers'] ?? [];
$correct = $_POST['correct'] ?? [];
$title   = htmlspecialchars($_POST['title'] ?? 'Unknown Quiz');

// Score calculation
$total    = count($correct);
$score    = 0;
$feedback = [];

foreach ($correct as $i => $correctAnswer) {
    $userAnswer = $answers[$i] ?? 'No Answer';

    $isCorrect = $userAnswer === $correctAnswer;
    if ($isCorrect) {
        $score++;
    }

    $feedback[] = [
        'question_number' => $i + 1,
        'your_answer'     => $userAnswer,
        'correct_answer'  => $correctAnswer,
        'is_correct'      => $isCorrect
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz Results</title>
  <link rel="stylesheet" href="../css/userPage.css"> <!-- Link to the external CSS file -->
</head>
<body>
  <div class="container">
    <h1>Quiz Results: <?= $title ?></h1>
    <h2>Your Score: <?= $score ?> / <?= $total ?></h2>
    <hr>

    <?php foreach ($feedback as $item): ?>
      <div class="<?= $item['is_correct'] ? 'correct' : 'wrong' ?>">
        <strong>Question <?= $item['question_number'] ?>:</strong><br>
        Your Answer: <?= htmlspecialchars($item['your_answer']) ?><br>
        Correct Answer: <?= htmlspecialchars($item['correct_answer']) ?><br><br>
      </div>
    <?php endforeach; ?>

    <!-- Go to User Page Button -->
    <button onclick="window.location.href='userPage.php';" class="button">Go to User Page</button>
  </div>
</body>
</html>
