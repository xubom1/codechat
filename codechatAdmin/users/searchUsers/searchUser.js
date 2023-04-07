async function searchUser(){
    const input = document.getElementById('search');
    const name = input.value;
    try {
        const res = await fetch('searchUser.php?name=' + name);
        const str = await res.text();
        if (str){
            const problem = document.getElementById('description');
            problem.innerHTML = 'Found succefully !';
            problem.classList.value = "alert alert-success mt-4";
            const user = document.getElementById('userRow');
            user.innerHTML = str;
        } else {
            const problem = document.getElementById('description');
            problem.innerHTML = 'Not found !';
            problem.classList.value = "alert alert-danger mt-4";
            const user = document.getElementById('userRow');
            user.innerHTML = ' ';
        }

    } catch (err) {
        alert('bug');
    }
}

function formClick() {
    const test1 = document.getElementById('flexCheck1');
    const test2 = document.getElementById('flexCheck2');
    const test3 = document.getElementById('flexCheck3');
    const test4 = document.getElementById('flexCheck4');
    if (!test1.disabled && !test2.disabled && !test3.disabled && !test4.disabled){
        test1.setAttribute("disabled", " ");
        test2.setAttribute("disabled", " ");
        test3.setAttribute("disabled", " ");
        test4.setAttribute("disabled", " ");
    } else {
        test1.removeAttribute("disabled");
        test2.removeAttribute("disabled");
        test3.removeAttribute("disabled");
        test4.removeAttribute("disabled");
    }
}