<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="main-top">
	
	<div style="min-height:1200px;">
		<img src="<?= base_url('template/imgs/main.jpg') ?>" class="img-responsive" alt="aa">
	</div>

	<div class="main-top-info">
		<span class="how-to animated fadeInRightBig"><img src="<?= base_url('template/imgs/slide-title-border.png') ?>" alt=""> Learn <span>now</span> to <img src="<?= base_url('template/imgs/slide-title-border.png') ?>" alt=""></span>
		<h2 class="animated fadeInLeftBig">Win the battle with<h2>
		<h1 class="animated fadeInRightBig">Excess weight</h1>
	</div>
	<img src="<?= base_url('template/imgs/woman.png') ?>" class="woman-right animated flipInX" alt="">
	<img src="<?= base_url('template/imgs/bottle.png') ?>" class="bottle-right animated flipInY" alt="">
</div>
<div class="after-main">
<div class="container">
<p>How to achieve the body of your dreams, and fast? With Forskolin 1020/cAMP! IS IT REALLY POSSIBLE TO LOSE UP TO 21 KG?*</p>
</div>
</div>
<div class="page-second pages-bg">
<div class="container">
<div class="page-info">
What is Forskolin 1020?
AND WHY IS IT SO EFFECTIVE?

Introducing the number one product in the US for the past year - Forskolin 1020 - a weight loss supplement that really works and will help you solve all your problems by allowing you to lose weight easily and quickly and help you achieve the figure you always wanted you've been dreaming!

Forskolin 1020 is a natural product with the main active ingredient extracted from the ancient plant "Coleus Forskohlii". In nature, "Coleus Forskohlii" is part of the mint family and grows in the wild subtropical regions of India, Burma and Thailand. For millennia, the local population has benefited from its healing properties, treating a number of health problems such as immune system failure, hypertension, pulmonary-aspiration diseases, hair loss, infections, glaucoma, oncological diseases... But thanks to modern medicine, recent scientific and clinical studies, and discoveries of its incredible benefits in the fight against excess weight, Forskolin 1020, as an herbal extract, has been presented as a global leader and a powerful weapon in the fight against excess weight and excess body fat.

The main effect of Forskolin 1020 is related to increasing the levels of cyclic AMP or cAMP /learn all about cAMP/, a process that triggers a chain reaction, the end result of which is the loss of body fat and the preservation of lean muscle mass. It is recommended that this process be combined with physical activity and increased intake of non-mineralized fluids to keep the body well hydrated. cAMP /learn all about cAMP/ also supports thyroid function, which regulates your metabolism. And by raising metabolic levels, you allow your body to develop its full potential in the process of burning excess fat. Losing weight doesn't have to be hard! Forskolin 1020 is an effective method that allows you to reduce unnecessary weight, quickly and effectively, in combination with a healthy and active lifestyle.
* Weight loss may vary from person to person. The best results are achieved with a suitable diet combined with exercise.
</div>
</div>
</div>
<div class="page-third pages-bg">
<div class="container">
<div class="page-info">
What is Forskolin 1020?
AND WHY IS IT SO EFFECTIVE?

Introducing the number one product in the US for the past year - Forskolin 1020 - a weight loss supplement that really works and will help you solve all your problems by allowing you to lose weight easily and quickly and help you achieve the figure you always wanted you've been dreaming!

Forskolin 1020 is a natural product with the main active ingredient extracted from the ancient plant "Coleus Forskohlii". In nature, "Coleus Forskohlii" is part of the mint family and grows in the wild subtropical regions of India, Burma and Thailand. For millennia, the local population has benefited from its healing properties, treating a number of health problems such as immune system failure, hypertension, pulmonary-aspiration diseases, hair loss, infections, glaucoma, oncological diseases... But thanks to modern medicine, recent scientific and clinical studies, and discoveries of its incredible benefits in the fight against excess weight, Forskolin 1020, as an herbal extract, has been presented as a global leader and a powerful weapon in the fight against excess weight and excess body fat.

The main effect of Forskolin 1020 is related to increasing the levels of cyclic AMP or cAMP /learn all about cAMP/, a process that triggers a chain reaction, the end result of which is the loss of body fat and the preservation of lean muscle mass. It is recommended that this process be combined with physical activity and increased intake of non-mineralized fluids to keep the body well hydrated. cAMP /learn all about cAMP/ also supports thyroid function, which regulates your metabolism. And by raising metabolic levels, you allow your body to develop its full potential in the process of burning excess fat. Losing weight doesn't have to be hard! Forskolin 1020 is an effective method that allows you to reduce unnecessary weight, quickly and effectively, in combination with a healthy and active lifestyle.
* Weight loss may vary from person to person. The best results are achieved with a suitable diet combined with exercise.
</div>
</div>
</div>
<div class="before-products">
<div class="container">
<p>How to achieve the body of your dreams, and fast? With Forskolin 1020/cAMP!
IS IT REALLY POSSIBLE TO LOSE UP TO 21 KG?*</p>
</div>
</div>
<div id="products">
<div class="container">
<div class="row">
 <?php
if (!empty($products)) {
	$load::getProducts($products, 'col-sm-4 col-md-3', false);
}
else {
?>
<div class="col-xs-12">
	<div class="alert alert-danger"><?= lang('no_products') ?></div>
</div>
<?php } ?>
</div>
</div>
</div>