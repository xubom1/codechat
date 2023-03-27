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
    }).then(response => response.text())
    .then(function(text){
        const container = document.getElementById('scroller');
        if (text !== '')
            container.innerHTML += text;
    });
}

addPublications(6);

function checkScrolling() {
    const scroller = document.getElementById('scroller');

    if (scroller.scrollTop + scroller.offsetHeight > scroller.scrollHeight - 150){
        addPublications(10);
    }
};

setInterval(checkScrolling, 100);

