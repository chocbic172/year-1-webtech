# Sync local website files to the remote "Vesta" FTP server

# To use, copy the `example.creds` file in this directory and
# replace the details with your own FTP server. Then update
# the settings below to 

# Powershell must be version 7.1 or higher, to update use
# `winget search Microsoft.PowerShell`.

# =============================
# Configuration
#

$winscp_executable = "C:\Program Files (x86)\WinSCP\winscp.com"
$ftp_credentials_file = ".\utils\vesta.creds"

$local_source_folder = ".\root"
$remote_dest_folder = "/public_html/webtech1"

# =============================
# Credential parsing
#

if (Test-Path $ftp_credentials_file) {
    Write-Host "Found FTP Credentials, attempting to connect..."
    $credentials = Get-Content -Path $ftp_credentials_file -TotalCount 3
    $ftp_host = $credentials[0]
    $ftp_user = $credentials[1]
    $ftp_pass = $credentials[2]
} else {
    Write-Host "Could not find FTP Credentials, please enter manually..."
    $ftp_host = Read-Host "Please enter FTP server"
    $ftp_user = Read-Host "Please enter FTP username"
    $ftp_pass = Read-Host "Please enter FTP password" -MaskInput
}

# =============================
# FTP Sync
#

# See the WinSCP docs for more information on this command:
# https://winscp.net/eng/docs/scriptcommand_synchronize

&$winscp_executable /ini=nul /command `
    "open ftp://${ftp_user}:$ftp_pass@$ftp_host" `
    "synchronize remote $local_source_folder $remote_dest_folder" `
    "close" `
    "exit"
