<#
Setup script to download JDBC and JSTL jars into WEB-INF/lib for local testing.
Run from PowerShell in the project root.
#>

$webInfLib = Join-Path -Path $PSScriptRoot -ChildPath 'src\main\webapp\WEB-INF\lib'
If (!(Test-Path $webInfLib)) { New-Item -ItemType Directory -Path $webInfLib -Force | Out-Null }

Write-Host "Downloading MySQL Connector/J..."
$mysqlUrl = 'https://repo1.maven.org/maven2/mysql/mysql-connector-java/8.0.33/mysql-connector-java-8.0.33.jar'
$mysqlDest = Join-Path $webInfLib 'mysql-connector-java-8.0.33.jar'
Invoke-WebRequest -Uri $mysqlUrl -OutFile $mysqlDest

Write-Host "Downloading JSTL (jstl-1.2)..."
$jstlUrl = 'https://repo1.maven.org/maven2/javax/servlet/jstl/1.2/jstl-1.2.jar'
$jstlDest = Join-Path $webInfLib 'jstl-1.2.jar'
Invoke-WebRequest -Uri $jstlUrl -OutFile $jstlDest

Write-Host "Download complete. Files placed in $webInfLib"
