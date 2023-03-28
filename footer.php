<footer class="footer">
    <div class="py-3">
        <div class="container flex-column flex-md-row align-items-md-center">
            <div class="footer-logo mt-1h mb-2">
                <?php the_custom_logo();?>
            </div>
            <?php wp_nav_menu(array("theme_location" => "footer-menu"));?>
        </div>
    </div>
    <p class="py-1h py-md-3 px-2 fs-12 w-100 footer-copyright bg-light text-center">Copyright © 2021 C-Lab Inc. All rights reserved</p>
</footer>
<div class="modal" id="modal_detail">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <!-- <div class="modal-header">
            <h1 class="ttl text-center w-100 fs-lg-32">Ｏリング式 湯口ブッシュ</h1>
            <button type="button" class="close"></button>
        </div>
        <div class="modal-body">
            <div class="content-post">
                <p>カラーの嵌合部、溶接部よりの水漏れをなくす為に発案。</p>
                <h3>■ 製作性の向上</h3>
                <ul>
                    <li>焼嵌・溶接と比べ組付けが簡単</li>
                    <li>水漏れ寿命のバラツキ無し</li>
                </ul>

                <h3>■ カラーの取外しが可能</h3>
                <ul>
                    <li>Ｏリングの交換ができる</li>
                    <li>冷却効率を低下させる、堆積物の除去ができる</li>
                </ul>
                <ul>
                    <li>本体、カラーの２ピース構造</li>
                    <li>Ｏリングは４種Ｄを使用</li>
                    <li>鋳造時は通水する事が絶対条件</li>
                </ul>
            </div>
            <figure class="thumbnail">
                <img src="<?php echo get_template_directory_uri(); ?>/common/images/popup-1.png" alt="Ｏリング式 湯口ブッシュ">
            </figure>
        </div> -->
    </div>
</div>
<div class="loader"><span></span></div>
<?php wp_footer();?>
</body>
</html>
