
<!-- Include header, and stylesheet-->
<?php include 'assets/templates/header.php'; ?>
    <style> <?php include 'assets/home/style.css'; ?> </style>

    <section class="home" id="home">
        <div id="particles-js"></div>
            <div class="homeoverlay" >
                <div class="max-width">
                    <div class="home-content rellax rellax-first" data-rellax-speed="-3">
                        <div class="text-1"><span class="before-txt">I'm </span><span class="txt-type" data-wait="3000" data-words='["Kārlis Barbars.", "a developer.", "a designer."]'></span></div>
                        <div class="homeline"></div>
                        <p class="under-text">Connect with me or check out my work.</p>

                        <div class="social">
                            <a href="https://www.instagram.com/kabarbars/" target="_blank"><i class="fab fa-instagram" style="font-size:20px;"></i></a>
                            <a href="https://www.facebook.com/zeatzijs" target="_blank"><i class="fab fa-facebook-square" style="font-size:20px;"></i></a>
                            <a href="https://twitter.com/keeethus" target="_blank"><i class="fab fa-twitter" style="font-size:20px;"></i></a>
                            <a href="https://discord.com/channels/@me/keethus#6634" target="_blank"><i class="fab fa-discord" style="font-size:20px;"></i></a>
                            <a href="https://github.com/keethus" target="_blank"><i class="fab fa-github" style="font-size:20px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <section class="about">
    <div id="about" style="position:relative; top: -300px; display: hidden;"></div>
        <div class="max-width">
            <h2 class="title">Hello, I am Kārlis Barbars!</h2>
            <div class="about-content">
                <div class="column left">
                    <span class="accent-clr"><h3>some words about me</h3></span>
                        <p>I’m a Latvia, Cesis-based developer powered by VS Code and coffee.<br>
                        I have a diverse set of skills, ranging from design to <span class="accent-clr"><b>HTML</b></span> + <span class="accent-clr"><b>CSS</b></span> + <span class="accent-clr"><b>PHP</b></span>. I also use <span class="accent-clr"><b>Python</b></span> for Artificial Intelligence and Machine Learning. One of my favorite things to do is working with tech, for example, smart-home projects with Arduino which requires <span class="accent-clr"><b>C++</b></span> and <span class="accent-clr"><b>C#</b></span> language skills. Picking up a new framework or language isn’t a problem.
                        <br><br>
                        I have worked as a free-lancer and in a marketing agency. I also have contributed to some World of Warcraft private server development, community management, and customer support. One of which was known world-wide by thousands of players and pushed Blizzard Ent. to release their official version of the game. 
                        <br><br>
                        I’m comfortable developing on the frontend or backend as well as setting up or managing infrastructure.
                        </p>
                    </div>
                <div class="column right max-width">
                    <img src="assets/images/profile.jpg">
                </div>
                <div class="to-projects-div">
                <a href="#" class="to-projects btn"><span>check out my projects<span></a>
                </div>
            </div>
        </div>
    </section>
    <section class="work-process" id="work-process">
        <div class="work-overlay ">
            <div class="max-width">
                <h3 class="title"><span class="accent-clr accent-big">“</span>Good code is its own best documentation.<span class="accent-clr accent-big">”</span></h3>
                <p>– Steve McConnell</p>
            </div>
        </div>
    </section>
    <section class="latest-blogs">
        <div class="max-width">
            <h2 class="title">Latest blogs</h2>
            <div class="blogs-content">
                <div class="card">
                    <div class="box">
                    <img src="assets/images/box1.jpg">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <img src="assets/images/box2.jpg">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <img src="assets/images/box3.jpg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script> var rellax = new Rellax('.rellax'); </script>
    <script src='assets/home/script.js'></script>
    <script src='assets/home/particles.js'></script>
    <script src='assets/home/particles-cfg.js'></script>

    <?php include 'assets/templates/footer.php' ?>