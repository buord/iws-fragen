(function () {

    "use strict";

    let questions = [];
    let lastInput = "";
    // Workaround for correct table stripes (1/4)
    let nthStripe = 1;


    /* cache DOM */
    const $filterInput = document.querySelector("#iws-filter-input");
    const $questionTable = document.querySelector("#iws-question-table");
    const $questionCells = $questionTable.querySelectorAll(".iws-question-cell");
    const $questionRows = $questionTable.querySelectorAll(".iws-question-row");


    /* parse table */
    $questionCells.forEach(function($cell) {
        questions.push({
            "text": $cell.innerText,
            "element": $cell,
            "row": $cell.parentNode,
            "visible": true
        });
    });
    

    /* bind events */
    $filterInput.addEventListener("keyup", _filterQuestions);
    $questionRows.forEach(function ($row) {
        $row.addEventListener("click", _redirect);
    });
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
            question.row.classList.remove("iws-hidden");

            
            if (lastInput === "") {
                // No highlight, if input field is empty
                question.element.innerHTML = _nl2br(question.text);
            } else {
 
                // Mask special characters like dots and parentheses
                let masked = lastInput.replace(/([\.\[\]\(\)])/g, "\\$1");
                // Highlight filtered text
                let regexp = RegExp("(" + masked + ")", "ig");
                let highlight = "<b>$1</b>";
                question.element.innerHTML = _nl2br(question.text.replace(regexp, highlight));
            }

            // Workaround for correct table stripes (4/4)
            if (nthStripe++ % 2 === 0) {
                question.row.classList.remove("iws-stripe");
            } else {
                question.row.classList.add("iws-stripe");
            }

        } else {
            question.row.classList.add("iws-hidden");
        }
    }

    // Replace new lines with br tags
    // http://locutus.io/php/strings/nl2br/
    function _nl2br(str) {
        return str.replace(/(\r\n|\n\r|\r|\n)/g, "<br>$1");
    }

    function _redirect() {
        let id = this.dataset.id;
        location.href = "antworten/frage-" + id;
    }

})();