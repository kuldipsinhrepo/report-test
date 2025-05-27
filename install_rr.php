<?php
$version = '2.11.2'; // Using a stable version
$url = "https://github.com/roadrunner-server/roadrunner/releases/download/v{$version}/roadrunner-{$version}-windows-amd64.zip";
$zipFile = "roadrunner-{$version}.zip";

echo "Downloading RoadRunner...\n";
file_put_contents($zipFile, file_get_contents($url));

echo "Extracting RoadRunner...\n";
$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo('./');
    $zip->close();
    echo "RoadRunner extracted successfully!\n";
} else {
    echo "Failed to extract RoadRunner\n";
}

// Rename the executable
rename("roadrunner-{$version}-windows-amd64/rr.exe", "rr.exe");

// Clean up
unlink($zipFile);
echo "Installation complete! You can now run 'rr serve' to start RoadRunner.\n"; 