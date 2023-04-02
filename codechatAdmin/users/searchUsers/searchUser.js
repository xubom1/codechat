async function searchUser(){
    const input = document.getElementById('search');
    const name = input.value;
    try {
        const res = await fetch('searchUser.php?name=' + name);
        const str = await res.text();
        console.log(str)
        const user = document.getElementById('userRow');
        user.innerHTML = str;
    } catch (err) {
        alert('bug');
    }
}