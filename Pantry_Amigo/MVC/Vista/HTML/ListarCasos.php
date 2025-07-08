<?php
require_once '../../Controlador/CasoControlador.php';

$controlador = new CasoControlador();
$casos = $controlador->listarCasos();
?>

<h2>Casos Activos</h2>

<table>
    <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acción</th>
    </tr>

    <?php if ($casos && $casos instanceof mysqli_result): ?>
        <?php while ($caso = $casos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($caso['Caso_Nombre_Caso']); ?></td>
                <td><?php echo htmlspecialchars($caso['Caso_Descripcion']); ?></td>
                <td>
                    <a href="detalles_caso.php?caso_id=<?php echo $caso['Caso_Id']; ?>">
                        <button>Ver detalles</button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No hay casos activos.</td>
        </tr>
    <?php endif; ?>
</table>
