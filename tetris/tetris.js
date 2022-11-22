/* DOM */
const map = document.querySelector(".map > ul");
const gameStatus = document.querySelector(".gameover");
const startDiv = document.querySelector(".gamestart");
const startBtn = document.querySelector(".startBtn");
const restartBtn = document.querySelector(".RestartBtn");
const totalScore = document.querySelector(".score");
const lScore = document.querySelector(".lastScore")
const record = document.querySelector(".record");
const modal = document.querySelector(".modalBtn");
const scoreSave = document.querySelector(".modalSaveBtn");
const inputUserId = document.querySelector(".inputUserId");
const modalClose = document.querySelector(".modalCloseBtn");

/* Setting */
const GAME_ROWS = 20;
const GAME_COLS = 10;

/* Variables */

let score = 0;
let duration = 500;
let downInteval;
let tmpMovingItem;

const BLOCKS = {
    tree : [
        [[1, 0], [0, 1], [1, 1], [2, 1]],   // direction 0
        [[2, 1], [1, 0], [1, 1], [1, 2]],   // direction 1
        [[2, 1], [0, 1], [1, 1], [1, 2]],   // direction 2
        [[0, 1], [1, 2], [1, 1], [1, 0]]    // direction 3
    ],
    square : [
        [[0,0], [0,1], [1, 0], [1, 1]],
        [[0,0], [0,1], [1, 0], [1, 1]],
        [[0,0], [0,1], [1, 0], [1, 1]],
        [[0,0], [0,1], [1, 0], [1, 1]]
    ],
    bar : [
        [[1, 0], [2, 0], [3, 0], [4, 0]],
        [[2, -1], [2, 0], [2, 1], [2, 2]],
        [[1, 0], [2, 0], [3, 0], [4, 0]],
        [[2, -1], [2,0], [2, 1], [2, 2]]
    ],
    zeeLeft : [
        [[0, 0], [1, 0], [1, 1], [2, 1]],
        [[0, 1], [1, 0], [1, 1], [0, 2]],
        [[0, 1], [1, 1], [1, 2], [2, 2]],
        [[2, 0], [2, 1], [1, 1], [1, 2]]
    ],
    zeeRight : [
        [[1, 0], [2, 0], [0, 1], [1, 1]],
        [[0, 0], [0, 1], [1, 1], [1, 2]],
        [[1, 0], [2, 0], [0, 1], [1, 1]],
        [[0, 0], [0, 1], [1, 1], [1, 2]]
    ],
    elLeft : [
        [[0, 0], [1, 0], [2, 0], [0, 1]],
        [[1, 0], [1, 1], [1, 2], [0, 0]],
        [[2, 0], [0, 1], [1, 1], [2, 1]],
        [[0, 0], [0, 1], [0, 2], [1, 2]]
    ],
    elRight : [
        [[0, 0], [1, 0], [2, 0], [2, 1]],
        [[2, 0], [2, 1], [2, 2], [1, 2]],
        [[0, 0], [0, 1], [1, 1], [2, 1]],
        [[1, 0], [2, 0], [1, 1], [1, 2]]
    ]
}

const movingItem = {
    type : "",
    direction : 0,
    top : 0,
    left : 0,

}

/* Function */
function init(){
    tmpMovingItem = {...movingItem}
    for(let i=0; i<GAME_ROWS; i++){
        prependLine();
    }
    generateNewBlock();
}

function prependLine(){

    const li = document.createElement("li");
    const ul = document.createElement("ul");
    for(let j=0; j<GAME_COLS; j++){
        const matrix = document.createElement("li");
        ul.prepend(matrix);
    }
    li.prepend(ul);
    map.prepend(li);
}

function renderBlocks(moveType = ""){
    const { type , direction, top, left} = tmpMovingItem;
    const movingBlocks = document.querySelectorAll(".moving");
    movingBlocks.forEach(moving =>{
        moving.classList.remove(type, "moving");
    })
    BLOCKS[type][direction].some(block=>{
        const x = block[0] + left;
        const y = block[1] + top;
        const target = map.childNodes[y] ? map.childNodes[y].childNodes[0].childNodes[x] : null;
        const isAvailiable = checkEmpty(target);

        if(isAvailiable){
            target.classList.add(type, "moving");
        }else{
            if(moveType === "retry"){
                clearInterval(downInteval);
                record.classList.remove("hidden");
                GameOver();
            }
            tmpMovingItem = {...movingItem};
            setTimeout(()=>{
                renderBlocks("retry");
                if(moveType === "top"){
                    seizeBlock();
                }
            },0);
            return true;
        }
    });
    movingItem.left = left;
    movingItem.top = top;
    movingItem.direction = direction;
}

