async function sendMessage(content, receiver, author){
    const data = new FormData();
    data.append('content', content);
    data.append('receiver', receiver);
    data.append('author', author);
    await (await fetch("/messages/create.php", {method: 'POST', body: data}));
}

async function newMessage(receiver, author){
    await sendMessage(document.getElementById('messageInput').value, receiver, author);
    window.location.reload();
}

async function getMessagesCount(){
    return parseInt(await (await fetch('/messages/count.php')).text());
}

function setPreviousNumberOfMessage(value){
    const d = new Date();
    d.setTime(d.getTime() + (200*24*60*60*1000));
    document.cookie = "messagesCount=" + value + ";expires=" + d.toUTCString() + ";path=/";
}

function getPreviousNumberOfMessage(){
    const cookie = document.cookie.split(';').filter(cookie => cookie.includes('messagesCount'))[0];
    if (!cookie) return undefined;
    return parseInt(cookie.split('=')[1]);
}

async function updateContacts(){
    const container = document.getElementById('contactsContainer');
    if (!container) return;
    const data = new FormData();
    if (getPreviousNumberOfMessage())
        data.append('previousMessageCount', getPreviousNumberOfMessage().toString());
    container.innerHTML = await (await fetch('/messages/getContacts.php', { method: "POST", body: data})).text();
}

async function updateMessages(){
    //init
    if (!getPreviousNumberOfMessage()) {setPreviousNumberOfMessage(await getMessagesCount()); return;}

    //test
    let updatedNumberOfMessage = await getMessagesCount();
    if (getPreviousNumberOfMessage() !== updatedNumberOfMessage){
        await updateContacts();
        window.location.reload();
        setPreviousNumberOfMessage(updatedNumberOfMessage);
    }
}

updateContacts();
setInterval(updateMessages, 1000);