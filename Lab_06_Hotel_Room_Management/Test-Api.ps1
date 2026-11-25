# Перевірка API лабораторної №6: виводить статус і тіло відповіді для скриншотів.
# Запуск (API має працювати на :5080):  powershell -ExecutionPolicy Bypass -File .\Test-Api.ps1
param([string]$Base = "http://localhost:5080/api/rooms")

function Invoke-Case([string]$Title, [string]$Method, [string]$Url, [string]$Body) {
    Write-Host ""
    Write-Host "=== $Title ===" -ForegroundColor Cyan
    Write-Host "$Method $Url"
    if ($Body) { Write-Host "Body: $Body" }
    try {
        $params = @{ Uri = $Url; Method = $Method; UseBasicParsing = $true }
        if ($Body) {
            $params.Body = [System.Text.Encoding]::UTF8.GetBytes($Body)
            $params.ContentType = "application/json; charset=utf-8"
        }
        $r = Invoke-WebRequest @params
        Write-Host "Status: $([int]$r.StatusCode)" -ForegroundColor Green
        $text = [System.Text.Encoding]::UTF8.GetString($r.RawContentStream.ToArray())
        Write-Host $text
        return $text
    } catch {
        $code = [int]$_.Exception.Response.StatusCode
        Write-Host "Status: $code" -ForegroundColor Yellow
        if ($_.ErrorDetails -and $_.ErrorDetails.Message) { Write-Host $_.ErrorDetails.Message }
        return $null
    }
}

$list = Invoke-Case "1. GET список (очікується 200)" "GET" $Base ""

$ok = Invoke-Case "2. POST коректний запис (200)" "POST" $Base `
  '{"number":"501","category":"Люкс","capacity":2,"floor":5,"pricePerNight":6200.5,"isAvailable":true}'

Invoke-Case "3. POST місткість 0 (400)" "POST" $Base `
  '{"number":"502","category":"Стандарт","capacity":0,"floor":5,"pricePerNight":1500,"isAvailable":true}' | Out-Null

Invoke-Case "4. POST номер із пробілів (400)" "POST" $Base `
  '{"number":"   ","category":"Стандарт","capacity":2,"floor":5,"pricePerNight":1500,"isAvailable":true}' | Out-Null

Invoke-Case "5. POST невідома категорія (400)" "POST" $Base `
  '{"number":"503","category":"Президентський","capacity":2,"floor":5,"pricePerNight":1500,"isAvailable":true}' | Out-Null

Invoke-Case "6. POST повтор номера 101 (409)" "POST" $Base `
  '{"number":" 101 ","category":"Комфорт","capacity":2,"floor":1,"pricePerNight":1800,"isAvailable":true}' | Out-Null

Invoke-Case "7. POST поверх 0 дозволений (200)" "POST" $Base `
  '{"number":"002","category":"Стандарт","capacity":1,"floor":0,"pricePerNight":900,"isAvailable":true}' | Out-Null

if ($ok) {
    $id = ($ok | ConvertFrom-Json).id
    Invoke-Case "8. DELETE наявного id (200)" "DELETE" "$Base/$id" "" | Out-Null
    Invoke-Case "9. Повторний DELETE (404)" "DELETE" "$Base/$id" "" | Out-Null
}
Write-Host ""
