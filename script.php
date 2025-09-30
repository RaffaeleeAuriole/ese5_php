<?php
// Controllo se il form è stato inviato
$is_submitted = $_SERVER["REQUEST_METHOD"] === "POST";
$name = $is_submitted ? ($_POST["nome"]) : "";
$piatto = $is_submitted ? ($_POST["piatto"]) : "";
$allergie = $is_submitted && ($_POST["allergie"]) ? $_POST["allergie"] : [];
// Recupero IP del cliente (con fallback)
$ip_cliente = $_SERVER["REMOTE_ADDR"];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ristorante Fantasia Digitale</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <h1>Benvenuto al Ristorante Fantasia Digitale</h1>

    <?php if (!$is_submitted): ?>
        <form method="post" action="">
            <label for="nome">Il tuo nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Scrivi il tuo nome...">

            <label for="piatto">Il piatto che vorresti assaggiare:</label>
            <input type="text" id="piatto" name="piatto" placeholder="Es. Risotto ai funghi...">

            <label>Seleziona eventuali allergie:</label>
            <div class="checkboxes">
                <label><input type="checkbox" name="allergie[]" value="Glutine"> Glutine</label>
                <label><input type="checkbox" name="allergie[]" value="Lattosio"> Lattosio</label>
                <label><input type="checkbox" name="allergie[]" value="Frutta secca"> Frutta secca</label>
                <label><input type="checkbox" name="allergie[]" value="Crostacei"> Crostacei</label>
            </div>
            
            <input type="submit" value="Invia il tuo ordine">
        </form>
    <?php else: ?>

        <!-- Scheda ordine -->
        <div class="scheda">
            <h2>La tua scheda ordine</h2>

            <!-- Saluto personalizzato -->
            <p>
                <?php if ($name): ?>
                    Ciao <strong><?php echo $name; ?></strong>, benvenuto al nostro ristorante!
                <?php else: ?>
                    Benvenuto ospite misterioso!  
                <?php endif; ?>
            </p>

            <!-- Frase speciale sul piatto -->
            <p>
                <?php if ($piatto): ?>
                    Ottima scelta! Prepareremo subito il tuo <strong><?php echo $piatto; ?></strong>.
                <?php else: ?>
                    Non hai indicato un piatto... sorprendente! Ti prepareremo una specialità segreta.
                <?php endif; ?>
            </p>

            <!-- Allergie -->
            <p>
                <?php if (!empty($allergie)): ?>
                    Abbiamo annotato le tue allergie:  
                    <ul>
                        <?php foreach ($allergie as $a): ?>
                            <li><?php echo $a; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    Nessuna allergia segnalata: cucineremo senza pensieri!
                <?php endif; ?>
            </p>

            <!-- Curiosità -->
            <p>Curiosità digitale: la tua richiesta ci è arrivata dall’indirizzo <strong><?php echo $ip_cliente; ?></strong>.</p>

            <!-- Pulsante per tornare al modulo -->
            <a href="" class="back-button">Torna al modulo</a>
        </div>
    <?php endif; ?>
</body>
</html>
