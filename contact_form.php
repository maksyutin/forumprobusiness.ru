<?php

require __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName('Google Sheets and PHP');
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);

# insert your spreadsheetId google
$spreadsheetId = 'IDAFOIDe97JDQIDuoLYk_IDqTMHjID1hK7ngFID71YNs';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $business_name = $_POST['business_name'];
    $inn = $_POST['inn'];
    $city = $_POST['city'];
    $birth_date = $_POST['birth_date'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $data_processing = isset($_POST['data_processing']) ? 'Да' : 'Нет';

    $values = [[$full_name, $business_name, $inn, $city, $birth_date, $phone, $email, $subject, $data_processing]];

    $range = $subject;

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    $params = [
        'valueInputOption' => 'RAW'
    ];

    $insert = [
        "insertDataOption" => "INSERT_ROWS"
    ];

    $response = $service->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $body,
        $params,
        $insert
    );

    echo "Данные успешно отправлены!";
} else {
    echo "При отправке произошла ошибка";
}
