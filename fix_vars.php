<?php
$f = 'app/Http/Controllers/Admin/ReminderController.php';
$c = file_get_contents($f);
$c = str_replace(', $candidateId);', ', null);', $c);
$c = str_replace(', $applicationId ? null : null);', ', null);', $c);
file_put_contents($f, $c);
echo "Fixed!";
