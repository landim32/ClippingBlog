
<!-- FOOTER -->
<table class="email-footer">
    <tr>
        <td width="600" height="180" bgcolor="#404041">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td align="center">
                        <p style="color:#fff; font-size: 18px;">Siga-nos nas redes sociais!</p>
                        <?php if (defined("FACEBOOK_URL")) : ?>
                        <a href="<?php echo FACEBOOK_URL; ?>">
                            <img src="<?php echo SITE_URL . TEMA_PATH; ?>/images/facebook-icon.png" alt="Facebook" />
                        </a>
                        <?php endif; ?>
                        <?php if (defined("TWITTER_URL")) : ?>
                        <a href="<?php echo TWITTER_URL; ?>">
                            <img src="<?php echo SITE_URL . TEMA_PATH; ?>/images/twitter-icon.png"/>
                        </a>
                        <?php endif; ?>
                        <?php if (defined("LINKEDIN_URL")) : ?>
                            <a href="<?php echo LINKEDIN_URL; ?>">
                                <img src="<?php echo SITE_URL . TEMA_PATH; ?>/images/linkedin-icon.png"/>
                            </a>
                        <?php endif; ?>
                        <?php if (defined("GITHUB_URL")) : ?>
                            <a href="<?php echo GITHUB_URL; ?>">
                                <img src="<?php echo SITE_URL . TEMA_PATH; ?>/images/github-icon.png"/>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td align="center" valign="top" width="350">
                        <p style="color:#fff; font-size: 12px;">
                            <a href="mailto:<?php echo EMAIL; ?>"><?php echo EMAIL; ?></a>
                            <?php if (defined("TELEFONE")) : ?>
                            | <?php echo TELEFONE; ?>
                            <?php endif; ?>
                            | <a href="<?php echo SITE_URL; ?>"><?php
                                $urlSite = SITE_URL;
                                $urlSite = str_replace("http://www.", "", $urlSite);
                                $urlSite = str_replace("https://www.", "", $urlSite);
                                $urlSite = str_replace("http://", "", $urlSite);
                                $urlSite = str_replace("https://", "", $urlSite);
                                echo $urlSite;
                                ?></a><br/>

                            <span style="color: #fff; font-size: 10px;">
                                Copyright &copy; <?php date('Y'); ?>. Emagine - Todos os direitos reservados.
                            </span>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    <tr>
</table>

</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>