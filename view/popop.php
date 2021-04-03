<?php $title = "popop";$css = "popop.css"?>
<?php ob_start(); ?>

  
<script>


        play = false;
        var ha = new Audio('../assets/Haaaaaaaaaaaaaa.mp3');
        var ho = new Audio('../assets/hooooooooooooaa.mp3');
        var hoa = new Audio('../assets/hoaaa.mp3');


        function has () {
            if (play) {
                ha.play()
            } else {
                g = 1;
            }
        }
        function hoas () {
            if (play) {
                hoa.play();
            } else {
                g = 1;
            }
            
        }
        function hos () {
            if (play){
                ho.play()
            } else {
                g = 1;
            }
        }



document.addEventListener('keydown', function (e){
    if( e.keyCode == 'P'.charCodeAt(0)) {
        e.preventDefault();
        e.stopPropagation();
        if (play) {
        play = false;
        } else {
            play = true;
        }
    }
})



        document.querySelector('body').addEventListener('mousemove', sasuit);

        function sasuit (){
            var eye = document.querySelectorAll('.eye');
            eye.forEach(function(eye){
                let x = (eye.getBoundingClientRect().left) + (eye.clientWidth / 2);
                let y = (eye.getBoundingClientRect().top) + (eye.clientHeight / 2);
                let radian = Math.atan2(event.pageX -x, event.pageY -y);
                let rot = (radian * (180 / Math.PI) *-1) + 270;
                eye.style.transform = "rotate("+ rot +"deg)"


                
            })
        }
    </script>




    <div class="contemp" onclick="satisfait();" onmouseover="has();">
        <div class="eyes">

            <div class="eye"></div>
            <div class="eye"></div>

        </div>
    </div>


    <div class="moyen" onclick="moyennementsatisfait();" onmouseover="hoas();">
        <div class="eyes">

            <div class="eye"></div>
            <div class="eye"></div>

        </div>
    </div>


    <div class="pascontemp" onclick="passatifait();" onmouseover="hos();">
        <div class="eyes">

            <div class="eye">   </div>
            <div class="eye">   </div>
            
        </div>
    </div>

    <div class="sourcil">   </div>

    <div class="sourcil">   </div>



    <audio> <source src="../assets/Haaaaaaaaaaaaaa.mp3"/>     </audio>
    <audio> <source src="../assets/hooooooooooooaa.mp3"/>     </audio>
    <audio> <source src="../assets/hoaaa.mp3"/>               </audio>


    





<?php $content = ob_get_clean();?>
<?php require('../templates/baseTemplate.php'); ?>
