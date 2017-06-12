<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <meta name="description" content="<?= $description ?>">
        <meta name="keywords" content="<?= $keywords ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
        <link href="<?= base_url('templatecss/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('templatecss/custom.css?v1') ?>" rel="stylesheet"> 
        <link href="<?= base_url('cssloader/theme.css') ?>" rel="stylesheet">
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('loadlanguage/all.js') ?>"></script>
        <?php if ($cookieLaw != false) { ?>
            <script type="text/javascript">
                window.cookieconsent_options = {"message": "<?= $cookieLaw['message'] ?>", "dismiss": "<?= $cookieLaw['button_text'] ?>", "learnMore": "<?= $cookieLaw['learn_more'] ?>", "link": "<?= $cookieLaw['link'] ?>", "theme": "<?= $cookieLaw['theme'] ?>"};
            </script>
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
        <?php } ?>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <nav class="navbar navbar-onepoge navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
		      <img src="<?= base_url('template/imgs/logo.png') ?>" class="animated bounce" alt="">
		  </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse"> 
          <ul class="nav navbar-nav navbar-right animated fadeInRight">
            <li><a href="../navbar/">Forskolin 1020</a></li>
            <li><a href="../navbar-static-top/">Защо Работи</a></li>
            <li class="active"><a href="./">Сертификати</a></li>
			<li class="active"><a href="./">Сертификати</a></li>
          </ul>
        </div>
      </div>
    </nav>
