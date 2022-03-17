<section class="page colecao clearfix">
    <script type="text/javascript">
        JOMOS.engine.findPageByHash('colecao').data = <?php echo $dados;?>  ;
        console.log(JOMOS.engine.findPageByHash('colecao').data);
    </script>
    <div class="header">
            <div class="icone-mobile" id="abre">
                <a href="javascript:void(0);">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 28 28" style="padding:5vw;" xml:space="preserve">
                    <style type="text/css">
                        .st0{fill-rule:evenodd;clip-rule:evenodd;fill:dodgerblue;}
                    </style>
                    <path class="st0" d="M0,0h28v4H0V0z"/>
                    <path class="st0" d="M7,12h14v4H7V12z"/>
                    <path class="st0" d="M0,24h28v4H0V24z"/>
                    </svg>
                </a>
            </div>
    </div>

    <div class="dark clearfix"></div>
    <div class="modalProduto">
        <a href="X"><span>X</span></a>
        <div class="pdt clearfix">
            <div class="pdtleft">
                <div class="ibagemtop">
                    <img src="img/produto/full/01.jpg"/>
                </div>
                <p class="pcor">Referêcia aqui 123</p>
            </div>
            <div class="asideAnother">
                <ul>
                    <li><img src="img/produto/01.jpg"/></li>
                    <li><img src="img/produto/01.jpg"/></li>
                    <li><img src="img/produto/01.jpg"/></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="model">
        <div class="box1 clearfix">
            <div class="align">
                <h2><?php echo $translate['colecao'][0] ?></h2>
                <p>
                    <?php echo $translate['colecao'][1] ?>
                </p>
                <ul></ul>
            </div>
        </div>
        <div class="box2" >
            <ul class="clearfix ListagemProdutos" style="">

            </ul>
        </div>
    </div>

    <div class="box3 navBanner">
        <div class="esquerdaNav"></div>
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="direitaNav"></div>
    </div>
</section>
