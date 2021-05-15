<body>
    <div id="pasmain"></div>
    <div class="main" id="main">
        <h1>Error 404 Not found</h1>
        <div class="btn" onclick="window.location = '/'">
            revenir a la page d'accueil
        </div>
    </div>

    <div class="bas">
        <h1 class="a">    Ludovic Castiglia       <span>|</span>   </h1>
        <h1 class="b">    Jules Grivot Pélisson  <span>|</span>   </h1>
        <h1 class="c">    Pierre Ohannessian       <span>|</span>   </h1>
        <h1 class="d">    Enzo El Younoussi       <span>|</span>   </h1>
        <h1 class="e">    Mathis Maupetit         <span>|</span>   </h1>
    </div>
</body>


<style>
    .btn {
        padding: 10px;
        border: 3px solid #2f743b;
        font-size: 1.5em;
        transition: 0.25s ease-out;
        cursor: pointer;
        color: #fff;
        background: #2f743b;
    }
    .btn:hover {
        box-shadow: 0px 0px 0px 24px #bfffcb;
        outline: 12px solid #8fd49b;
        padding: 22px;
        border: 12px solid #5fa46b;
        font-size: 0.9em;
    }
    #pasmain {
        background-image: url("../assets/environment1.jpg");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        width: 100%;
        filter: blur(8px);
        -webkit-filter: blur(5px);
    }
    .main {
        color: #fff;
        width: 85vw;
        font-size: 4vw;
        border: 1px solid #2f743b;
        border-radius: 44px;
        position: absolute;
        height: 50vh;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-evenly;
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0, 0.4);
    }
    body {
        padding:0;
        margin:0;
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }
    .bas {
        display:flex;
        align-items: center;
        height: 15vh;
        width: 100vw;
        background: #2f743b;
        color: white;
        position: absolute;
        bottom: 0px;
        font-size: 2.3vw;
        overflow: hidden;
    }
    .bas h1 {
        position: absolute;
        display:flex;
        align-items: center;
        flex-direction: row;
        margin-right: 2vw;
        width: max-content;
        left: 100%;
    }
    .a {
        animation: nom 5s infinite linear;
        top: 0%;
    }
    .b {
        animation: nom 5s -1s infinite linear;
		top: 20%;
    }
    .c {
        animation: nom 5s -2s infinite linear;
		bottom: 0%;
    }
    .d {
        animation: nom 5s -3s infinite linear;
		top: 25%;
    }
    .e {
        animation: nom 5s -4s infinite linear;
		bottom: 15%;
    }
    span {
        margin-left: 4vw;
        font-size: 2em;
        display: none;
    }
    @keyframes nom {
        0% {
            transform: translate(0%,0%);
        }
        100% {
            transform: translate( calc(-100vw - 100% ),0%);
        }
    }






    @media screen and (max-width: 640px) {
        .btn {
            font-size: 1.5em;
        }
        .main {
            width: 85vw;
            font-size: 4vw;
        }
        .bas {
            font-size: 1.4vw;
        }
        span {
            display: none;
        }
    }

    /*////////////////responsive 900px (téléphone et autre)//////*/
    @media screen and (min-width: 450px) {
        @media screen and (max-width: 900px) {
            .main {
                width: 75vw;
                font-size: 4vw;
            }
            .bas {
                font-size: 1.4vw;
            }
            span {
                display: none;
            }
        }
    }


    








    /*/////////////////////////////////////////////////////////////////////////////////////////////*/
    @media screen and (min-width: 1000px){

                .btn {
                padding: 10px;
                border: 3px solid #2f743b;
                font-size: 0.75em;
                transition: 0.25s ease-out;
                cursor: pointer;
                color: #fff;
                background: #2f743b;
                }
                .btn:hover {
                    box-shadow: 0px 0px 0px 24px #bfffcb;
                    outline: 12px solid #8fd49b;
                    padding: 22px;
                    border: 12px solid #5fa46b;
                    font-size: 0.9em;
                }
                #pasmain {
                    background-image: url("../assets/environment1.jpg");
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    height: 100vh;
                    width: 100%;
                    filter: blur(8px);
                    -webkit-filter: blur(5px);
                }
                .main {
                    color: #fff;
                    font-size: 1.5em;
                    border: 1px solid #2f743b;
                    border-radius: 44px;
                    position: absolute;
                    width: 50vw;
                    height: 50vh;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%,-50%);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-evenly;
                    background-color: rgb(0,0,0); /* Fallback color */
                    background-color: rgba(0,0,0, 0.4);
                }
                body {
                    padding:0;
                    margin:0;
                    height: 100vh;
                    width: 100vw;
                    overflow: hidden;
                }
                .bas {
                    display:flex;
                    align-items: center;
                    height: 10vh;
                    width: 100vw;
                    background: #2f743b;
                    color: white;
                    position: absolute;
                    bottom: 0px;
                    font-size: 1vw;
                    overflow: hidden;
                }
                .bas h1 {
                    position: absolute;
                    display:flex;
                    align-items: center;
                    flex-direction: row;
                    margin-right: 2vw;
                    width: max-content;
                    left: 100%;
                }
                .a {
					top: 0px;
					bottom: 0px;
                    animation: nom 7.5s infinite linear;
                }
                .b {
					top: 0px;
					bottom: 0px;
                    animation: nom 7.5s -1.5s infinite linear;
                }
                .c {
					top: 0px;
					bottom: 0px;
                    animation: nom 7.5s -3s infinite linear;
                }
                .d {
					top: 0px;
					bottom: 0px;
                    animation: nom 7.5s -4.5s infinite linear;
                }
                .e {
					top: 0px;
					bottom: 0px;
                    animation: nom 7.5s -6s infinite linear;
                }
                span {
				display: block;
                    margin-left: 4vw;
                    font-size: 2em;
                }
                @keyframes nom {
                    0% {
                        transform: translate(0%,0%);
                    }
                    100% {
                        transform: translate( calc(-100vw - 100% ),0%);
                    }
                }
    }
</style>