<?php
$infoComplementar ='';
if (!empty($_POST['telefone']) && !empty($_POST['linkedin'])) {

    $url = explode("https://www.linkedin.com/", $_POST['linkedin']);
    $linkedin = $url[1];

    $infoComplementar ='<span style="font-size: 13px; display: flex; align-items: center; margin-top: 5px">
        <img src="https://www.wapstore.com.br/assinatura-email/img/whatsapp.png" width="14px" height="14px">&nbsp;' . $_POST['telefone'] . '
    </span>
    <span style="font-size: 13px; display: flex; align-items: center;">
        <img src="https://www.wapstore.com.br/assinatura-email/img/linkedin.png" width="14px" height="14px">
            &nbsp; <a href="'.$_POST['linkedin'].'" style="color:#000000; text-decoration:none">' . $linkedin . '</a>
    </span>';
    }

    $htmlContent = '<table width="549px" height="121px" cellspacing="0" cellpadding="0" border="0" border="0" style="width: 549px; height: 121px; color:#000000; background-color: #F8F8F8; font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;">
    <tr>
        <td width="32px" height="121px" style="display: table-cell; vertical-align: top;"> 
            <img src="https://www.wapstore.com.br/assinatura-email/img/2023/selo-gptw.png" /> 
        </td>
        <td width="92px" height="121px"> 
            <div style="width: 84px; height: 84px; border-radius: 57%; position: relative; float: left; padding: 3px; border: #FE5000 1px solid; margin: 13px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                <img style="width: 84px; height: 84px;" src="' . $value['photo_small'] . '" /> 
            </div>
        </td>
        <td width="204px" height="121px">
            <span style="font-size: 16px; font-weight: 500; display: flex;">
                ' . $value['name'] . '
            </span>
            <span style="font-size: 13px; display: flex;">
                ' . $value['title'] . '
            </span>
            '.$infoComplementar.'
        </td>
        <td width="195px" height="121px">
            <div class="lat-dir-wapstore" style="width: 195px; height: 121px; -webkit-border-top-left-radius: 35px; -webkit-border-bottom-left-radius: 35px; -moz-border-radius-topleft: 35px;-moz-border-radius-bottomleft: 35px;border-top-left-radius: 35px;border-bottom-left-radius: 35px; background-color: #FE5000; float: left;">
                <div class="logo-wapstore-branco" style="margin: 26px 0px 0px 40px; width: 100%; float: left;">
                    <img src="https://www.wapstore.com.br/assinatura-email/img/2023/wap.store-white.png" />
                </div>
                <div class="url-wapstore-branco"
                    style="color: #ffffff; font-size: 13px; width: 100%; float: left; text-decoration: none; margin-left: 40px;">
                    <a href="http://www.wapstore.com.br" style="color: #ffffff; text-decoration: none;">wapstore.com.br</a>
                </div>
                <div class="redes-sociais" style="width: 100%; float: left;">
                    <div class="instagram" style="width: 15px; height: 15px; float: left; margin: 10px 0 0 38px;">
                        <a href="https://www.instagram.com/wap.store.plataforma/?hl=pt">
                            <img src="https://www.wapstore.com.br/assinatura-email/img/2023/icone_insta.png" />
                        </a>
                    </div>
                    <div class="linkedin" style="width: 15px; height: 15px; float: left; margin: 10px 0 0 10px;">
                        <a href="https://www.linkedin.com/company/wapstore-plataforma/mycompany/">
                            <img src="https://www.wapstore.com.br/assinatura-email/img/2023/icone_lkd.png" />
                        </a>
                    </div>
                    <div class="youtube" style="width: 15px; height: 15px; float: left; margin: 13px 0 0 10px;">
                        <a href="https://www.youtube.com/c/wapstore-plataforma/videos">
                            <img src="https://www.wapstore.com.br/assinatura-email/img/2023/icone_yt.png" />
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>';