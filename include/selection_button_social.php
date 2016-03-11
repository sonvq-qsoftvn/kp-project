<div class="show_box">
    <div class="view-selection-buttons">
        <a class="listing-view-btn"></a>
        <a class="calendar-view-btn"></a>
        <a class="weekly-events-btn"></a>
    </div>
    <div class="like_box <?php echo $social_mobile_class; ?>" style=" margin: 0 ;">
        <div style="margin: 4px;float:left;padding: 5px;">

            <?php $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
            <?php
            if ($_SESSION['langSessId'] == 'eng' || $_REQUEST['lang'] == 'eng') {
                $lang = "en_US";
                $url2 = $url . "/lang/eng";
            } else {
                $lang = "es_ES";
                $url2 = $url . "/lang/spn";
            }
            ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/<?php echo $lang ?>/all.js#xfbml=1&appId=1411675195718012";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            <div class="fb-share-button" data-href="<?php echo $url; ?>" data-type="box_count"></div>

            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url; ?>" data-via="Kpasapp" data-lang="<?php echo $language; ?>" data-related="anywhereTheJavascriptAPI" data-count="vertical" data-text="<?php if ($language == 'en') {
                echo strip_tags($objintro->f('page_content'));
            } else {
                echo strip_tags($objintro->f('page_content_sp'));
            } ?>">Tweet</a>

            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="tall"  lang="<?= $lang ?>"></div>

            <!-- Place this tag after the last +1 button tag. -->
            <script type="text/javascript">	    
            (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
            </script>

            <script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script>

            <!-- Place this tag where you want the su badge to render -->
            <su:badge layout="5"></su:badge>

            <!-- Place this snippet wherever appropriate -->
            <script type="text/javascript">
              (function() {
                var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
                li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
              })();
            </script>
        </div>
    </div>
</div>