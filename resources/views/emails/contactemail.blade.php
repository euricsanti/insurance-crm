<!DOCTYPE html>
<html lang=&quot;en-US&quot;>
    <head>
        <meta charset=&quot;utf-8&quot;>
    </head>
    <body>
        <h2>Correo de contacto</h2>
        <div>
            Rivera & Asociados se ha comunicado contigo:</div>
        <div> Subject: {{ Request::get('subject') }}</div>
        <div> Message: {{ Request::get('message') }}</div>
    </body>
</html>