function seizeBlock(){
    const movingBlocks = document.querySelectorAll(".moving");
    movingBlocks.forEach(moving =>{
        moving.classList.remove("moving");
        moving.classList.add("seized");
    })
    checkMatch();
}

function checkMatch(){

    const childNodes = map.childNodes;
    childNodes.forEach(child =>{
        let matched = true;
        child.children[0].childNodes.forEach(li=>{
            if(!li.classList.contains("seized")){
                matched = false;
            }
        });
        if(matched){
            child.remove();
            prependLine();
            score += 10;
            totalScore.innerHTML = score;
        }
    })

    generateNewBlock();

}

function generateNewBlock(){

    clearInterval(downInteval);
    downInteval = setInterval(()=>{
        moveBlock("top", 1);
    }, duration)

    const blockArray = Object.entries(BLOCKS);
    const randomIndex = Math.floor(Math.random()*blockArray.length);

    movingItem.type = blockArray[randomIndex][0];
    movingItem.top = 0;
    movingItem.left = 3;
    movingItem.direction = 0;

    tmpMovingItem = {...movingItem};
    renderBlocks();
}

function checkEmpty(target){
    if(!target ||  target.classList.contains("seized") ){
        return false;
    }
    return true;
}
function moveBlock(moveType, amount){
    tmpMovingItem[moveType] += amount;
    renderBlocks(moveType);
}
function changeDirection(){
    const direction =  tmpMovingItem.direction;
    direction === 3 ? tmpMovingItem.direction = 0 : tmpMovingItem.direction +=1;
    renderBlocks();
}

function dropBlock(){
    clearInterval(downInteval);
    downInteval = setInterval(()=>{
        moveBlock("top", 1);
    }, 10);
}


function GameOver(){
    lScore.innerHTML="Score : " + totalScore.innerHTML;
    totalScore.style.display = "none";
    map.style.display= "none";
    gameStatus.style.display="flex";
}

/* Event Handling */

startBtn.addEventListener("click", () => {
    document.querySelector(".map").style.display= "block";
    totalScore.style.display="block";
    restartBtn.style.display = "block";
    startDiv.style.display="none";
    map.innerHTML= "";
    init();
    
})

document.addEventListener("keydown", e=>{
    switch(e.keyCode){
        case 39 :
            moveBlock("left", 1);
            break;
        case 37:
            moveBlock("left", -1);
            break;
        case 40 :
            moveBlock("top", 1);
            break;
        case 90 :
            changeDirection();
            break;
        case 32 :
            dropBlock();
            break;
        default :
            break;
    }
});

restartBtn.addEventListener("click", ()=>{
    score = 0;
    map.innerHTML= "";
    map.style.display= "block";
    
    lScore.innerHTML = "";
    totalScore.innerHTML= "0";
    totalScore.style.display = "block";
    
    gameStatus.style.display="none";
    record.classList.add("hidden");
    init();
});

record.addEventListener("click", ()=>{ 
    modal.click();
});

scoreSave.addEventListener("click", ()=>{
    if(inputUserId.value != ""){
        let regID = /^[가-힣a-zA-Z1-9 ]+$/;
        if(!regID.test(inputUserId.value) || inputUserId.value < 3){
            console.log(inputUserId.value);
            inputUserId.value="아이디는 3자 이상의 한글, 영문, 숫자로만 입력가능합니다.";
            inputUserId.style.color = "#FFA7A7";
        }else{
            $.post("http://121.174.117.167/20191735/ajax.DBsave.php", {
                game : "tetris",
                userid : inputUserId.value,
                score : totalScore.innerHTML
            }, function(data){
                if(data.SQL){
                    modalClose.click();
                }else{
                    alert("저장하지 못하였습니다.")
                }
            }, "json");
        }
    }else{
        inputUserId.value="아이디를 입력해주세요.";
        inputUserId.style.color = "#FFA7A7";
    }
});

inputUserId.addEventListener("click", ()=>{
        inputUserId.style.color = "black";
        inputUserId.value="";
});
