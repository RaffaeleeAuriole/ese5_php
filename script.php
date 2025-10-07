<?php
// Controllo se il form è stato inviato
$is_submitted = $_SERVER["REQUEST_METHOD"] === "POST";
$name = $is_submitted ? trim($_POST["nome"]) : "";
$piatto = $is_submitted ? trim($_POST["piatto"]) : "";
$allergie = $is_submitted && isset($_POST["allergie"]) ? $_POST["allergie"] : [];

// Recupero IP del cliente
$ip_cliente = $_SERVER["REMOTE_ADDR"];

// Array associativo dei piatti con i loro allergeni
$piatti = [
    [
        "nome" => "Pancake",
        "img"=> "https://upload.wikimedia.org/wikipedia/commons/2/2c/Stack_of_pancakes.jpg",
        "allergeni"=> ["glutine", "lattosio"]
    ],
    [
        "nome"=> "Spaghetti frutti di mare",
        "img"=> "https://ricetta.it/Uploads/Imgs/spaghetti-ai-frutti-di-mare_.jpg.webp",
        "allergeni"=> ["glutine", "crostacei"]
    ],
    [
        "nome"=> "Torta sbrisolona con frutta secca",
        "img"=> "https://www.dueamicheincucina.it/wp-content/uploads/2015/01/torta-sbrisolona.jpg",
        "allergeni"=> ["glutine", "fruttasecca"]
    ]
];

// Variabili di risultato
//in_array($valore_da_cercare, $array);
$messaggio_allergia = "";
$img_piatto = "";

// Se il form è stato inviato e il piatto è stato specificato
if ($is_submitted && !empty($piatto)) {
    foreach ($piatti as $p) {
        // Confronto diretto del nome del piatto (case-sensitive)
        if ($p["nome"] == $piatto) {
            $img_piatto = $p["img"]; // salvo l'immagine del piatto

            // Secondo foreach: controllo gli allergeni del piatto
            foreach ($p["allergeni"] as $a_piatto) {
                if (in_array($a_piatto, $allergie)) {
                    $messaggio_allergia = " Attenzione: il piatto <strong>{$p['nome']}</strong> contiene <strong>{$a_piatto}</strong>, a cui sei allergico!";
                    break 2; // esco da entrambi i foreach
                }
            }

            // Nessuna allergia trovata
            if (empty($messaggio_allergia)) {
                $messaggio_allergia = " Nessun allergene pericoloso rilevato nel piatto <strong>{$p['nome']}</strong>.";
            }
        }
    }
}
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
            <input type="text" id="piatto" name="piatto" placeholder="Es. Pancake, Spaghetti frutti di mare...">

            <label>Seleziona eventuali allergie:</label>
            <div class="checkboxes">
                <label><input type="checkbox" name="allergie[]" value="glutine"> Glutine</label>
                <label><input type="checkbox" name="allergie[]" value="lattosio"> Lattosio</label>
                <label><input type="checkbox" name="allergie[]" value="fruttasecca"> Frutta secca</label>
                <label><input type="checkbox" name="allergie[]" value="crostacei"> Crostacei</label>
            </div>
            
            <input type="submit" value="Invia il tuo ordine">
        </form>
    <?php else: ?>

        <div class="scheda">
            <h2>La tua scheda ordine</h2>

            <p>
                <?php if ($name): ?>
                    Ciao <strong><?php echo($name); ?></strong>, benvenuto al nostro ristorante!
                <?php else: ?>
                    Benvenuto ospite misterioso!
                <?php endif; ?>
            </p>

            <p>
                <?php if ($piatto): ?>
                    Ottima scelta! Prepareremo subito il tuo <strong><?php echo($piatto); ?></strong>.
                <?php else: ?>
                    Non hai indicato un piatto... Ti sorprenderemo noi!
                <?php endif; ?>
            </p>

            <p>
                <?php if (!empty($allergie)): ?>
                    Allergie segnalate:
                    <ul>
                        <?php foreach ($allergie as $a): ?>
                            <li><?php echo($a); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    Nessuna allergia segnalata!
                <?php endif; ?>
            </p>

            <p><?php echo $messaggio_allergia; ?></p>

            <?php if ($img_piatto): ?>
                <img src="<?php echo $img_piatto; ?>" alt="Immagine del piatto" width="300">
            <?php endif; ?>

            <p>Curiosità: la tua richiesta ci è arrivata da <strong><?php echo $ip_cliente; ?></strong>.</p>

            <a href="" class="back-button">Torna al modulo</a>
        </div>
    <?php endif; ?>
</body>
</html>
