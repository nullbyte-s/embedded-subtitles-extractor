<?php
$file = $_GET['file'];
$decodedFile = urldecode(str_replace(['+'], ['%2B'], $file));
$filePath = '/home/user/Media/Sample' . $decodedFile;

if (file_exists($filePath)) {
    $command = "sudo -u user ../scripts/converter_SSA-SRT.sh \"" . $filePath . "\"";
    $output = shell_exec($command);
    echo "$output";
} else {
    echo "Arquivo não encontrado: $decodedFile";
}
?>