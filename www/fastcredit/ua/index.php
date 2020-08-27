<?php require_once __DIR__.'/offers_api/OffersAPI.php'; ?>
<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title>
        Кредит онлайн — взяти кредит на картку через інтернет без довідок та поручителів
    </title>
    <meta name="description" content="Швидкий кредит онлайн на картку від 0%. Без довідок та поручителів. Цілодобово. Порівняй і вибери найкращі умови!">
    <link rel="stylesheet" href="/css/style-fastcredit.css">
    <link rel="stylesheet" href="/css/newmodal.css">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <style>
        .entry-content h2{
            display: none;
        }
        .modal_title:before{
            background-image: url(/img/wave-dark.svg);
        }
    </style>
    <!-- Google Tag Manager -->
<script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K77TQB8');
</script>
    <!-- End Google Tag Manager -->
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "91b475a9-fb9e-4ddd-9d2c-e1e042b5679e",
            });
        });
    </script>
    <script>window.searchUrl = 'https://tinyurl.com/yywy6gdb';</script>
</head>
<body>
    <input id="domain" style="display: none;" type="text" value="fastcredit">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K77TQB8"
height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
        <div class="wrapper" style="padding-bottom: 0;">
            <div class="logo">Fast<span>Credit</span></div>
        </div>
        <div class="wrapper" style="padding-top: 0">
            <h1 style="color:#fff;text-align: center;font-size: 24px;">
                Вам схвалено кредит у наступних компаніях
            </h1>
            <h2 style="color:#fff;font-size: 20px;text-align: center;margin: 0;padding: 0;">
                Для 100% одобрення відправте 3-4 заявки и отримайте найкращі умови кредиту
            </h2>
        </div>
    </header>
    <main>
        <div class="entry-content">
            <?php (new OffersAPI)->displayOffers(); ?>
        </div>
    </main>
    <footer>
        <div class="wrapper">
            <div class="policy_text">Fastcredit – це платформа з пропозиціями кредитних організацій. Ми не є фінансовою організацією, банком чи кредитором. Підрахунки носять приблизний характер, остаточні умови уточнюйте на сайті кредитної компанії.</div>
        </div>
    </footer>
    <a href="http://bit.ly/2HlaV3m" target="_blank" class="viber_chat"></a>

    <script src="/js/jquery-3.1.1.js"></script>
    <script src="/js/modal.js"></script>
    <script src="/js/href_replacer.js"></script>
    <?php include_once($_SERVER["DOCUMENT_ROOT"]) .'/uaModals/modal-fastcredit.php' ?>
    <script src="/index.min.js?v20180913"></script>
</body>
</html>