<?php
require_once 'connect.php'; // ✅ Include the connection function
$conn = getDBConnection("quizdb"); // Pass your target DB name

$sql = "SELECT title, question_text, correct_answer, wrong_answer1, wrong_answer2, wrong_answer3 FROM quiz_questions ORDER BY title";
$result = $conn->query($sql);

$quizzes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quizzes[$row['title']][] = $row;
    }
} else {
    echo "No quizzes found.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Take Quiz</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .quiz { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; }
    .question { margin-bottom: 15px; }
    button {
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <h1>Take a Quiz</h1>

  <?php foreach ($quizzes as $title => $questions): ?>
    <form action="submit_quiz.php" method="post" class="quiz">
      <h2><?php echo htmlspecialchars($title); ?></h2>
      <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">

      <?php foreach ($questions as $index => $q): ?>
        <?php
          // Shuffle options
          $options = [
            $q['correct_answer'],
            $q['wrong_answer1'],
            $q['wrong_answer2'],
            $q['wrong_answer3']
          ];
          shuffle($options);
        ?>
        <div class="question">
          <p><strong>Q<?= $index + 1 ?>:</strong> <?php echo htmlspecialchars($q['question_text']); ?></p>
          <?php foreach ($options as $opt): ?>
            <label>
              <input type="radio" name="answers[<?= $index ?>]" value="<?= htmlspecialchars($opt) ?>" required>
              <?= htmlspecialchars($opt) ?>
            </label><br>
          <?php endforeach; ?>
          <input type="hidden" name="correct[<?= $index ?>]" value="<?= htmlspecialchars($q['correct_answer']) ?>">
        </div>
      <?php endforeach; ?>

      <button type="submit">Submit Quiz</button>
    </form>
  <?php endforeach; ?>

  <!-- Go to User Page Button -->
  <button onclick="window.location.href='../php/userPage.php';">Go to User Page</button>
</body>
</html>
