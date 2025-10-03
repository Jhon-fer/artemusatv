<form action="procesar_verificacion.php" method="POST">
    <input type="hidden" name="correo" value="<?php echo $_GET['correo']; ?>">
    <label>Código de verificación:</label>
    <input type="text" name="codigo" required>
    <button type="submit">Verificar</button>
</form>
