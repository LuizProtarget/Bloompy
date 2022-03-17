<section id="contato" class="contato page clearfix">
    <div style="padding: 90px 0 0 0;">
        <h2>
            Fale conosco
        </h2>
        <p>
           Se você tem alguma dúvida, crítica ou sugestão, ou quer saber mais sobre a Bloompy, entre em contato conosco. 
        </p>
        <form action="contato/site/add" method="post">
            <input type="hidden" name="ajax"  value="1"/>
			<input type="text" name="name" required placeholder="Nome" value=""/>
            <input type="text" name="email" required placeholder="E-mail" value=""/>
            <input type="text" name="fone" placeholder="Telefone" value=""/>
            <input type="text" name="state" placeholder="Estado" value=""/>
            <input type="text" name="city" placeholder="Cidade" value=""/>
            <input type="text" name="subject" required placeholder="Assunto" value=""/>
            <textarea name="body" placeholder="Mensagem" required style="margin: 2px 0 0 2px;"></textarea>
			<span class="message" styel="display:none;"></span>
            <button type="submit">ENVIAR ></button>
        </form>
        <div class="map">
            <!-- <div class="map1"></div> -->
            <iframe style="margin-top: 12px;" width="235" height="175" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.br/maps?f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=Rua+dos+metais,+398,+canela+,+RS,+Brasil.&amp;aq=&amp;sll=-29.383073,-51.118355&amp;sspn=0.196845,0.383492&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=R.+dos+Metais,+398,+Canela+-+Rio+Grande+do+Sul,+95680-000&amp;ll=-29.332353,-50.789709&amp;spn=0.013095,0.020084&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
            <p>
                <strong>BLOOMPY, CALÇADOS HOFFLLES LTDA</strong><br/>
                (54) 3282-4046<br/>
                Rua dos Metais, 398, Distrito Industrial, Canela / RS - Brasil
            </p>
        </div>
    </div>
</section>
