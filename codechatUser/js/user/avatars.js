
async function updateAvatars(){
    const avatarsCollection = document.getElementsByClassName('avatar');
    if (!avatarsCollection.length) return;

    const avatarsContainers = [].slice.call(avatarsCollection);//get the html collection but fixed in time
    
    //get size of the image needed
    const size = 150

    //get all the users which need an avatar to be displayed
    let users = [];

    for (const avatarContainer of avatarsContainers) {
        users.push(avatarContainer.getAttribute('codechat-user'));
    }
    
    //remove duplicates
    users = users.filter((value, index) => (users.indexOf(value) === index));

    const usersString = users.join('\n');

    const data = new FormData();
    data.append('user', usersString);

    const avatarPromise = await fetch('src/getAvatar.php', {
        method: "POST",
        body: data
    });

    //store all the avatars' images path
    const avatarsData = Object.entries(await avatarPromise.json());

    //array that will store all the generated images
    const avatars = {};

    for (const [user, avatarData] of avatarsData) {

        //create a canvas for each avatar to create an img
        const canvas = document.createElement('canvas');

        //get the 2D context
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');
        
        
        //load images that compose the avatar
        const images = [];
        for (const imageData of avatarData) {
            const img = new Image();

            //function that is called when an image is added
            img.onload = function(){
                //add the loaded image in the array of images
                images.push(img);

                //check if all the images are loaded
                if (images.length === avatarData.length){

                    //draw images in the correct order
                    images.sort((a, b) => a.class - b.class);
                    for (const image of images) {
                        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
                    }

                    //convert the canvas to image
                    avatars[user] = new Image();
                    avatars[user] = canvas.toDataURL("image/png");

                    //check if all the avatars had been generated
                    if (Object.keys(avatars).length === avatarsData.length){
                        
                        for (const avatarContainer of avatarsContainers) {
                            //replace the old avatar container with the img
                            const user = avatarContainer.getAttribute('codechat-user');
                            const avatarNode = document.createElement('img');
                            avatarNode.height = avatarContainer.getAttribute('size') ? avatarContainer.getAttribute('size') : 50;
                            if (!avatars[user]) throw 'failed to find matching user :' + user;
                            avatarNode.src = avatars[user];
                            
                            if (avatarContainer.parentNode) //avoid async related bugs
                                avatarContainer.parentNode.replaceChild(avatarNode, avatarContainer);
                        }
                    }
                }
            };
            img.src = imageData['path'];
            img.class = imageData['type'];
        }   
    }
}

document.addEventListener('DOMContentLoaded', function(){
    updateAvatars();
    setInterval(updateAvatars, 200);
});