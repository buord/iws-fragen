<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Neue Runde | I'm with stupid</title>
    <link rel="stylesheet" href="<?=url('assets/css/bootstrap.min.css')?>">
</head>
<body>
    <div class="container">
        <div class="py-5 text-center">
            <h1>I'm with stupid - Neue Runde</h1>
        </div>

        <form action="neue-runde" method="POST">
            <div class="form-row">
                <div class="col-xs-4 mb-3">
                    <label for="iwsSeason">Ausgabe</label>
                    <input type="text" class="form-control" name="season" id="iwsSeason" placeholder="Ausgabe">
                </div>
                <div class="col-xs-4 mb-3">
                    <label for="iwsRound">Runde</label>
                    <input type="text" class="form-control" name="round" id="iwsRound" placeholder="Runde">
                </div>
            </div>

            <div class="form-group">
                <label for="iwsQuestions">Fragen</label>
                <textarea class="form-control" id="iwsQuestions" name="questions" rows="5"></textarea>
                <small class="text-muted">Neue Frage in einer neuen Zeile beginnen und mit einer Zahl und Punkt anführen</small>
            </div>

            <input type="hidden" name="_token" value="<?=$_SESSION['_token']?>">
            <hr class="mb-4">
            <button type="submit" class="btn btn-primary">Abschicken</button>
        </form>
    </div>
</body>
</html>