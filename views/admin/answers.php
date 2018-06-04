<?php
    $question = $data['question'];
    $answers = $data['answers'];
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Antworten | I'm with stupid</title>
    <link rel="stylesheet" href="<?=url('assets/css/bootstrap.min.css')?>">
</head>
<body>
    <div class="container">
        <div class="py-5 text-center">
            <h1>I'm with stupid - Antworten</h1>
        </div>

        Frage: <b><?=nl2br(escape($question['question']))?></b>

        <?php if (!empty($answers)) { ?>
        <div class="my-5">
            Antworten:

            <ul class="list-group list-group-flush my-3">
            <?php foreach ($answers as $answer) { ?>
                <li class="list-group-item">
                    <span class="badge badge-info badge-pill mr-2 px-3"><?=escape($answer['picked'])?></span>
                    <?=escape($answer['answer'])?>
                </li>
            <?php } ?>
            </ul>

        </div>
        <?php } else { ?>

        
        <form action="frage-<?=$question['id']?>" method="POST" class="my-5">
            <div class="form-group">
                <label for="iwsAnswers">Neue Antworten</label>
                <textarea class="form-control" id="iwsAnswers" name="answers" rows="10"></textarea>
                <small class="text-muted">Neue Antwort in einer neuen Zeile beginnen, angeführt von der Zahl der Leute</small>
            </div>

            <input type="hidden" name="_token" value="<?=$_SESSION['_token']?>">
            <hr class="mb-4">
            <button type="submit" class="btn btn-primary">Abschicken</button>
        </form>

        <?php } ?>
    </div>
</body>
</html>