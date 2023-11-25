<!DOCTYPE html>
<html>
<head>
    <title>Select Question Set</title>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <h1>Select Question Set</h1>
    <div class='container'>
        <form method='post' action='question2.php'>
            <select name='selectedSet'>
                <option value='' disabled selected>Select a question set</option>
                <?php
                $questionnaireFolder = 'questionnaire/';
                $questionSetFiles = scandir($questionnaireFolder);
                foreach ($questionSetFiles as $file) {
                    if ($file !== '.' && $file !== '..') {
                        echo "<option value='$file'>$file</option>";
                    }
                }
                ?>
            </select>
            <input type='submit' value='Load Question Set'>
        </form>
    </div>
</body>
</html>
