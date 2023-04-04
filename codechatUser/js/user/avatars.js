

async function updateAvatars(){
    const avatars = document.getElementsByClassName('avatar');

    for (const avatar of avatars) {
        //get user
        const user = avatar.getAttribute('codechat-user');
        if (!user) continue;

        //get size of the image needed
        let size = avatar.getAttribute('size');
        if (!size) size = 50;

        //change class (avoid that the automatic selection function take it while it is loading)
        avatar.setAttribute('class', 'loading');

        //create a canvas
        const canvas = document.createElement('canvas');

        //get the 2D context
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');

        //getAvatar
        const data = new FormData();
        data.append('user', user);

        const avatarPromise = await fetch('src/getAvatar.php', {
            method: "POST",
            body: data
        });

        const imagesData = await avatarPromise.json();

        //load images that compose the avatar
        const images = [];
        for (const imageData of imagesData) {
            const img = new Image();

            //function that is called when an image is added
            img.onload = function(){
                //add the loaded image in the array of images
                images.push(img);

                //check if all the images are loaded
                if (images.length == imagesData.length){

                    //draw images in the correct order
                    images.sort((a, b) => a.class - b.class);
                    for (const image of images) {
                        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
                    }

                    //convert the canvas to image and display the image in the document
                    const avatarResult = new Image();
                    avatarResult.src = canvas.toDataURL("image/png");
                    avatar.parentNode.replaceChild(avatarResult, avatar);
                }
            };
            img.src = imageData['path'];
            img.class = imageData['type'];
        }        
    }
}

document.addEventListener('DOMContentLoaded', function(){
    setInterval(updateAvatars, 100);
});