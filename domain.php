<?php
require 'vendor/autoload.php';

// Function to make the request to Google Generative AI API  (You can create API key here: https://aistudio.google.com/apikey)
function generateDomainName($userPrompt) {
    $apiKey = getenv('GEMINI_API_TOKEN');
  // or $apiKey = "API KEY";

    if (!$apiKey) {
        // Handle the error if the API key is not found in environment variables
        return "API key not found in environment variables.";
    }

    $model = 'gemini-1.5-flash';

    $generationConfig = [
        'temperature' => 1,
        'topP' => 0.95,
        'topK' => 64,
        'maxOutputTokens' => 8192,
        'responseMimeType' => 'application/json',
    ];

    $safetySettings = [
        [
            'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
            'threshold' => 'BLOCK_ONLY_HIGH',
        ],
        [
            'category' => 'HARM_CATEGORY_HARASSMENT',
            'threshold' => 'BLOCK_ONLY_HIGH',
        ],
        [
            'category' => 'HARM_CATEGORY_HATE_SPEECH',
            'threshold' => 'BLOCK_ONLY_HIGH',
        ],
        [
            'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
            'threshold' => 'BLOCK_LOW_AND_ABOVE',
        ],
    ];

     $history = [
        "Output should be only 20 domain names. Domain name length must be at least 3 characters before .mn. Do not output the exact example, change all the domains but same meaning. Only end with .mn tld. MUST BE ONLY IN LATIN LETTERS. NO CYRILLIC. NO WEEDS AND DRUGS.",
        "input: Машин зарын сайт",
        "output: [\"mashin.mn\", \"car.mn\", \"ecar.mn\", \"carshop.mn\", \"mycar.mn\", \"cheapcar.mn\", \"carly.mn\", \"cars.mn\", \"emashing.mn\", \"imashin.mn\"]",
        "input: Хувцасны дэлгүүр",
        "output: [\"myclothes.mn\", \"clothes.mn\", \"myhuvtsas.mn\", \"jaze.mn\", \"atoz.mn\", \"lilyshop.mn\", \"myshop.mn\", \"korshop.mn\", \"bidshop.mn\", \"ishop.mn\"]",
        "input: Ресторан, хоолны газар",
        "output: [\"premiumfood.mn\", \"foody.mn\", \"foodly.mn\", \"ubfood.mn\", \"monfood.mn\", \"spicyfood.mn\", \"restaurant.mn\", \"order.mn\", \"jazzub.mn\", \"ishop.mn\"]",
        "input: Санхүүгийн үйлчилгээ",
        "output: [\"fintech.mn\", \"finmn.mn\", \"myfinance.mn\", \"monfin.mn\", \"monfinance.mn\", \"finify.mn\", \"ifinance.mn\", \"efinance.mn\", \"wepay.mn\", \"gopay.mn\", \"fastpay.mn\"]",
         "input: Хоолны газар",
        "output: [\"foodplace.mn\", \"foodspot.mn\", \"eatout.mn\", \"foodhub.mn\", \"tasty.mn\", \"hungry.mn\", \"foodlover.mn\", \"foodie.mn\", \"mongolianfood.mn\", \"bestfood.mn\"]",
         "input: Санхүү",
        "output: [\"money.mn\", \"finance.mn\", \"monfinance.mn\", \"finify.mn\", \"mymoney.mn\", \"cash.mn\", \"invest.mn\", \"bank.mn\", \"financial.mn\", \"funds.mn\"]",
         "input: Барилга",
        "output: [\"barilga.mn\", \"material.mn\", \"monbarilga.mn\", \"buildings.mn\", \"ebarilga.mn\", \"buildmon.mn\", \"builtinmongolia.mn\", \"bricks.mn\", \"buildit.mn\", \"construction.mn\"]",
        "input: Үйлдвэр",
       "output: [\"industry.mn\", \"production.mn\", \"factory.mn\", \"manufacturing.mn\", \"industrial.mn\", \"mongolianindustry.mn\", \"madeinmongolia.mn\", \"monindustry.mn\", \"works.mn\", \"producers.mn\"]",
         "input: Хэвлэл",
        "output: [\"hevlel.mn\", \"khevlel.mn\", \"print.mn\", \"monprint.mn\", \"iprint.mn\", \"eprint.mn\", \"cloudprint.mn\", \"fastprint.mn\", \"priting.mn\"]",
         "input: Мэдээ мэдээлэл",
        "output: [\"press.mn\", \"news.mn\", \"monmedia.mn\", \"mediamon.mn\", \"media.mn\", \"print.mn\", \"monpress.mn\", \"publication.mn\", \"journal.mn\", \"magazine.mn\"]",
        "input: Мэдээ мэдээлэл",
        "output: [\"news.mn\", \"mediamon.mn\", \"monmedia.mn\", \"press.mn\", \"info.mn\", \"media.mn\", \"mnnews.mn\", \"mongoliannews.mn\", \"newsmn.mn\", \"worldnews.mn\"]",
        "input: Барилга",
         "output: [\"buildings.mn\", \"construction.mn\", \"monbarilga.mn\", \"barilga.mn\", \"build.mn\", \"buildit.mn\", \"building.mn\", \"ebarilga.mn\", \"material.mn\", \"house.mn\"]",
       "input: Хувцасны дэлгүүр",
        "output: [\"huvtsas.mn\", \"shop.mn\", \"clothesshop.mn\", \"dress.mn\", \"myhuvtsas.mn\", \"mongolianshop.mn\", \"fashion.mn\", \"style.mn\", \"clothing.mn\", \"korshop.mn\"]",
         "input: Зарын сайт",
        "output: [\"zariy.mn\",\"unegui.mn\",\"zar.mn\",\"baraa.mn\",\"sell.mn\",\"selling.mn\",\"buyfrom.mn\",\"zarly.mn\",\"zarna.mn\",\"myitem.mn\"]",
        "input: Технологи",
         "output: [\"tech.mn\",\"techmn.mn\",\"weit.mn\",\"itmn.mn\",\"mongoliantech.mn\",\"techmongol.mn\",\"techhub.mn\",\"techie.mn\",\"techology.mn\",\"inno.mn\"]",
        "input: Технологи",
         "output: [\"tech.mn\",\"techmn.mn\",\"techie.mn\",\"itmn.mn\",\"inno.mn\",\"mongoliantech.mn\",\"techmongol.mn\",\"techology.mn\",\"techhub.mn\",\"techie.mn\"]",
         "input: Аялал, жуучлал",
         "output: [\"travel.mn\",\"travely.mn\",\"aylal.mn\",\"ayliy.mn\",\"goly.mn\",\"letsgo.mn\",\"trip.mn\",\"trips.mn\",\"mytrip.mn\",\"mytravel.mn\"]",
         "input: Танин мэдэхүй",
         "output: [\"sciwiki.mn\",\"physics.mn\",\"wikis.mn\",\"mywiki.mn\",\"wikimon.mn\",\"astronomic.mn\",\"history.mn\",\"math.mn\",\"geometry.mn\",\"asuult.mn\"]",
       "input: Цахим худалдаа",
         "output: [\"eshop.mn\",\"market.mn\",\"mymall.mn\",\"goymall.mn\",\"miniimall.mn\",\"gomarket.mn\",\"emarket.mn\",\"estore.mn\",\"juststore.mn\",\"herestore.mn\"]",
         "input: Цахим худалдаа",
        "output: [\"eshop.mn\",\"mymall.mn\",\"gomarket.mn\",\"emarket.mn\",\"online.mn\",\"shopmn.mn\",\"onlineshop.mn\",\"ecommerce.mn\",\"estore.mn\",\"store.mn\"]"
    ];


    $fullPrompt = implode("\n", $history) . "\n" . "Generate json input 20 Mongolian domain name ideas (only ends with .mn tld, domain name must be 3 and more characters before .mn, do not duplicate same domain name, do not generate off topic names, - can be used) based on following case (output description must be in Mongolian) MUST BE ONLY IN LATIN LETTERS. NO CYRILLIC. NO WEEDS AND DRUGS. OUTPUT MUST BE AN ARRAY NOT ARRAY IN OBJECT: " . $userPrompt;


     $data = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => $fullPrompt,
                    ]
                ]
            ]
        ],
        'generationConfig' => $generationConfig,
        'safetySettings' => $safetySettings,
    ];


  $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-goog-api-key: ' . $apiKey
    ]);



    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);


    if ($httpCode == 200) {
        $response_array = json_decode($response, true);
       if (isset($response_array['candidates'][0]['content']['parts'][0]['text'])) {
        $text_response = $response_array['candidates'][0]['content']['parts'][0]['text'];
          if($text_response && json_decode($text_response) !== null) {
           return json_decode($text_response);
        } else {
            return false;
        }
      } else {
           return false;
       }

    } else {
        return false;
    }
}


// --- HTML Rendering ---
$domainNames = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userPrompt'])) {
    $userPrompt = $_POST['userPrompt'];
    $domainNames = generateDomainName($userPrompt);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Name Generator</title>
</head>
<body>
    <h1>Domain Name Generator</h1>
    <form method="post">
        <label for="userPrompt">Enter a prompt:</label><br>
        <input type="text" id="userPrompt" name="userPrompt" required><br><br>
        <button type="submit">Generate Domain Names</button>
    </form>

    <?php if ($domainNames): ?>
        <h2>Generated Domain Names:</h2>
        <ul>
        <?php if($domainNames): ?>
            <?php foreach ($domainNames as $domain): ?>
                <li><?php echo htmlspecialchars($domain); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Domain name generator failed, try again.</li>
        <?php endif; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
