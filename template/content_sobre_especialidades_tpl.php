<?php

// Páginas acessórias apenas que mostram dados da clinica

function sobre()
{ ?>

    <section id='content_sobre'>

        <div class="sobre-texto">
            <h2>Sobre a Clínica</h2>
            <p>Bem-vindo à Clínica Saúde Viva. Somos uma clínica dedicada a oferecer os melhores cuidados de saúde para nossos
                pacientes. Nossa missão é proporcionar um atendimento de excelência, com profissionais qualificados e uma
                estrutura moderna para garantir o bem-estar e a saúde de todos.</p>
            <p>Oferecemos uma gama de serviços médicos especializados, com foco em tratamentos personalizados. Nosso objetivo é
                proporcionar a melhor experiência de cuidado, com respeito e humanização.</p>
        </div>

        <!-- Seção da presidência da clínica -->
        <div class="board-section">
            <h2>Presidência da Clínica</h2>
            <div class="board-members">
                <div class="member">
                    <a href="./presidente1.php"> <!-- Link para a página do presidente 1 -->
                        <img src="images/2.jpg" alt="Presidente 1">
                        <p>Dr. João Silva</p>
                    </a>
                </div>
                <div class="member">
                    <a href="./presidente2.php"> <!-- Link para a página do presidente 2 -->
                        <img src="images/1.jpeg" alt="Presidente 2">
                        <p>Dra. Maria Oliveira</p>
                    </a>
                </div>
                <div class="member">
                    <a href="./presidente3.php"> <!-- Link para a página do presidente 3 -->
                        <img src="images/3.jpg" alt="Presidente 3">
                        <p>Dr. Pedro Costa</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Caixa com o mapa -->
        <div class="map-container">
            <h2>Nossa localização</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.779496735898!2d-8.6106519!3d41.1270329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2464d1d29d0b01%3A0x349f1753d4a48f56!2sCl%C3%ADnica%20Lus%C3%ADadas%20Gaia!5e0!3m2!1spt-PT!2spt!4v1697123456789!5m2!1spt-PT!2spt"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>

            <!-- Endereço abaixo do mapa -->
            <div class="address">
                <p>Av. da República 1294, 4430-192 Vila Nova de Gaia</p>
            </div>
        </div>
    <?php } ?>

    <?php

    function especialidades()
    { ?>
        <section id='content_especialidade'>
            <!-- Div para o texto introdutório -->
            <div class="especialidades-texto">
                <h2>Especialidades</h2>
                <p>Conheça as principais especialidades médicas que oferecemos, com profissionais altamente capacitados para cuidar
                    de sua saúde em diversas áreas. Nossos médicos especializados estão prontos para fornecer um atendimento de
                    excelência, com diagnóstico preciso, tratamentos inovadores e um cuidado dedicado para o bem-estar de nossos
                    pacientes.</p>
            </div>

            <!-- Div para a lista de especialidades -->
            <div class="especialidades-container">
                <article class="especialidade">
                    <div class="especialidade-content">
                        <h3>Cardiologia</h3>
                        <p>A Cardiologia é a especialidade médica dedicada ao diagnóstico, tratamento e prevenção de doenças do coração e
                            do sistema cardiovascular.</p>
                    </div>
                    <img src="../images/4.jpg" alt="Cardiologia">
                </article>

                <article class="especialidade">
                    <div class="especialidade-content">
                        <h3>Ortopedia</h3>
                        <p>Ortopedia é a especialidade que trata das doenças e lesões dos ossos, ligamentos e articulações, abrangendo o tratamento de fraturas e luxações.</p>

                    </div>
                    <img src="../images/5.jpg" alt="Ortopedia">
                </article>

                <article class="especialidade">
                    <div class="especialidade-content">
                        <h3>Pediatria</h3>
                        <p>A Pediatria é a especialidade que cuida da saúde das crianças, desde o nascimento até a adolescência, abordando
                            aspectos físicos e emocionais.</p>
                    </div>
                    <img src="../images/6.jpg" alt="Pediatria">
                </article>
            </div>
            </div>
        </section>
    <?php } ?>