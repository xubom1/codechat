//publication scrolling system
const ERROR_TIMEOUT = 2000;
let lastError = Date.now() - ERROR_TIMEOUT;

function addPublications(number){
    //get already loaded publications
    const publications = document.getElementsByClassName('publication');

    //data to send
    let data = new FormData();
    data.append("publicationsCount", publications.length.toString());
    data.append("countWanted", number.toString());

    //send theme to the server
    fetch("src/getPublications.php", {
        method: "POST",
        body: data
    }).then(function(response){
            if (!response.ok) {
                lastError = Date.now();
                throw Error(response.statusText);
            }
            return response.text();
        }
    ).then(function(text){
        const container = document.getElementById('scroller');
        if (text !== '')
            container.innerHTML += text;
    })
}

function checkScrolling() {
    //avoid spamming in case of an error
    if (Date.now() < lastError + ERROR_TIMEOUT) return;

    const scroller = document.getElementById('scroller');

    if (scroller.scrollTop + scroller.offsetHeight > scroller.scrollHeight - 150){
        addPublications(20);
        lastError = Date.now();
    }
}

if (document.getElementById('scroller')){
    addPublications(20);
    setInterval(checkScrolling, 200);
}


//like system
async function updateLike(button){
    //get the like counter
    const likesCounter = button.parentNode.getElementsByClassName('likesCounter')[0];

    //change the button img and data and update the likes count 
    if (parseInt(button.alt)) {
        button.src = '/assets/like.svg';
        button.alt = 0;
        likesCounter.innerHTML--;
    }
    else{
        button.src = '/assets/unlike.png';
        button.alt = 1;
        likesCounter.innerHTML++;
    }

    let data = new FormData();
    data.append("publication", button.getAttribute('publication'));
    data.append("user", button.getAttribute('codechat-user'));
    data.append("like", button.alt);

    //send like to the server
    const response = await (await fetch("src/like.php", {
        method: "POST",
        body: data
    })).text();
}

//follow system
async function updateFollow(button){

    //get all the other follow button
    let buttons = [].slice.call(document.getElementsByClassName('followButton'));
    //filter the button that are for the same user
    buttons = buttons.filter((otherButton) => otherButton.getAttribute('codechat-user') === button.getAttribute('codechat-user'));
    
    let state = 1;
    let inner = 'follow';

    if (parseInt(button.state)){
        state = 0;
        inner = 'unfollow';
    }

    //change the state of the same button   
    for (const otherButton of buttons) {
        otherButton.state = state;
        otherButton.innerHTML = inner;
        if (state){
            otherButton.classList.add('btn-danger');
            otherButton.classList.remove('btn-outline-danger');
        }
        else{
            otherButton.classList.remove('btn-danger');
            otherButton.classList.add('btn-outline-danger');
        }
    }

    let data = new FormData();
    data.append("user", button.getAttribute('codechat-user'));
    data.append("follow", button.state);

    const response = await (await fetch("src/follow.php", {
        method: "POST",
        body: data
    })).text();
}
