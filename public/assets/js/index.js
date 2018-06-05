(function() {

    "use strict";


    let questions = [];
    let answers = {};
    let lastInput = "";
    // Workaround for correct table stripes (1/4)
    let nthStripe = 1;


    /* cache DOM */
    const $filterInput = document.querySelector("#iws-filter-input");
    const $questionTable = document.querySelector("#iws-question-table");
    const $questionCells = $questionTable.querySelectorAll(".iws-question-cell");


    /* parse table */
    $questionCells.forEach(function($cell) {
        let $questionWrapper = $cell.querySelector(".iws-question");

        questions.push({
            "text": $questionWrapper.innerText,
            "$element": $questionWrapper,
            "$row": $cell.parentNode,
            "visible": true
        });

        // bind event here instead of the "bind events" section for optimization purposes
        $cell.addEventListener("click", _toggleAnswers);
    });
    

    /* bind events */
    $filterInput.addEventListener("keyup", _filterQuestions);
    // clear the input field
    $filterInput.value = "";


    function _filterQuestions() {
        let input = $filterInput.value.trim().toLowerCase();

        if (input === lastInput) {
            return false;
        }

        // Workaround for correct table stripes (2/4)
        $questionTable.classList.remove("table-striped");

        lastInput = input;

        questions.forEach(function (question) {
            question.visible = question.text.toLowerCase().indexOf(input) > -1;

            _render(question);
        });

        // Workaround for correct table stripes (3/4)
        nthStripe = 1;
    }

    function _render(question) {
        if (question.visible) {
            question.$row.classList.remove("iws-hidden");

            
            if (lastInput === "") {
                // No highlight, if input field is empty
                question.$element.innerHTML = _nl2br(question.text);
            } else {
 
                // Mask special characters like dots and parentheses
                let masked = lastInput.replace(/([\.\[\]\(\)])/g, "\\$1");
                // Highlight filtered text
                let regexp = RegExp("(" + masked + ")", "ig");
                let highlight = "<b>$1</b>";
                question.$element.innerHTML = _nl2br(question.text.replace(regexp, highlight));
            }

            // Workaround for correct table stripes (4/4)
            if (nthStripe++ % 2 === 0) {
                question.$row.classList.remove("iws-stripe");
            } else {
                question.$row.classList.add("iws-stripe");
            }

        } else {
            question.$row.classList.add("iws-hidden");
        }
    }

    // Replace new lines with br tags
    // http://locutus.io/php/strings/nl2br/
    function _nl2br(str) {
        return str.replace(/(\r\n|\n\r|\r|\n)/g, "<br>$1");
    }

    function _toggleAnswers() {
        let id = this.dataset.id;

        if (this.classList.contains("arrow-down")) {

            this.classList.remove("arrow-down");
            this.classList.add("arrow-up");

            // Load answers
            if (!(id in answers)) {
                _getAnswers(id, (function (response) {
                    // directly cache the answers
                    answers[id] = response;
                    let $answersWrapper = this.querySelector(".iws-answers");

                    _insertAnswers($answersWrapper, response);
                }).bind(this));
            }
        } else {
            this.classList.remove("arrow-up");
            this.classList.add("arrow-down");   
        }

        
    }

    function _getAnswers(questionId, callback) {
        let request = new XMLHttpRequest();
        let url = 'api/get-answers/' + questionId;

        request.open('GET', url, true);

        request.onload = function () {
            if (request.status >= 200 && request.status < 400) {
                callback(JSON.parse(request.responseText));
            }
        };
        request.onerror = function () {};

        request.send();
    }

    function _insertAnswers($target, answers) {

        if (answers.length === 0) {
            $target.textContent = "Für diese Frage sind keine Antworten hinterlegt.";
            return false;
        }

        let $ul = document.createElement("ul");
        $ul.className = "list-group list-group-flush mr-5";

        answers.forEach(function (answer) {
            let $li = document.createElement("li");
            $li.className = "list-group-item";

            let $span = document.createElement("span");
            $span.className = "badge badge-info badge-pill mr-2 px-3";

            $span.appendChild(document.createTextNode(answer.picked));
            $li.appendChild($span);
            $li.appendChild(document.createTextNode(answer.answer));
            $ul.appendChild($li);
        });

        $target.appendChild($ul);

    }

})();
