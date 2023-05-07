
async function searchPublication(){
    const input = document.getElementById('search');
    const name = input.value;
    try {
        const res = await fetch('getPublication.php?name=' + name);
        const str = await res.text();
        if (str){
            const problem = document.getElementById('description');
            problem.innerHTML = 'Found succefully !';
            problem.classList.value = "alert alert-success mt-4";
            const user = document.getElementById('publicationRow');
            user.innerHTML = str;
        } else {
            const problem = document.getElementById('description');
            problem.innerHTML = 'Not found !';
            problem.classList.value = "alert alert-danger mt-4";
            const user = document.getElementById('publicationRow');
            user.innerHTML = ' ';
        }

    } catch (err) {
        alert('bug');
    }
}