<?php $title = "popop";$css = "popop.css"?>
<?php ob_start(); ?>

  



    <div class="contemp" onclick="satisfait()">
        <div class="eyes">
            <div class="eye"></div>
            <div class="eye"></div>
        </div>
    </div>


    <div class="moyen" onclick="moyennementsatisfait()">
        <div class="eyes">
            <div class="eye"></div>
            <div class="eye"></div>
        </div>
    </div>


    <div class="pascontemp" onclick="passatifait()">
        <div class="eyes">
            <div class="eye"></div>
            <div class="eye"></div>
            
            
        </div>
    </div>
    <div class="sourcil"></div>
    <div class="sourcil"></div>
    <script>
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





<?php $content = ob_get_clean();?>
