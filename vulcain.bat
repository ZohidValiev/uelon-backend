
cd c:\Programs\vulcain\
$env:UPSTREAM='http://localhost:8000'; $env:ADDR='localhost:3000'; $env:KEY_FILE='.\tls\key.pem'; $env:CERT_FILE='.\tls\cert.pem'; .\vulcain.exe