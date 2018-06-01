<?php
    $questions = $data['questions'];
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fragen | I'm with stupid</title>
    <link rel="stylesheet" href="<?=url('assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=url('assets/css/styles.css')?>">
</head>
<body>
    <div class="container">
        <div class="py-5 text-center">
            <h1>I'm with stupid - Fragen</h1>
        </div>

        <input type="text" id="iws-filter-input" class="form-control form-control-lg" value="" placeholder="Fragen filtern..." autofocus>

        <table id="iws-question-table" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Ausgabe</th>
                    <th scope="col">Runde</th>
                    <th scope="col">#</th>
                    <th scope="col">Frage</th>
                </tr>
            </thead>

            <tbody>

            <?php
            foreach ($questions as $question) {
            ?>
                <tr class="iws-question-row">
                    <td><?=escape($question['season'])?></td>
                    <td><?=escape($question['round'])?></td>
                    <td><?=escape($question['question_number'])?></td>
                    <td class="iws-question-cell"><?=nl2br(escape($question['question']))?></td>
                </tr>

            <?php
            }

            ?>
            </tbody>

        </table>
       
    </div>

    <script src="<?=url('assets/js/scripts.js')?>"></script>
</body>
</html>
