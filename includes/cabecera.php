<?php require_once 'conexion.php'; ?>
<?php require_once 'includes/helpers.php'; ?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Blog de Videojuegos</title>
        <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />

    </head>

    <body>

        <!--CABECERA-->  

        <header id="cabecera">
            <!--LOGO-->
            <div id="logo">
                <a href="index.php">
                    Blog de Videojuegos
                </a>
            </div>

        </header>

        <!--MENU-->

        <nav id="menu">

            <ul>
                <li>
                    <a href="index.php">Inicio</a>
                </li>
            </ul>

            <?php
            $categorias = conseguirCategorias($db);
            if (!empty($categorias)):
                while ($categoria = mysqli_fetch_assoc($categorias)):
                    ?>

                    <ul>
                        <li>
                             <a href="categoria.php?id=<?=$categoria['id'] ?>"><?=$categoria['nombre'] ?></a>
                        </li>

                    </ul>

                <?php endwhile; ?>
            <?php endif; ?>

            <ul>
                <li>
                    <a href="index.php">Sobre mi</a>
                </li>
            </ul>        

            <ul>
                <li>
                    <a href="index.php">Nosotros</a>
                </li>
            </ul>                

        </nav>

        <div id="contenedor">

    </body>
</html>