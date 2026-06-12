/*
Daniel Kogan
March 24th, 2026
JS File for the program, does all the logic for the game
*/

let gameWindow;
let targetBoard;
let gameRunning = false;
let timeLeft;
let timeStarted;
let currentScore = 0;

window.addEventListener("load", function () {
    gameWindow = document.getElementById("gamewindow");
    targetBoard = document.getElementById("gamepage");

    // History
    let hist = [];
    if (localStorage["hist"] != undefined) {
        hist = JSON.parse(localStorage["hist"]);
    }
    // let gamehist = this.document.getElementById("gamehistory")
    // for (let game of hist) {
    //     // let elem = this.document.createElement("p");
    //     let histmode = game["settings"][0]
    //     let histsize = game["settings"][1]
    //     let histtime = game["settings"][2]
    //     let histfade = game["settings"][3]
    //     if (histfade == 500) {
    //         histfade = "No Fade"
    //     }
    //     else {
    //         histfade = "Yes Fade"
    //     }
    //     // elem.innerHTML = "<br>" + histmode + ", " + histsize + ", " + histtime + " seconds" + ", " + histfade + "<br>with a score of " + game["score"];
    //     // elem.style.fontSize = "20px";
    //    gamehist.appendChild(elem);
    // }

    let userWidth = this.window.innerWidth;
    let userHeight = this.window.innerHeight;

    let canvas = this.document.getElementById("splashpage");
    console.log(userWidth, userHeight)
    canvas.width = userWidth - 6;
    canvas.height = userHeight - 6;

    let ctx = canvas.getContext("2d");
    // console.log(userWidth, userHeight)
    ctx.font = "54px Arial"
    ctx.fillStyle = "white";
    ctx.fillText("AimTrainer", userWidth / 2 - 133, 100);
    let img = new Image();
    img.src = "images/target.png";
    ctx.drawImage(img, userWidth / 2 - 150, 200, 300, 300)
    // ctx.fillRect(userWidth / 10, userHeight / 10, 50, 50);
    ctx.font = "40px Arial"
    ctx.fillText("Click to continue", userWidth / 2 - 150, userHeight - 100);

    let startpage = document.getElementById("startpage");
    canvas.addEventListener("click", function () {
        canvas.style.display = "none";
        startpage.style.display = "block";
    });

    let homebtn = this.document.getElementById("homebutton");
    homebtn.addEventListener("click", function () {
        startpage.style.display = "block";
        let gameoverwindow = document.getElementById("gameoverwindow");
        gameoverwindow.style.display = "none";
    });

    // Help Button
    let helpbtn = this.document.getElementById("helpbutton");
    helpbtn.addEventListener("click", function () {
        let helpinfo = document.getElementById("helpinfo");
        helpinfo.style.visibility = "visible    ";
        // console.log("click");
        setTimeout(() => {
            helpinfo.style.visibility = "hidden";
        }, 6000)
    })

    // Game Start
    let startbtn = this.document.getElementById("startbutton");
    startbtn.addEventListener("click", function () {
        gameRunning = true;
        startpage.style.display = "none";
        gameWindow.style.display = "flex";

        let inps = document.querySelectorAll("input[type=radio]:checked")
        let mode;
        let time;
        let size;
        let fadetime;

        for (let item of inps) {
            if (item.name == "mode") {
                mode = item.value;
            }
            if (item.name == "time") {
                time = item.value;
            }
            if (item.name == "size") {
                size = item.value
            }
            if (item.name == "fade") {
                if (item.value == "Yes") {
                    fadetime = 3;
                }
                else {
                    fadetime = 500;
                }
            }
        }

        let targets = []
        if (mode == "Multi") {
            for (let i = 0; i < 5; i++) {
                let target = new Target(Math.random() * (window.innerWidth - 150), Math.random() * (window.innerHeight - 225) + 75, size, fadetime)
                // console.log(window.innerWidth, window.innerHeight, target.x, target.y)
                targets.push(target);
                target.create();
                // console.log(target);
            }
        }
        else if (mode == "Single") {
            let target = new Target(Math.random() * (window.innerWidth - 150), Math.random() * (window.innerHeight - 225) + 75, size, fadetime)
            // console.log(window.innerWidth, window.innerHeight, target.x, target.y)
            targets.push(target);
            target.create();
        }
        currentScore = 0;
        timeLeft = Number(time);
        timeStarted = Number(time);
        updateHeader();



        setTimeout(() => {
            targets = []
            while (targetBoard.hasChildNodes()) {
                targetBoard.removeChild(targetBoard.firstElementChild);
            }
            gameWindow.style.display = "none";
            gameRunning = false;

            // PHP Addition
            let modeFormElem = document.getElementById("modeform");
            let sizeFormElem = document.getElementById("sizeform");
            let timeFormElem = document.getElementById("timeform");
            let fadeFormElem = document.getElementById("fadeform");
            let scoreFormElem = document.getElementById("scoreform");
            let fadebool = "No";
            if (fadetime == 3) {
                fadebool = "Yes"
            }
            scoreFormElem.value = currentScore;
            modeFormElem.value = mode;
            sizeFormElem.value = size;
            timeFormElem.value = time;
            fadeFormElem.value = fadebool;
            //

            let gameoverwindow = document.getElementById("gameoverwindow");
            gameoverwindow.style.display = "block";

            let finalscore = document.getElementById("finalscore");
            finalscore.innerHTML = "Final Score: " + currentScore;

            /*
                games: [
                    game1: {
                        settings: [a,b,c,d]
                        score: 67
                    }
                ]
            */
            let games;
            if (localStorage["games"] != undefined) {
                games = JSON.parse(localStorage["games"]);
            }
            else {
                games = [];
            }

            let hist;
            if (localStorage["hist"] != undefined) {
                hist = JSON.parse(localStorage["hist"]);
            }
            else {
                hist = []
            }
            let found = false;
            for (let game of games) {
                // console.log("checking: ",  game["settings"], [mode, size, time ,fadetime], game["settings"] == [mode, size, time, fadetime])
                if (game["settings"].every((value, index) => value === [mode, size, time, fadetime][index])) {
                    if (game["score"] < currentScore) {
                        game["score"] = currentScore;
                    }
                    let pbelem = document.getElementById("pb");
                    pbelem.innerHTML = "Score: " + game["score"];
                    found = true;
                }
            }
            let structure = {
                "settings": [mode, size, time, fadetime],
                "score": currentScore
            }
            hist.push(structure);
            if (found == false) {


                games.push(structure)
            }
            if (hist.length > 5) {
                hist.reverse().pop()
                hist.reverse()
                // Delete last history;
            }
            // Update history UI

            // let gamehist = document.getElementById("gamehistory")
            // // Clear history
            // while (gamehist.hasChildNodes()) {
            //     gamehist.removeChild(gamehist.lastChild);
            // }
            // for (let game of hist) {
            //     let elem = document.createElement("p");
            //     let histmode = game["settings"][0]
            //     let histsize = game["settings"][1]
            //     let histtime = game["settings"][2]
            //     let histfade = game["settings"][3]
            //     if (histfade == 500) {
            //         histfade = "No Fade"
            //     }
            //     else {
            //         histfade = "Yes Fade"
            //     }
            //     elem.innerHTML = "<br>" + histmode + ", " + histsize + ", " + histtime + " seconds" + ", " + histfade + "<br>with a score of " + game["score"];
            //     elem.style.fontSize = "20px";
            //     gamehist.appendChild(elem);
            // }

            // console.log(games);
            localStorage["hist"] = JSON.stringify(hist);
            localStorage["games"] = JSON.stringify(games);

            // console.log(mode, size, time)
            let finalmode = document.getElementById("finalmode");
            finalmode.innerHTML = "Mode: " + mode;
            let finalsize = document.getElementById("finalsize");
            finalsize.innerHTML = "Size: " + size;
            let finaltime = document.getElementById("finaltime");
            finaltime.innerHTML = "Timer: " + time + " seconds";
            let finalfade = document.getElementById("finalfade");
            // fadebool = "No";
            // if (fadetime == 3) {
            //     fadebool = "Yes"
            // }
            finalfade.innerHTML = "Fadeaway: " + fadebool;
        }, time * 1000);

    });

    // After finish loading and init all, always update header
    let count = 0;
    setInterval(() => {
        if (gameRunning) {
            timeLeft -= 0.05
            updateHeader();
        }
        count += 50;


    }, 50);
});


