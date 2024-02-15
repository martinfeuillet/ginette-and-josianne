<?php 
/**
 * Sends an email notification when a product is out of stock.
 *
 * @param {string} product_url - The URL of the product.
 * @param {string} product_name - The name of the product.
 * @param {string} product_thumbnail - The thumbnail image URL of the product.
 * @return {string} The HTML content of the email.
 */
function send_out_of_stock_email($product_url, $product_name, $product_thumbnail) {
    $content = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="format-detection" content="telephone=no">
        <title>Ginette et Josiane</title>
        <!--[if (gte mso 9)|(IE)]>
            <style type="text/css">
                table,
                table td {border-collapse:collapse;}
                table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
            </style>
            <![endif]-->
        <style>
            #outlook a {
                padding: 0
            }
            body {
                font-family: \'Raleway\', sans-serif;
                width: 100% !important;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
                margin: 0;
                padding: 0
            }
            .ExternalClass {
                width: 100%
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%
            }
            img {
                -ms-interpolation-mode: bicubic
            }
            .bwfan-product-image {
                border-radius: 10px !important;
                padding-top: 0 !important;
            }
            .bwfan-product-grid-container div h4 a {
                text-decoration: none !important;
                color:#404040 !important;
                font-size: 12px !important;
    
            }
            @media screen and (-webkit-min-device-pixel-ratio:0) {}
            @-moz-document url-prefix() {}
            @import url(\'https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap\');
        </style>
    </head>
    
    <body style="margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#f0f0f0">
        <table cellpadding="0" cellspacing="0" style="width:100%;background-color:#f0f0f0">
    
    
            <tr>
    
                
                <td style="text-align:center;background-color:#f0f0f0">
    
                    <!--[if (gte mso 9)|(IE)]>
                        <table width="640" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr><td>
                        <![endif]-->
    
                    <table cellpadding="0" cellspacing="0" align="center"
                        style="background-color:#ffffff;margin:0 auto;width:100%;max-width:640px">
    
          
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width:100%">
                                    <tr>
                                        <td style="padding:20px 0" align="center">
                                            <a href="https://www.ginetteetjosiane.com/"
                                                style="color:#000000;text-decoration:none"><img align="center" width="65"
                                                    height="auto"
                                                    style="display:block;border-width:0;font-family:Helvetica,Helvetica,sans-serif;font-size:25px;color:#000000;background-color:#ffffff;"
                                                    src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/02/logo-gj.png"
                                                    alt="Logo Ginette et Josiane" border="0" /></a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
    
    
                        <tr>
                            <td style="text-align:center;font-size:0;border-top:1px solid #f1f1f1;padding-top:5px;">
    
                                <!--[if (gte mso 9)|(IE)]>
                                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                                    <tr><td style="width:50%;" valign="top"><![endif]-->
    
                                <table cellpadding="0" cellspacing="0"
                                    style="display:inline-block;width:100%;max-width:320px;vertical-align:top;">
                                    <tr>
                                        <td
                                        style="text-align:center;width:1%;padding:10px 5px;font-family:\'Mulish\',sans-serif;color:#565656;font-size:12px;font-weight:bold;;text-transform: uppercase;">
                                        <a href="https://www.ginetteetjosiane.com/e-select-store-home"
                                            style="color:#3A3A3A;text-decoration:none">Boutique</a>
                                        </td>
                                        <td
                                        style="text-align:center;width:1%;padding:10px 5px;font-family:\'Mulish\',sans-serif;color:#565656;font-size:12px;font-weight:bold;;text-transform: uppercase;">
                                        <a href="https://www.ginetteetjosiane.com/recettesl"
                                            style="color:#3A3A3A;text-decoration:none">Recettes</a>
                                        </td>
                                        <td
                                        style="text-align:center;width:1%;padding:10px 5px;font-family:\'Mulish\',sans-serif;color:#565656;font-size:12px;font-weight:bold;text-transform: uppercase;">
                                        <a href="https://www.ginetteetjosiane.com/fodmap/"
                                        style="color:#3A3A3A;text-decoration:none">Fodmap</a>
                                        </td>                                  
                                    </tr>
                                </table>
    
                                <!--[if (gte mso 9)|(IE)]>
                                    </td><td style="width:50%;" valign="top"><![endif]-->
    
                                <table cellpadding="0" cellspacing="0"
                                    style="display:inline-block;width:100%;max-width:320px;vertical-align:top">
                                    <tr>
                                        <td
                                        style="text-align:center;width:1%;padding:10px 5px;font-family:\'Mulish\',sans-serif;color:#565656;font-size:12px;font-weight:bold;text-transform: uppercase;">
                                        <a href="https://www.ginetteetjosiane.com/cure-care/"
                                            style="color:#3A3A3A;text-decoration:none">Cure&Care</a>
                                        </td>
                                        <td
                                        style="text-align:center;width:1%;padding:10px 5px;font-family:\'Mulish\',sans-serif;color:#565656;font-size:12px;font-weight:bold;text-transform: uppercase;">
                                        <a href="https://www.ginetteetjosiane.com/magazine-des-josiettes"
                                            style="color:#3A3A3A;text-decoration:none">Le mag</a>
                                        </td>
                                        <td
                                        style="text-align:center;width:1%;padding:10px 5px;font-family:\'Mulish\',sans-serif;color:#565656;font-size:12px;font-weight:bold;text-transform: uppercase;">
                                        <a href="https://www.ginetteetjosiane.com/devenir-une-josiette"
                                            style="color:#3A3A3A;text-decoration:none">Adhésion</a>
                                        </td>
                                    </tr>
                                </table>
    
                                <!--[if (gte mso 9)|(IE)]>
                                    </td></tr></table><![endif]-->
    
                            </td>
                        </tr>
    
    
    
                        <tr>
                            <td align="center"
                                style="background-color:#FFFFFF; padding-top:5px;">
                                <a href="https://www.ginetteetjosiane.com/"
                                    target="_blank">
                                        <img align="center" width="100%"
                                        height="auto"
                                        style="display:block;border-width:0;"
                                        src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/10/hero-newsletter-scaled.jpg"
                                        alt="Heroheader" border="0" />
                                </a>
                            </td>
                        </tr>
    
                        <tr>
                            <td align="center"
                                style="background-color:#ffffff;font-weight:300;font-size:16px;color:#565656;line-height: 26px;text-align:center;padding:20px 20px 10px;">
                                <a href="https://www.ginetteetjosiane.com/"
                                target="_blank"
                                    style="color:#565656;text-decoration:none">
                                    Hello,
                                </a>
                                </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="background-color:#ffffff;font-weight:300;font-size:16px;color:#565656;line-height: 26px;text-align:left;padding:10px 20px 10px;">
                                <a href="https://www.ginetteetjosiane.com/"
                                target="_blank"
                                    style="color:#565656;text-decoration:none">
                                    Tu souhaites <b>être informé de la disponibilité</b> du produit ' . $product_name . ' de notre eshop.
                                </a>
                                </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="background-color:#ffffff;font-weight:300;font-size:16px;color:#565656;line-height: 26px;text-align:left;padding:10px 20px 0px;">
                                <a href="https://www.ginetteetjosiane.com/"
                                target="_blank"
                                    style="color:#565656;text-decoration:none">
                                    Nous te <b>tiendrons au courant</b> par mail dès que ta pépite sera de nouveau disponible.
                                </a>
                                </td>
                        </tr>
    
    
                        <tr>
                            <td  align="center"
                            style="padding:0px 20px 0px">
                                <table cellpadding="0" cellspacing="0"
                                style="background-color:#ffffff;margin:0 auto;width:100%;max-width:240px;text-align: center;">
                                <tr>
                                    <td align="center" style="width: 100%;">
                                        <a href="' . $product_url . '"
                                        target="_blank"
                                        style="font-size:13px;line-height:28px;text-align:center;padding:0px 20px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                        <p style="padding:0px 0px 0px;font-weight:bold;font-size:14px;color:#565656;text-transform: uppercase;">' . $product_name . '</p>    
                                        <img align="center" width="100%"
                                            height="auto"
                                            style="display:block;border-width:0; object-fit:contain;" src="'. $product_thumbnail .'" alt="Produit 1">
                                        </a>
                                    </td>
                                </tr>
                                </table>
                            </td>
                            </tr>
    
                            <tr>
                                <td align="center"
                                    style="background-color:#ffffff;font-weight:bold;font-size:18px;color:#565656;line-height: 26px;text-align:center;padding:10px 20px 10px;">
                                    <a href="https://www.ginetteetjosiane.com/"
                                    target="_blank"
                                        style="color:#565656;text-decoration:none">
                                        L\'occasion, au passage, de découvrir nos nouveautés : 
                                    </a>
                                    </td>
                            </tr>
                            <tr>
                                <td  align="center"
                                style="padding:0px 20px 0px">
                                    <table cellpadding="0" cellspacing="0"
                                    style="background-color:#ffffff;margin:0 auto;width:100%;max-width:640px">
                                    <tr>
                                        <td align="center" style="width: 33%;">
                                            <a href="https://www.ginetteetjosiane.com/epicerie/nouveautes/beurre-de-cacahuete-avec-morceaux-bio-mandy-copie"
                                            target="_blank"
                                            style="font-size:13px;line-height:28px;text-align:center;padding:10px 20px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                                <img align="center" width="100%"
                                                height="auto"
                                                style="display:block;border-width:0; object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/05/74.png.webp" alt="Produit 1">
                                                <p style="padding:0px 0px 0px">Beurre de<br>cacahuète</p>
                                            </a>
                                        </td>
                                        <td align="center" style="width:0.5%;background-color: white;">
                                        </td>
                                        <td align="center" style="width: 33%;">
                                            <a href="https://www.ginetteetjosiane.com/epicerie/nouveautes/mix-farines-low-fodmap"
                                            target="_blank"
                                            style="font-size:13px;line-height:28px;text-align:center;padding:10px 20px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                                <img align="center" width="100%"
                                                height="auto"
                                                style="display:block;border-width:0; object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/09/INF-3.png.webp" alt="Produit 2">
                                                <p style="padding:0px 0px 0px">Bake to<br>basics </p>
                                            </a>
                                        </td>
                                        <td align="center" style="width:0.5%;background-color: white;">
                                        </td>
                                        <td align="center" style="width: 33%;">
                                            <a href="https://www.ginetteetjosiane.com/epicerie/nouveautes/arrow-root-nutme"
                                            target="_blank"
                                            style="font-size:13px;line-height:28px;text-align:center;padding:10px 20px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                                <img align="center" width="100%"
                                                height="auto"
                                                style="display:block;border-width:0; object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/09/107.png.webp" alt="Produit 3">
                                                <p style="padding:0px 0px 0px">Arrow-root<br>nut&me</p>
                                            </a>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                                </tr>
    
    
                        <tr>
                            <td align="center"
                                style="background-color:#ffffff;font-weight:300;font-size:16px;color:#565656;line-height: 26px;text-align:left;padding:10px 20px 10px;">
                                <a href="https://www.ginetteetjosiane.com/"
                                target="_blank"
                                    style="color:#565656;text-decoration:none">
                                    Besoin de faire le point ? Besoin d\'en parler ? Fais le bilan de tes symptômes en ligne et retrouve tous nos G.I.JO directement sur notre site. 
                                </a>
                                </td>
                        </tr>
    
                        <tr>
                            <td align="center"
                            style="padding: 10px 20px 0px; background-color:#ffffff ;">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center"
                                            style="font-weight:bold;border-radius:20px;text-align:center;"
                                            bgcolor="#f66996">
                                            <a href="https://www.ginetteetjosiane.com/"
                                                target="_blank"
                                                style="font-size:13px;font-weight:bold;color: #FFFFFF;text-decoration:none;text-transform:uppercase; padding:14px 28px;background-color:#C35939;border-radius:20px;display: inline-block;">Je vais sur le site !</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
    
    
    
            
                        <tr>
                            <td align="center"
                                style="background-color:#ffffff;font-weight:300;font-size:16px;color:#565656;line-height: 26px;text-align:center;padding:10px 20px 10px;">
                                <a href="https://www.ginetteetjosiane.com/"
                                target="_blank"
                                    style="color:#565656;text-decoration:none">
                                    1, 2, c\'est parti !
                                </a>
                                </td>
                        </tr>
    
    
                        <tr>
                            <td style="padding:20px 20px 10px;">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="background:#eeeeee" height="2"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
    
    
                        <tr>
                            <td  align="center"
                            style="padding:10px 20px 10px;background-color:#FFFFFF">
                                <table cellpadding="0" cellspacing="0"
                                style="margin:0 auto;width:100%;max-width:200px">
                                <tr>
                                    <td align="center">
                                        <a href="https://www.instagram.com/ginetteetjosiane/?hl=fr"
                                        target="_blank"
                                        style="font-size:13px;line-height:28px;text-align:right;padding:05px 10px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                            <img align="center" width="30px" height="auto"
                                            style="border-width:0;text-align:right;object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/10/instagram_josiettejosiane.jpg" alt="Instagram">
                                        </a>
                                    </td>
                                    <td align="right">
                                        <a href="https://www.youtube.com/channel/UCTGTeMl2x93opOElRNk3BYQ"
                                        target="_blank"
                                        style="font-size:13px;line-height:28px;text-align:right;padding:05px 10px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                            <img align="center" width="30px" height="auto"
                                            style="border-width:0;text-align:right;object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/10/youtube_josiettejosiane.jpg" alt="Youtube">
                                        </a>
                                    </td>
                                    <td align="right">
                                        <a href="https://www.facebook.com/Ginette-et-Josiane-102481761665893/"
                                        target="_blank"
                                        style="font-size:13px;line-height:28px;text-align:right;padding:05px 10px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                            <img align="center" width="30px" height="auto"
                                            style="border-width:0;text-align:right;object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/10/facebook_josiettejosiane.jpg" alt="Facebook">
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="https://www.linkedin.com/company/ginette-et-josiane"
                                        target="_blank"
                                        style="font-size:13px;line-height:28px;text-align:right;padding:05px 10px 0px;color:#565656;text-decoration:none;margin:0;text-transform: uppercase;">
                                            <img align="center" width="30px" height="auto"
                                            style="border-width:0;text-align:right;object-fit:contain;" src="https://www.ginetteetjosiane.com/wp-content/uploads/2023/10/linkedin_josiettejosiane.jpg" alt="Linkedin">
                                        </a>
                                    </td>
                                </tr>
                                </table>
                            </td>
                            </tr>
                            <tr>
                                <td style="background-color: #FFFFFF;color: #3A3A3A;font-family:\'Mulish\',sans-serif;text-align:center;padding:10px 40px 10px;"
                                    align="center">
                                    <a style="font-size:13px;color: #3A3A3A;text-decoration:none;text-transform:uppercase;margin:0px;" 
                                    href="https://www.ginetteetjosiane.com/"><b>Ginette et Josiane</b></a>                       
                                </td>
                            </tr>
                        <tr>
                            <td style="background-color: #FFFFFF;color: #3A3A3A;font-family:\'Mulish\',sans-serif;text-align:center;padding:0px 40px 20px;"
                                align="center">
                                <a style="font-size:12px;color: #3A3A3A;text-decoration:none;margin:0px;" 
                                href="https://www.ginetteetjosiane.com/">La plateforme dédiée au syndrome de l\'intestin irritable et
                                autres troubles digestifs.</a>                       
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #c35939; line-height:16px;color: #FFFFFF;font-family:\'Mulish\',sans-serif;font-size:11px;text-align:center;padding:15px 20px 15px;"
                                align="center">
                                    Vous ne souhaitez pas rester informé ? Nous serons tristes de vous voir partir, mais vous pouvez <a href="{{unsubscribe_link}}" style="text-decoration:underline;color:#FFFFFF;">cliquez-ici</a> pour vous désabonner.
                            </td>
                        </tr>
                    </table>
    
                    <!--[if (gte mso 9)|(IE)]>
                        </td></tr></table><![endif]-->
    
    
    
    
        </td>
    </tr>
    
    </table>
    
    </body>
    
    </html>
    ';

    return $content;
}