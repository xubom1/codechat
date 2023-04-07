//publication scrolling system
const ERROR_TIMEOUT = 2000;
let lastError = Date.now() - ERROR_TIMEOUT;

function addPublications(number ){
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

addPublications(20);

function checkScrolling() {
    //avoid spamming in case of an error
    if (Date.now() < lastError + ERROR_TIMEOUT) return;

    const scroller = document.getElementById('scroller');

    if (scroller.scrollTop + scroller.offsetHeight > scroller.scrollHeight - 150){
        addPublications(20);
    }
};

setInterval(checkScrolling, 100);


//like system

async function updateLike(button){
    //get the like counter
    const likesCounter = button.parentNode.getElementsByClassName('likesCounter')[0];

    //change the button img and data and update the likes count 
    if (button.alt != 0) {
        button.src = '/assets/like.svg';
        button.alt = 0;
        likesCounter.innerHTML--;
    }
    else{
        button.src = '/assets/unlike.png';
        button.alt = 1;
        likesCounter.innerHTML++;
    }

    //get publication node to get the publication id
    let publication = button;
    do{
        publication = publication.parentNode;
    }
    while(!publication.getAttribute('class').split().includes('publication'));

    let data = new FormData();
    data.append("publication", publication.id);
    data.append("user", button.getAttribute('codechat-user'));
    data.append("like", button.alt);

    //send like to the server
    const response = await (await fetch("src/like.php", {
        method: "POST",
        body: data
    })).text();

    
}
