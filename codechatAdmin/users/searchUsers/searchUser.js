async function searchUser(){
    const input = document.getElementById('search');
    const name = input.value;
    const del = document.getElementById('tenSub').value;
    console.log(del);
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

function validate(){
    let str = 'searchUser.php?name=name';
    if (flexCheck1.checked == 1){

        console.log(str);
    }
    if (flexCheck2.checked == 1){
        str.concat('&mail=yes');
    }
    if (flexCheck3.checked == 1){
        str.concat('&lastName=yes');
    }
    if (flexCheck4.checked == 1){
        str.concat('&firstName=yes');
    }
    console.log(str);
}