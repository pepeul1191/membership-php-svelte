<!DOCTYPE html>
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" href="<?php echo $staticURL; ?>favicon.ico">
  <meta name="description" content="Sitio Web con SvelteJS">
  <meta name="author" content="Software Web Perú">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
  <?php if($SESSION != false){ ?><meta name="csrf" key="<?php echo $SESSION['csrfKey']; ?>" value="<?php echo $SESSION['csrfValue']; ?>"><?php } ?>
  <?php if(isset($stylesheets)) echo loadStylesheets($stylesheets); ?>
  <base href="<?php echo $href; ?>">
  <title><?php echo($title); ?></title>
  <script type="text/javascript">
    const BASE_URL = "<?php echo $baseURL;?>";
    const STATIC_URL = "<?php echo $staticURL;?>";
    const ENTERPRISE_DATA = JSON.parse('<?php echo htmlspecialchars_decode($enterpriseData,ENT_QUOTES); ?>');
  </script>
</head>
<body>