/** 
 * 
 * Updates the header elements with the score and changes the progress bar and timer
 * 
 * No parameters
 * Returns nothing
*/
function updateHeader() {
    let scoreElem = this.document.getElementById("score");
    scoreElem.innerHTML = "Score: " + currentScore;
    let progressLabel = document.getElementById("timerLabel")
    let progressBar = document.getElementById("timerProgress");
    progressBar.max = timeStarted;
    progressBar.value = timeLeft;
    progressLabel.innerHTML = "Time Left: " + timeLeft.toFixed(1) + " Seconds"
}

class Target {
    constructor(x, y, size, fadeMS = -1) {
        this.x = x;
        this.y = y;
        this.size = size;
        this.fadeMS = fadeMS;
    }

    /**
     * 
     * Creates the target element based on the settings provided
     * 
     * No parameters
     * Returns nothing
     * 
     */
    create() {
        this.elem = document.createElement("img")
        this.elem.src = "images/target.png";
        this.elem.style.position = "absolute";
        this.update()
        let sizeMulti = 1;
        if (this.size == "Medium") {
            sizeMulti = 2;
        }
        if (this.size == "Large") {
            sizeMulti = 3;
        }
        this.elem.style.width = 50 * sizeMulti + "px";
        this.elem.style.height = 50 * sizeMulti + "px";
        this.elem.style.borderRadius = "50%";
        this.elem = targetBoard.appendChild(this.elem);
        let targetObject = this;
        this.elem.addEventListener("click", function (e) {
            targetObject.x = Math.random() * (window.innerWidth - 150);
            targetObject.y = Math.random() * (window.innerHeight - 225) + 75;
            clearInterval(targetObject.intervalID);
            targetObject.update();
            currentScore++;
            updateHeader()
        })


    }

    /**
     * Updates the targets position using js styling
     * 
     * No parameters
     * Returns nothing
     * 
     */
    update() {
        this.elem.style.left = this.x + "px";
        this.elem.style.top = this.y + "px";
        let count = 0;
        this.elem.style.opacity = 1;
        if (this.fadeMS <= 3) {
            this.intervalID = setInterval(() => {
                if (count >= this.fadeMS * 1000) {
                    this.x = Math.random() * (window.innerWidth - 200) + 150;
                    this.y = Math.random() * (window.innerHeight - 200) + 150;
                    clearInterval(this.intervalID);
                    this.update();
                }
                this.elem.style.opacity -= 1 / (this.fadeMS / 50 * 1000);
                count += 50;
            }, 50);
        }
    }
}