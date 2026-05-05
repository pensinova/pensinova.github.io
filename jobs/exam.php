<?php
include 'connection.php';

/* ===============================
   LOAD JSON
=================================*/
$data = file_get_contents('data/exams.json');
$exams = json_decode($data, true);

$position   = $_GET['position'] ?? null;
$testNo     = isset($_GET['exam']) ? (int)$_GET['exam'] : 0;
$questionNo = isset($_GET['question']) ? (int)$_GET['question'] : 0;

$ex  = null;
$test = null;
$qn   = null;

/* ===============================
   FIND POSITION
=================================*/
if ($position) {
    foreach ($exams as $e) {
        if ($e['position'] === $position) {
            $ex = $e;
            break;
        }
    }
}

/* ===============================
   GET EXAM + QUESTION
=================================*/
if ($ex && isset($ex['exams'][$testNo])) {
    $test = $ex['exams'][$testNo]; // array of questions
    if (isset($test[$questionNo])) {
        $qn = $test[$questionNo];
    }
}

$totalQuestions = $test ? count($test) : 0;

// Get correct answer index
$correctIndex = null;
foreach ($qn['options'] ?? [] as $i => $opt) {
    if (str_ends_with($opt, 'Correct')) {
        $correctIndex = $i;
        break;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pensinova Jobs - Test</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include 'components/header.php'; ?>
<div class="container py-3">

<h4 class="text-center mb-4">
    <?php echo ucfirst($position); ?> - Test <?php echo $testNo + 1; ?>
</h4>

<?php if ($qn): ?>

<div class="card shadow rounded-4">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <span class="fw-bold">
                Question <?php echo $questionNo + 1; ?> / <?php echo $totalQuestions; ?>
            </span>
            <span class="text-muted">
                Marks: <?php echo $qn['marks']; ?>
            </span>
        </div>

        <p class="fw-semibold"><?php echo $qn['question']; ?></p>

        <form id="answerForm">

            <!-- Hidden inputs -->
            <input type="hidden" id="position" name="position" value="<?php echo $position; ?>">
            <input type="hidden" id="exam" name="exam" value="<?php echo $testNo; ?>">
            <input type="hidden" id="marks" name="marks" value="<?php echo $qn['marks']; ?>">
            <input type="hidden" id="question" name="question" value="<?php echo $questionNo; ?>">
            <input type="hidden" id="correct_answer" name="correct_answer" value="<?php echo $correctIndex; ?>">

            <?php foreach ($qn['options'] as $index => $option): ?>
            <div class="form-check mb-2">
                <input class="form-check-input"
                       type="radio"
                       name="answer"
                       value="<?php echo $index; ?>"
                       id="option<?php echo $index; ?>">
                <label class="form-check-label" for="option<?php echo $index; ?>">
                    <?php echo str_ends_with($option, 'Correct') ? substr($option, 0, -7) : $option; ?>
                </label>
            </div>
            <?php endforeach; ?>

            <div class="card border-1 mt-4 mb-3 p-3" id="answer_section" style="display: none;">
               <div class="card-body">
                    <h4>Results</h4>
                    <p id="answer_result"></p>
               </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <?php if ($questionNo > 0): ?>
                <a href="?position=<?php echo $position; ?>&exam=<?php echo $testNo; ?>&question=<?php echo $questionNo - 1; ?>" class="btn btn-secondary rounded-pill">
                    Previous
                </a>
                <?php else: ?>
                <span></span>
                <?php endif; ?>

                <button type="button" class="btn btn-success rounded-pill fw-bold" id="get_answer_btn" disabled>Get Answer</button>

                <?php if ($questionNo < $totalQuestions - 1): ?>
                <button type="button" class="btn btn-primary rounded-pill" id="nextBtn" disabled>Next</button>
                <?php else: ?>
                <a href="finish.php" class="btn btn-success rounded-pill">Finish Exam</a>
                <?php endif; ?>
            </div>

        </form>

    </div>
</div>

<?php else: ?>
<div class="alert alert-danger text-center">
    Question not found.
</div>
<?php endif; ?>

</div>
<?php include 'components/footer.php'; ?>

<script>
const form = document.getElementById('answerForm');
const nextBtn = document.getElementById('nextBtn');
const getAnswerBtn = document.getElementById('get_answer_btn');
const answerSection = document.getElementById('answer_section');
const answerResult = document.getElementById('answer_result');

// Check if already answered
function checkAnswered() {
    const stored = JSON.parse(localStorage.getItem('answers')) || [];
    const currentQuestion = form.querySelector('#question').value;
    const currentExam = form.querySelector('#exam').value;
    const currentPosition = form.querySelector('#position').value;
    const correctAnswer = form.querySelector('#correct_answer').value;

    const existingAnswer = stored.find(a =>
        a.question == currentQuestion &&
        a.exam == currentExam &&
        a.position == currentPosition
    );

    if (existingAnswer) {
        // Pre-check option
        const option = form.querySelector(`input[name="answer"][value="${existingAnswer.answer}"]`);
        if (option) option.checked = true;
        getAnswerBtn.disabled = false;

            answerSection.style.display = 'block';
        nextBtn.disabled = false;
        getAnswerBtn.disabled = true;

        const options = form.querySelectorAll('input[name="answer"]');
        options.forEach(o => o.disabled = true);

        if (existingAnswer.answer === correctAnswer) {
            answerSection.className = 'card border-1 mt-4 mb-3 p-3 bg-success text-light';
            answerResult.innerHTML = `
                <strong>Congratulations! You got it right!</strong><br>
                Correct answer: ${form.querySelector(`label[for="option${correctAnswer}"]`).textContent.trim()}<br>
                <strong>Marks: ${existingAnswer.marks}</strong>`;
        } else {
            answerSection.className = 'card border-1 mt-4 mb-3 p-3 bg-danger text-light';
            answerResult.innerHTML = `
                <strong>Sorry, that's incorrect.</strong><br>
                Your answer: ${form.querySelector(`label[for="option${existingAnswer.answer}"]`).textContent.trim()}<br>
                Correct answer: ${form.querySelector(`label[for="option${correctAnswer}"]`).textContent.trim()}<br>
                <strong>Marks: 0</strong>`;
        }
    }
}
document.addEventListener('DOMContentLoaded', checkAnswered);

// Save answer on change
form.addEventListener('change', function() {
    const answer = form.querySelector('input[name="answer"]:checked')?.value;
    if (!answer) {
        getAnswerBtn.disabled = true;
        return;
    }
    getAnswerBtn.disabled = false;

    const currentQuestion = form.querySelector('#question').value;
    const currentExam = form.querySelector('#exam').value;
    const currentPosition = form.querySelector('#position').value;
    const correctAnswer = form.querySelector('#correct_answer').value;
    const marks = form.querySelector('#marks').value;

    const stored = JSON.parse(localStorage.getItem('answers')) || [];
    const idx = stored.findIndex(a =>
        a.question == currentQuestion &&
        a.exam == currentExam &&
        a.position == currentPosition
    );

    const answerObj = {
        question: currentQuestion,
        answer: answer,
        correctAnswer: correctAnswer,
        position: currentPosition,
        exam: currentExam,
        marks: marks
    };

    if (idx !== -1) stored[idx] = answerObj;
    else stored.push(answerObj);

    localStorage.setItem('answers', JSON.stringify(stored));
});

// Get answer button
getAnswerBtn.addEventListener('click', function() {
    const answer = form.querySelector('input[name="answer"]:checked')?.value;
    const currentQuestion = form.querySelector('#question').value;
    const currentExam = form.querySelector('#exam').value;
    const currentPosition = form.querySelector('#position').value;
    const correctAnswer = form.querySelector('#correct_answer').value;

    const stored = JSON.parse(localStorage.getItem('answers')) || [];
    const existingAnswer = stored.find(a =>
        a.question == currentQuestion &&
        a.exam == currentExam &&
        a.position == currentPosition
    );

    if (!existingAnswer) return;

    answerSection.style.display = 'block';
    nextBtn.disabled = false;
    getAnswerBtn.disabled = true;

    const options = form.querySelectorAll('input[name="answer"]');
    options.forEach(o => o.disabled = true);

    if (existingAnswer.answer === correctAnswer) {
        answerSection.className = 'card border-1 mt-4 mb-3 p-3 bg-success text-light';
        answerResult.innerHTML = `
            <strong>Congratulations! You got it right!</strong><br>
            Correct answer: ${form.querySelector(`label[for="option${correctAnswer}"]`).textContent.trim()}<br>
            <strong>Marks: ${existingAnswer.marks}</strong>`;
    } else {
        answerSection.className = 'card border-1 mt-4 mb-3 p-3 bg-danger text-light';
        answerResult.innerHTML = `
            <strong>Sorry, that's incorrect.</strong><br>
            Your answer: ${form.querySelector(`label[for="option${existingAnswer.answer}"]`).textContent.trim()}<br>
            Correct answer: ${form.querySelector(`label[for="option${correctAnswer}"]`).textContent.trim()}<br>
            <strong>Marks: 0</strong>`;
    }
});

// Next button
nextBtn.addEventListener('click', function() {
    const question = parseInt(form.querySelector('#question').value);
    const exam = form.querySelector('#exam').value;
    const position = form.querySelector('#position').value;
    const nextQuestionNo = question + 1;
    window.location.href = `exam.php?position=${position}&exam=${exam}&question=${nextQuestionNo}`;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>