<?php if(get_theme_mod('ie8_alert',0)): ?>
<!--[if IE 8]>
<link href="<?php echo $tmpl_url; ?>/css/ie8-alert.css" rel="stylesheet" />
<div class="ie8-alert">You are using an unsupported version of Internet Explorer. To ensure security, performance, and full functionality, <a href="http://browsehappy.com/?locale=<?php get_locale(); ?>">please upgrade to an up-to-date browser.</a></div>
<![endif]-->
<?php endif;
if(get_theme_mod('ie9_alert',0)): ?>
<!--[if IE 9]>
<link href="<?php echo $tmpl_url; ?>/css/ie9-alert.css" rel="stylesheet" />
<div class="ie9-alert">You are using an unsupported version of Internet Explorer. To ensure security, performance, and full functionality, <a href="http://browsehappy.com/?locale=<?php get_locale(); ?>">please upgrade to an up-to-date browser.</a><i></i></div>
<script>jQuery('.ie9-alert i').click(function(){jQuery('.ie9-alert').hide();});</script>
<![endif]-->
<?php endif;
echo get_theme_mod('disqus_shortname') ? '<script src="//' . get_theme_mod('disqus_shortname') . '.disqus.com/embed.js"></script>' : ''; ?>