function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    const descProfile = document.querySelector('.user-profile .desc-profile');
    const logo = document.querySelector('.toggle img');
    const toggle = document.querySelector('.toggle');

    sidebar.classList.toggle('open');

    if (sidebar.classList.contains('open')) {
        descProfile.style.opacity = '1';
        descProfile.style.display = 'block';

        logo.style.opacity = '1';
        logo.style.display = 'block';

        toggle.style.gap = '100px';
    } else {
        descProfile.style.opacity = '0';
        descProfile.style.display = 'none';

        logo.style.opacity = '0';
        logo.style.display = 'none';

        toggle.style.gap = '0px';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const replaceBtn = document.getElementById('replaceBtn');
    const imageUpload = document.getElementById('imageUpload');
    const patientPhoto = document.getElementById('patientPhoto');

    if (replaceBtn && imageUpload && patientPhoto) {
        replaceBtn.addEventListener('click', function (e) {
            e.preventDefault();
            imageUpload.click();
        });

        imageUpload.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    patientPhoto.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    } else {
        console.warn("One or more elements not found: replaceBtn, imageUpload, patientPhoto.");
    }
});

/*document.getElementById('replaceBtn').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('imageUpload').click();
});

document.getElementById('imageUpload').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('patientPhoto').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});*/
/*
const questions = {
    stressed: [
        {
            question: "How Often Have You Lost Interest Or Pleasure In Doing Things You Usually Enjoy?",
            options: [
                { text: "No (0)", points: 0 },
                { text: "Rarely (1)", points: 1 },
                { text: "Sometimes (2)", points: 2 },
                { text: "Often (3)", points: 3 },
                { text: "Always (4)", points: 4 }
            ]
        },
        {
            question: "How often have you felt down, depressed, or hopeless?",
            options: [
                { text: "No family history: (0 points)", points: 0 },
                { text: "One immediate family member: (1 point)", points: 1 },
                { text: "More than one immediate family member: (2 points)", points: 2 }
            ]
        },
        {
            question: "How Often Have You Lost Interest Or Pleasure In Doing Things You Usually Enjoy?",
            options: [
                { text: "No family history: (0 points)", points: 0 },
                { text: "One immediate family member: (2 point)", points: 2 },
                { text: "More than one immediate family member: (3 points)", points: 3 }
            ]
        },
    ],
    depressed: [
        {
            question: "How often do you feel sad or depressed?",
            options: [
                { text: "Never (0)", points: 0 },
                { text: "Sometimes (1)", points: 1 },
                { text: "Often (2)", points: 2 },
                { text: "Always (3)", points: 3 }
            ]
        },
    ],
    ocd: [
        {
            question: "How often do you feel the need to check things?",
            options: [
                { text: "Never (0)", points: 0 },
                { text: "Sometimes (1)", points: 1 },
                { text: "Often (2)", points: 2 },
                { text: "Always (3)", points: 3 }
            ]
        },
        {
            question: "Do you have intrusive thoughts that you can't control?",
            options: [
                { text: "Never (0)", points: 0 },
                { text: "Sometimes (1)", points: 1 },
                { text: "Often (2)", points: 2 },
                { text: "Always (3)", points: 3 }
            ]
        },
    ],
};*/
/*
let currentQuestionIndex = 0;
let currentQuiz = 'stressed';
let userResponses = [];

function startQuiz(quizType) {
    currentQuiz = quizType;
    currentQuestionIndex = 0;
    userResponses = [];
    removeResult();
    updateQuestion();
}

function updateQuestion() {
    const questionText = document.getElementById("question-text");
    const optionsContainer = document.getElementById("options-container");
    const questionNumber = document.getElementById("question-number");
    const quizTitle = document.getElementById("quiz-title");

    const quizQuestions = questions[currentQuiz];
    const currentQuestion = quizQuestions[currentQuestionIndex];
    questionText.textContent = currentQuestion.question;
    questionNumber.textContent = `From ${currentQuestionIndex + 1} Of ${quizQuestions.length}`;
    quizTitle.textContent = `Am I ${currentQuiz.charAt(0).toUpperCase() + currentQuiz.slice(1)}?`;

    optionsContainer.innerHTML = "";
    currentQuestion.options.forEach(option => {
        const label = document.createElement("label");
        const input = document.createElement("input");
        input.type = "radio";
        input.name = "answer";
        input.value = option.points;
        label.appendChild(input);
        label.append(option.text);
        optionsContainer.appendChild(label);
    });

    const progressText = document.getElementById("progress-text");
    const progressPercent = ((currentQuestionIndex + 1) / quizQuestions.length) * 100;
    progressText.textContent = `${Math.round(progressPercent)}%`;
    document.querySelector(".progress").style.width = `${progressPercent}%`;

    const nextButton = document.getElementById("nextButton");
    const prevButton = document.getElementById("prevButton");
    const showResultButton = document.getElementById("showResultButton");

    nextButton.style.display = currentQuestionIndex < quizQuestions.length - 1 ? 'block' : 'none';
    showResultButton.style.display = currentQuestionIndex === quizQuestions.length - 1 ? 'block' : 'none';
    prevButton.style.display = currentQuestionIndex === 0 ? 'none' : 'block';
}

function nextQuestion() {
    const selectedOption = document.querySelector('input[name="answer"]:checked');
    if (selectedOption) {
        userResponses[currentQuestionIndex] = parseInt(selectedOption.value);

        if (currentQuestionIndex < questions[currentQuiz].length - 1) {
            currentQuestionIndex++;
            updateQuestion();
        }
    } else {
        alert("Please select an option before proceeding.");
    }
}

function previousQuestion() {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        updateQuestion();
    }
}

function showResult() {
    const selectedOption = document.querySelector('input[name="answer"]:checked');
    if (selectedOption) {
        userResponses[currentQuestionIndex] = parseInt(selectedOption.value);
    }

    const resultDiv = document.getElementById("result");
    resultDiv.style.display = 'block';

    const totalScore = userResponses.reduce((sum, points) => sum + points, 0);
    console.log("Total Score:", totalScore);

    let resultMessage;
    if (totalScore <= 5) {
        resultMessage = "0-5: Low Risk; Congratulations on being in the low-risk category! Maintain a healthy lifestyle!";
    } else if (totalScore <= 10) {
        resultMessage = "6-10: Moderate Risk; It's recommended to assess your lifestyle and consult if necessary.";
    } else {
        resultMessage = "11+: High Risk; Consider seeking advice for maintaining mental well-being.";
    }
    resultDiv.textContent = resultMessage;

    const showResultButton = document.getElementById("showResultButton");
    showResultButton.disabled = true;
    showResultButton.style.pointerEvents = 'none';

    const prevButton = document.getElementById("prevButton");
    prevButton.style.display = 'none';
}

function removeResult() {
    const resultDiv = document.getElementById("result");
    resultDiv.style.display = 'none';
    resultDiv.textContent = '';

    const showResultButton = document.getElementById("showResultButton");
    showResultButton.disabled = false;
    showResultButton.style.pointerEvents = 'auto';
}

updateQuestion();
*/
