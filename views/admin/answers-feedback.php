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
            Die neuen Antworten wurde gespeichert!<br>
            [ <a href="<?=url('admin/fragen')?>">Zu allen Fragen im Admin-Bereich</a> ]<br>
            [ <a href="<?=url('admin/antworten/frage-' . ($data['id'] + 1))?>">Zur nächsten Frage</a> ]
        </div>
    </div>
</body>
</html>