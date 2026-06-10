<?php
    if(!defined('__APP__')) {
        die("Hacking attempt");
    }

    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 1.00;

    $url = "https://open.er-api.com/v6/latest/EUR";
    $ssl_bypass = stream_context_create([
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ],
    ]);

    $response = @file_get_contents($url, false, $ssl_bypass);
    $rates = [];

    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['rates'])) {
            $rates = $data['rates'];
        }
    }

    $target_currencies = [
        'USD' => ['name' => 'Američki dolar', 'symbol' => '$'],
        'GBP' => ['name' => 'Britanska funta', 'symbol' => '£'],
        'CHF' => ['name' => 'Švicarski franak', 'symbol' => 'CHF'],
        'CAD' => ['name' => 'Kanadski dolar', 'symbol' => 'C$'],
        'AUD' => ['name' => 'Australski dolar', 'symbol' => 'A$'],
        'JPY' => ['name' => 'Japanski jen', 'symbol' => '¥'],
        'RSD' => ['name' => 'Srpski dinar', 'symbol' => 'RSD'],
        'BAM' => ['name' => 'Konvertibilna marka', 'symbol' => 'KM']
    ];
?>

<div style="padding: 20px; font-family: sans-serif; max-width: 800px; margin: 0 auto;">
    <h2 style="color: #2b358a; border-bottom: 2px solid #2b358a; padding-bottom: 10px;">Kalkulator valuta za recepte</h2>
    <p>Unesite cijenu recepta u eurima kako biste vidjeli iznos u drugim svjetskim valutama u stvarnom vremenu.</p>

    <form action="index.php?menu=13" method="POST" style="margin-bottom: 30px; display: flex; gap: 10px; align-items: center; max-width: 400px;">
        <div style="position: relative; flex: 1;">
            <input type="number" step="0.01" name="amount" min="0" required 
                   value="<?php echo number_format($amount, 2, '.', ''); ?>"
                   style="width: 100%; padding: 12px 40px 12px 12px; border: 2px solid #2b358a; border-radius: 4px; font-size: 18px; box-sizing: border-box; font-weight: bold;">
            <span style="position: absolute; right: 15px; top: 12px; font-size: 18px; font-weight: bold; color: #2b358a;">€</span>
        </div>
        <input type="submit" value="Preračunaj" 
               style="background: #2b358a; color: white; padding: 14px 25px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;">
    </form>

    <?php if (!empty($rates)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 15px;">
            <div style="background: #2b358a; color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: center;">
                <span style="font-size: 14px; opacity: 0.8;">Uneseni iznos:</span>
                <span style="font-size: 28px; font-weight: bold; margin-top: 5px;"><?php echo number_format($amount, 2, ',', '.'); ?> €</span>
                <span style="font-size: 12px; opacity: 0.6; margin-top: 10px;">Polazna valuta (Euro)</span>
            </div>

            <?php foreach ($target_currencies as $code => $info): ?>
                <?php if (isset($rates[$code])): 
                    $converted = $amount * $rates[$code];
                ?>
                    <div style="background: #f9f9f9; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: center;">
                        <span style="font-size: 14px; color: #666;"><?php echo $info['name']; ?> (<?php echo $code; ?>)</span>
                        <span style="font-size: 24px; font-weight: bold; color: #333; margin-top: 5px;">
                            <?php 
                                if ($code === 'JPY' || $code === 'RSD') {
                                    echo number_format($converted, 0, ',', '.') . ' ' . $info['symbol'];
                                } else {
                                    echo number_format($converted, 2, ',', '.') . ' ' . $info['symbol'];
                                }
                            ?>
                        </span>
                        <span style="font-size: 11px; color: #999; margin-top: 10px;">Tečaj: 1 € = <?php echo number_format($rates[$code], 4, ',', '.'); ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color: red; font-weight: bold; text-align: center; margin-top: 20px;">Trenutno nije moguće dohvatiti najnoviju tečajnu listu. Provjerite internetsku vezu.</p>
    <?php endif; ?>
</div>