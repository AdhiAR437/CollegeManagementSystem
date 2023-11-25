<?php
require '../vendor/autoload.php'; // Load PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to display the questions and answers
function displayQuestions($questions) {
    echo "<form method='post'>";
    foreach ($questions as $i => $question) {
        $options = array_slice($question, 1, 4);
        $questionText = $question[0];

        echo "<p><strong>Question " . ($i + 1) . ":</strong><br>$questionText</p>";

        foreach ($options as $key => $option) {
            $name = "answers[$i]";
            echo "<label><input type='radio' name='$name' value='$option'>$option</label><br>";
        }
    }
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</form>";
}

if (isset($_POST['selectedSet'])) {
    $selectedSet = $_POST['selectedSet'];
    $questionnaireFolder = 'questionnaire/';
    $selectedSetPath = $questionnaireFolder . $selectedSet;

    if (file_exists($selectedSetPath)) {
        $spreadsheet = IOFactory::load($selectedSetPath);
        $worksheet = $spreadsheet->getActiveSheet();

        $questions = [];

        foreach ($worksheet->getRowIterator(2) as $row) {
            $rowData = $row->getCellIterator();
            $question = [];
            foreach ($rowData as $cell) {
                $question[] = $cell->getValue();
            }

            $questions[] = $question;
        }

        if (isset($_POST['submit'])) {
            // If the form is submitted, display questions and answers
            echo "<html>
            <head>
                <style>
                    /* CSS styles here */
                </style>
            </head>
            <body>
                <h1>MCQ Quiz</h1>
                <div class='container'>
                    <h2>Selected Question Set: $selectedSet</h2>";

            displayQuestions($questions);

            // Display correct answers and explanations
            echo "<h3>Correct Answers and Explanations:</h3>";
            foreach ($questions as $i => $question) {
                $correctAnswer = $question[5]; // Assuming the correct answer is in the 6th column
                $explanation = $question[6]; // Assuming the explanation is in the 7th column
                echo "<p><strong>Question " . ($i + 1) . ":</strong><br>Correct Answer: $correctAnswer<br>Explanation: $explanation</p>";
            }

            echo "</div>
            </body>
            </html>";
        } else {
            // If the form is not yet submitted, display questions
            echo "<html>
            <head>
                <style>
                    /* CSS styles here */
                </style>
            </head>
            <body>
                <h1>MCQ Quiz</h1>
                <div class='container'>
                    <h2>Selected Question Set: $selectedSet</h2>";

            displayQuestions($questions);

            echo "</div>
            </body>
            </html>";
        }
    } else {
        echo "Selected question set not found.";
    }
} else {
    // Redirect back to the index page if accessed directly
    header("Location: index.php");
    exit;
}
?>
