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

