<!DOCTYPE html>

<?  
$jsonData = json_decode(file_get_contents('../lametric/alien/XXXXXX-XXXXXXX.json'), true);

if($jsonData['sosmode'] == 1) {
    $sosIcon = "fas fa-lightbulb";
} else {
    $sosIcon = "far fa-lightbulb";
}
print_r($jsonData);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALIEN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <form action="https://api.particle.io/v1/devices/e00fce68bbfafdf81ddefb0d/CallTheAlien?access_token=a55ed7f30fe467475d1176ddf25f6265f483aff0" method="POST" target="hiddenFrame">

     <button type="submit" name="arg" value="SOS"><i class="<?=$sosIcon?>" style="font-size: 90px;"></i></button>

    </form>

    <iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>
</body>
</html>
