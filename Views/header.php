<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="pt-br">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Passagens - Admin</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="<?= $this->siteUrl('apple-icon.png?' ) ?>">
    <link rel="shortcut icon" href="<?= $this->siteUrl('favicon.ico?' ) ?>">

    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/bootstrap.min.css') ?>">
    
    <link rel="stylesheet" href="<?= $this->siteUrl('vendors/themify-icons/css/themify-icons.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('vendors/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('vendors/selectFX/css/cs-skin-elastic.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('vendors/jqvmap/dist/jqvmap.min.css') ?>">

    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/select2.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/jquery-ui.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/estilos.css?'. time() ) ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/bootstrap-datetimepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->siteUrl('assets/css/google-fonts.css') ?>" type="text/css">


    <script src="<?= $this->siteUrl('assets/js/jquery-3.6.1.min.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/moment-with-locales.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>

    <script src="<?= $this->siteUrl('assets/js/popper.min.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/main.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/select2.full.min.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/jquery.mask.min.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/jquery-ui.min.js') ?>"></script>
    <script src="<?= $this->siteUrl('assets/js/fontawesome.js') ?>"></script>
    <script>
        
        jQuery.fn.addClassTemp = function(className, timeOut=2000) {
            var element = this;
            element.addClass(className);
            setTimeout(function(){
                element.removeClass(className);
            }, timeOut)

            return this; // Needed for other methods to be able to chain off of yourFunctionName.
        };
    </script>


</head>

<body class="bg-dark">
