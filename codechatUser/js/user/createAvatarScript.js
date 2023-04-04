async function selectActiveComponents(){
    //get already selected components in the db
    const data = new FormData();
    data.append('user', document.getElementsByTagName('main')[0].getAttribute('codechat-user'));

    const avatarPromise = await fetch('src/getAvatar.php', {
        method: "POST",
        body: data
    });

    let images = Array.from(await avatarPromise.json());
    images = images.map((value) => value.id);//isolate the ids

    //set the body parts that are in the database
    const inputs = document.getElementsByClassName('avatarInput');

    for (const input of inputs) {
        const radio = input.children[0];
        
        if (images.includes(parseInt(radio.id))){
            radio.checked = true;
        }

    }
}

selectActiveComponents();

let lock = false;

const radios = document.querySelectorAll('input[type=radio]');

radios.forEach(function (radio){
    radio.addEventListener('change', async function(event){

        //if modification is locked during change reset the previous value
        if (lock) selectActiveComponents();
        
        lock = true;//disable modification
        const data = new FormData();
        data.append('component', event.currentTarget.id);

        const promise = await fetch('src/setAvatar.php', {method: "POST", body: data});
        await promise.text();//wait for the request to end
        
        //unlock the modification
        lock = false;

        //update the avatar on the screen
        const avatarContainer = document.getElementById('avatarContainer');
        const user = document.getElementsByTagName('main')[0].getAttribute('codechat-user');
        avatarContainer.innerHTML = 
            '<div class="avatar" codechat-user="' + user + '" size="150" style="height: 150px; width: 150px;"></div>';
    })
});