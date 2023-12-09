<?php
$baseDir = '/home/user/Media/Sample';
$currentDir = isset($_GET['dir']) ? $_GET['dir'] : '';
$requestedDir = realpath($baseDir . '/' . $currentDir);

if (strpos($requestedDir, $baseDir) !== 0) {
    header("Location: index.php");
    exit();
}

$targetDir = $requestedDir;
$files = array_diff(scandir($targetDir), array('..', '.'));

if ($currentDir !== '' && $currentDir !== '/') {
    $parentDir = dirname($currentDir);
    echo "<a href='javascript:void(0)'><i class='bi bi-arrow-left-circle btn-back' data-parent-dir='$parentDir' style='color: #e5dbcf; transition: color 0.3s ease;' onmouseover='this.style.color=\"#87CEFA\"' onmouseout='this.style.color=\"#e5dbcf\"'></i></a><br>";
}

foreach ($files as $file) {
    $filePath = $currentDir . '/' . $file;
	$fullPath = $targetDir . '/' . $file;
	
    if (is_dir($fullPath) || in_array(pathinfo($file, PATHINFO_EXTENSION), ['mkv', 'mp4'])) {
        $srtFile = pathinfo($fullPath, PATHINFO_FILENAME) . '.srt';
        $srtFullPath = $targetDir . '/' . $srtFile;
		if (!file_exists($srtFullPath)) {
			if (is_dir($fullPath)) {
				echo "<a href='javascript:void(0)' class='directory-link' data-dir='$filePath'><i class='bi bi-folder-fill'></i>&nbsp;$file</a><br>";
			} else {
				echo "<a href='javascript:void(0)' class='file-link' data-file='$filePath'>$file</a><br>";
			}
		} else {
            echo "<span class='text-success'>$file</span><br>";
        }
	}
}
?>