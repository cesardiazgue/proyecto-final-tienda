# Ayudante para descargar las fotos de los productos
# Abre Google Imagenes (filtro: fondo blanco), espera la descarga,
# renombra el archivo y lo mueve a www/img

$productos = [ordered]@{
    "twix.jpg"           = "Twix chocolate 6 pack"
    "casino.jpg"         = "galletas Casino chocolate Gamesa"
    "harina_pan.jpg"     = "Harina PAN maiz blanco 1 kg"
    "ferrero_rocher.jpg" = "Ferrero Rocher 12 piezas"
    "takis.jpg"          = "Takis Fuego 280 g"
    "pinguinos.jpg"      = "Pinguinos Marinela"
    "nutella.jpg"        = "Nutella 350 g"
    "kinder_bueno.jpg"   = "Kinder Bueno"
    "pringles.jpg"       = "Pringles Original"
    "cafe_chiapas.jpg"   = "cafe de Chiapas en grano bolsa 1 kg"
    "airpods_pro.jpg"    = "AirPods Pro 2"
    "kindle.jpg"         = "Kindle Paperwhite"
    "jbl_flip6.jpg"      = "JBL Flip 6"
    "dualsense.jpg"      = "control DualSense PS5"
    "mx_master.jpg"      = "Logitech MX Master 3S"
    "anker_65w.jpg"      = "cargador Anker 65W USB-C"
    "sony_xm5.jpg"       = "Sony WH-1000XM5"
    "lampara_led.jpg"    = "Xiaomi lampara LED escritorio"
    "bolsa_ysl.jpg"      = "Saint Laurent Lou camera bag"
    "air_force_1.jpg"    = "Nike Air Force 1 blanco"
    "rayban.jpg"         = "Ray-Ban Wayfarer negro"
    "gorra_new_era.jpg"  = "gorra New Era 59FIFTY negra"
    "dior_sauvage.jpg"   = "Dior Sauvage eau de toilette 100 ml"
    "herschel.jpg"       = "mochila Herschel Little America"
    "cartera_tommy.jpg"  = "cartera Tommy Hilfiger piel"
    "owala.jpg"          = "Owala FreeSip 24 oz"
    "vela.jpg"           = "Bath and Body Works vela 3 mechas"
    "nespresso.jpg"      = "Nespresso Vertuo Pop"
    "lego_bonsai.jpg"    = "LEGO Bonsai 10281"
    "uno.jpg"            = "juego de cartas UNO Mattel"
}

$descargas = Join-Path $HOME "Downloads"
$destino   = Join-Path $PSScriptRoot "www\img"
$numero    = 0

foreach ($archivo in $productos.Keys) {
    $numero++

    # Si la imagen ya existe, se la salta
    if (Test-Path (Join-Path $destino $archivo)) {
        Write-Host "[$numero/30] $archivo ya existe, se salta"
        continue
    }

    # Abre Google Imagenes con filtro de color blanco
    $busqueda = [uri]::EscapeDataString($productos[$archivo])
    Start-Process "https://www.google.com/search?tbm=isch&tbs=ic:specific,isc:white&q=$busqueda"
    $antes = Get-Date

    Write-Host ""
    Write-Host "[$numero/30] $archivo  ->  $($productos[$archivo])" -ForegroundColor Cyan
    Read-Host "Guarda la imagen en Descargas y presiona Enter"

    # Busca el archivo mas reciente descargado despues de abrir la busqueda
    $nuevo = Get-ChildItem $descargas -File |
        Where-Object { $_.LastWriteTime -gt $antes -and $_.Extension -notin ".crdownload", ".tmp" } |
        Sort-Object LastWriteTime -Descending |
        Select-Object -First 1

    if ($nuevo) {
        Move-Item $nuevo.FullName (Join-Path $destino $archivo) -Force
        Write-Host "Guardada como $archivo" -ForegroundColor Green
    } else {
        Write-Host "No encontre una descarga nueva. Corre el script otra vez al final." -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "Listo. Revisa la carpeta www\img" -ForegroundColor Green