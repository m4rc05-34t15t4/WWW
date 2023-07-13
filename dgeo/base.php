<?php 
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache"); 
    header("Refresh:120");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title>DGeo</title>
        <meta name="keywords" content="HTML5, CSS3, frontend, DGEO, Geoinformação">
        <meta name="description" content="Estatistica da produção da Dgeo">
        <meta name="version" content="1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/components/accordion/">
        <link href="css/reset.css" type="text/css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">-->
        <link href="css/cdn.jsdelivr.net_npm_bootstrap@5.0.1_dist_css_bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="<?php echo "js/jquery-3.5.0.js";?>"></script>
        <script src="<?php echo "js/dgeo.js";?>"></script>
        
        <!--<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pie.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-cartesian.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-linear-gauge.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-table.min.js"></script>-->

        <script src="js/cdn.anychart.com_releases_v8_js_anychart-base.min.js"></script>
        <script src="js/cdn.anychart.com_releases_v8_js_anychart-ui.min.js"></script>
        <script src="js/cdn.anychart.com_releases_v8_js_anychart-exports.min.js"></script>
        <script src="js/cdn.anychart.com_releases_v8_js_anychart-circular-gauge.min.js"></script>
        <script src="js/cdn.anychart.com_releases_v8_js_anychart-linear-gauge.min.js"></script>
        <script src="js/cdn.anychart.com_releases_v8_js_anychart-table.min.js"></script>
        <link href="css/cdn.anychart.com_releases_v8_css_anychart-ui.min.css" type="text/css" rel="stylesheet">
        <link href="css/cdn.anychart.com_releases_v8_fonts_css_anychart-font.min.css" type="text/css" rel="stylesheet">
        <!--<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pie.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-cartesian.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-circular-gauge.min.js"></script>
        <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
        <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">-->